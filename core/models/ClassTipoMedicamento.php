<?php

	class ClassTipoMedicamento extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$parametros = null;
				$sql = "SELECT * FROM `tb_tipo_medicamento` t WHERE 1 = 1 ";
				if ($estado!="all") {
					$sql .= " AND t.estado = ?";
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

		public function insert($name_tipo,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_tipo_medicamento (id_tipo_medicamento, name_tipo, estado) VALUES ((SELECT CASE COUNT(t.id_tipo_medicamento) WHEN 0 THEN 1 ELSE (MAX(t.id_tipo_medicamento) + 1) end FROM `tb_tipo_medicamento` t),?,?)");
				$stmt->execute([$name_tipo,$estado]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al insertar el registro.");
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

		public function update($id_tipo_medicamento,$name_tipo,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_tipo_medicamento SET name_tipo = ?, estado = ? WHERE id_tipo_medicamento = ?");
				$stmt->execute([$name_tipo,$estado,$id_tipo_medicamento]);
				if ($stmt->rowCount()==0) {
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

		public function delete($id_tipo_medicamento) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {
				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_medicamento` WHERE id_tipo_medicamento = ?");
				$stmt->execute([$id_tipo_medicamento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {
					throw new Exception("No se puede eliminar este registro, se encuentra relacionado con la tabla Productos.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_tipo_medicamento WHERE id_tipo_medicamento = ?");
				$stmt->execute([$id_tipo_medicamento]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al eliminar el registro.");
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

	$OBJ_TIPO_MEDICAMENTO = new ClassTipoMedicamento();

?>
