<?php

	class ClassSucursal extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($id_empresa,$estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT * FROM `tb_sucursal` WHERE id_empresa = ? ";
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

		public function getSucursalForId($id_sucursal) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT * FROM `tb_sucursal` WHERE id_sucursal = ? ";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_sucursal]);
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

		public function insert($id_sucursal,$id_empresa,$estado,$nombre,$cod_ubigeo,$direccion,$telefono,$mapa,$token,$ruta) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_sucursal (id_sucursal, id_empresa, estado, nombre, cod_ubigeo, direccion, telefono, mapa, token, ruta) VALUES ((SELECT CASE COUNT(c.id_sucursal) WHEN 0 THEN 1 ELSE (MAX(c.id_sucursal) + 1) end FROM `tb_sucursal` c),?,?,?,?,?,?,?,?,?)");
				$stmt->execute([$id_empresa,$estado,$nombre,$cod_ubigeo,$direccion,$telefono,$mapa,$token,$ruta]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar la nueva sucursal.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Sucursal", "Insertar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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

		public function update($id_sucursal,$id_empresa,$estado,$nombre,$cod_ubigeo,$direccion,$telefono,$mapa,$token,$ruta) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {
				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_sucursal SET estado = ?, nombre = ?, cod_ubigeo = ?, direccion = ?, telefono = ?, mapa = ?, token = ?, ruta = ? WHERE id_sucursal = ? AND id_empresa = ?");
				if ($stmt->execute([$estado,$nombre,$cod_ubigeo,$direccion,$telefono,$mapa,$token,$ruta,$id_sucursal,$id_empresa])==false) {
					throw new Exception("Error al actualizar los datos.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Sucursal", "Actualizar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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

		public function delete($id_sucursal) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_medicamento` WHERE id_sucursal = ?");
				$stmt->execute([$id_sucursal]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("La sucursal tiene medicamentos registrados en lista.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_accesorio` WHERE id_sucursal = ?");
				$stmt->execute([$id_sucursal]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("La sucursal tiene accesorios registrados en lista.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_venta` WHERE id_sucursal = ?");
				$stmt->execute([$id_sucursal]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("La sucursal tiene documentos de venta registrados en el sistema.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_documento_venta` WHERE id_sucursal = ?");
				$stmt->execute([$id_sucursal]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("La sucursal tiene documentos de venta registrados en el sistema.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_trabajador_sucursal  WHERE id_sucursal = ?");
				if ($stmt->execute([$id_sucursal])==false) {
					throw new Exception("Error al eliminar el registro.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_sucursal  WHERE id_sucursal = ?");
				$stmt->execute([$id_sucursal]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al eliminar el registro.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Sucursal", "Eliminar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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
