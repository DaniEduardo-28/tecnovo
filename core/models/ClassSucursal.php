<?php

	class ClassSucursal extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($id_empresa,$estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$sql = "SELECT * FROM `tb_fundo` WHERE id_empresa = ? ";
				$parametros[] = $id_empresa;
				if ($estado!="all") {
					$sql .= " AND estado = ?";
					$parametros[] = $estado;
				}
				$stmt = $conexion->prepare($sql);
				$stmt->execute($parametros);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron datos.");
				}

				$VD1['error'] = "NO";
				$VD1['message'] = "Success";
				$VD1['data'] = $result;
				$VD = $VD1;

			} catch(PDOException $e) {

				$VD1['error'] = "SI";
				$VD1['message'] = $e->getMessage();
				$VD = $VD1;

			} catch (Exception $exception) {

				$VD1['error'] = "SI";
				$VD1['message'] = $exception->getMessage();
				$VD = $VD1;

    	} finally {
				$conexionClass->Close();
			}

			return $VD;
		}

		public function getSucursalForId($id_fundo) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$sql = "SELECT * FROM `tb_fundo` WHERE id_fundo = ? ";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_fundo]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron datos.");
				}

				$VD1['error'] = "NO";
				$VD1['message'] = "Success";
				$VD1['data'] = $result;
				$VD = $VD1;

			} catch(PDOException $e) {

				$VD1['error'] = "SI";
				$VD1['message'] = $e->getMessage();
				$VD = $VD1;

			} catch (Exception $exception) {

				$VD1['error'] = "SI";
				$VD1['message'] = $exception->getMessage();
				$VD = $VD1;

    	} finally {
				$conexionClass->Close();
			}

			return $VD;
		}

		public function insert($id_fundo,$id_empresa,$estado,$nombre,$cod_ubigeo,$direccion,$telefono,$mapa,$token,$ruta) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_fundo (id_fundo, id_empresa, estado, nombre, cod_ubigeo, direccion, telefono, mapa, token, ruta) VALUES ((SELECT CASE COUNT(c.id_fundo) WHEN 0 THEN 1 ELSE (MAX(c.id_fundo) + 1) end FROM `tb_fundo` c),?,?,?,?,?,?,?,?,?)");
				$stmt->execute([$id_empresa,$estado,$nombre,$cod_ubigeo,$direccion,$telefono,$mapa,$token,$ruta]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar la nueva sucursal.");
				}
				$VD = "OK";
				$conexion->commit();
			} catch(PDOException $e) {
				$conexion->rollBack();
				$VD = $e->getMessage();
			} catch (Exception $exception) {
				$conexion->rollBack();
				$VD = $exception->getMessage();
    	} finally {
				$conexionClass->Close();
			}
			return $VD;
		}

		public function update($id_fundo,$id_empresa,$estado,$nombre,$cod_ubigeo,$direccion,$telefono,$mapa,$token,$ruta) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {
				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_fundo SET estado = ?, nombre = ?, cod_ubigeo = ?, direccion = ?, telefono = ?, mapa = ?, token = ?, ruta = ? WHERE id_fundo = ? AND id_empresa = ?");
				if ($stmt->execute([$estado,$nombre,$cod_ubigeo,$direccion,$telefono,$mapa,$token,$ruta,$id_fundo,$id_empresa])==false) {
					throw new Exception("Error al actualizar los datos.");
				}
				$VD = "OK";
				$conexion->commit();
			} catch(PDOException $e) {
				$conexion->rollBack();
				$VD = $e->getMessage();
			} catch (Exception $exception) {
				$conexion->rollBack();
				$VD = $exception->getMessage();
    	} finally {
				$conexionClass->Close();
			}
			return $VD;
		}

		public function delete($id_fundo) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_medicamento` WHERE id_fundo = ?");
				$stmt->execute([$id_fundo]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("La sucursal tiene medicamentos registrados en lista.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_accesorio` WHERE id_fundo = ?");
				$stmt->execute([$id_fundo]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("La sucursal tiene accesorios registrados en lista.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_venta` WHERE id_fundo = ?");
				$stmt->execute([$id_fundo]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("La sucursal tiene documentos de venta registrados en el sistema.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_documento_venta` WHERE id_fundo = ?");
				$stmt->execute([$id_fundo]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("La sucursal tiene documentos de venta registrados en el sistema.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_trabajador_sucursal  WHERE id_fundo = ?");
				if ($stmt->execute([$id_fundo])==false) {
					throw new Exception("Error al eliminar el registro.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_fundo  WHERE id_fundo = ?");
				$stmt->execute([$id_fundo]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al eliminar el registro.");
				}

				$VD = "OK";
				$conexion->commit();

			} catch(PDOException $e) {
				$conexion->rollBack();
				$VD = $e->getMessage();
			} catch (Exception $exception) {
				$conexion->rollBack();
				$VD = $exception->getMessage();
    	} finally {
				$conexionClass->Close();
			}
			return $VD;
		}

	}

	$OBJ_SUCURSAL = new ClassSucursal();

?>
