<?php

	class ClassMetodoEnvio extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$parametros = null;
				$sql = "SELECT * FROM `tb_metodo_envio` m WHERE 1 = 1 ";
				if ($estado!="all") {
					$sql .= " AND m.estado = ?";
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

		public function insert($name_metodo,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_metodo_envio (id_metodo_envio, name_metodo, estado) VALUES ((SELECT CASE COUNT(m.id_metodo_envio) WHEN 0 THEN 1 ELSE (MAX(m.id_metodo_envio) + 1) end FROM `tb_metodo_envio` m),?,?)");
				$stmt->execute([$name_metodo,$estado]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al insertar el registro.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Método de Envìo", "Insertar"]);
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

		public function update($id_metodo_envio,$name_metodo,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_metodo_envio SET name_metodo = ?, estado = ? WHERE id_metodo_envio = ?");
				$stmt->execute([$name_metodo,$estado,$id_metodo_envio]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al actualizar los datos.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Método de Envío", "Actualizar"]);
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

		public function delete($id_metodo_envio) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {
				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_orden_compra` WHERE id_metodo_envio = ?");
				$stmt->execute([$id_metodo_envio]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {
					throw new Exception("No se puede eliminar este registro, se encuentra relacionado con la tabla Orden de Compra.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_metodo_envio WHERE id_metodo_envio = ?");
				$stmt->execute([$id_metodo_envio]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al eliminar el registro.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Método de Envío", "Eliminar"]);
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

	$OBJ_METODO_ENVIO = new ClassMetodoEnvio();

?>
