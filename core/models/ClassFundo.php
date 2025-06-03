<?php

	class ClassFundo extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($id_empresa, $estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
		
			try {
				$sql = "SELECT * FROM `tb_fundo` WHERE id_empresa = ?";
				$parametros[] = $id_empresa;
		
				if ($estado != "all") {
					$sql .= " AND estado = ?";
					$parametros[] = $estado;
				}
		
				$stmt = $conexion->prepare($sql);
				$stmt->execute($parametros);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
				if (count($result) == 0) {
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
		

		public function getFundoForId($id_fundo) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

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
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_fundo (id_fundo, id_empresa, estado, nombre, cod_ubigeo, direccion, telefono, mapa, token, ruta) VALUES ((SELECT CASE COUNT(c.id_fundo) WHEN 0 THEN 1 ELSE (MAX(c.id_fundo) + 1) end FROM `tb_fundo` c),?,?,?,?,?,?,?,?,?)");
				$stmt->execute([$id_empresa,$estado,$nombre,$cod_ubigeo,$direccion,$telefono,$mapa,$token,$ruta]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar el nuevo fundo.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Fundos", "Insertar"]);
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

		public function update($id_fundo,$id_empresa,$estado,$nombre,$cod_ubigeo,$direccion,$telefono,$mapa,$token,$ruta) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {
				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_fundo SET estado = ?, nombre = ?, cod_ubigeo = ?, direccion = ?, telefono = ?, mapa = ?, token = ?, ruta = ? WHERE id_fundo = ? AND id_empresa = ?");
				if ($stmt->execute([$estado,$nombre,$cod_ubigeo,$direccion,$telefono,$mapa,$token,$ruta,$id_fundo,$id_empresa])==false) {
					throw new Exception("Error al actualizar los datos.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Fundos", "Actualizar"]);
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

		public function delete($id_fundo) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$conexion->beginTransaction();


				$stmt = $conexion->prepare("DELETE FROM tb_fundo  WHERE id_fundo = ?");
				$stmt->execute([$id_fundo]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al eliminar el registro.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Fundos", "Eliminar"]);
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

	$OBJ_FUNDO = new ClassFundo();

?>
