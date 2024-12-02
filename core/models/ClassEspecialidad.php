<?php

	class ClassEspecialidad extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$parametros = null;
				$sql = "SELECT e.* FROM `tb_especialidad` e WHERE 1 = 1 ";
				if ($estado!="all") {
					$sql .= " AND e.estado = ?";
					$parametros[] = $estado;
				}
				$stmt = $conexion->prepare($sql);
				$stmt->execute($parametros);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron cargos registrados.");
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

		public function insert($name_especialidad,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_especialidad (id_especialidad, name_especialidad, estado) VALUES ((SELECT CASE COUNT(e.id_especialidad) WHEN 0 THEN 1 ELSE (MAX(e.id_especialidad) + 1) end FROM `tb_especialidad` e),?,?)");
				$stmt->execute([$name_especialidad,$estado]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al registrar el cargo de trabajador.");
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

		public function update($id_especialidad,$name_especialidad,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_especialidad SET name_especialidad = ?, estado = ? WHERE id_especialidad = ?");
				if ($stmt->execute([$name_especialidad,$estado,$id_especialidad])==false) {
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

		public function delete($id_especialidad) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_trabajador` WHERE id_especialidad = ?");
				$stmt->execute([$id_especialidad]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {
					throw new Exception("No se puede eliminar este registro, se encuentra relacionado con la tabla trabajadores.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_especialidad WHERE id_especialidad = ?");
				$stmt->execute([$id_especialidad]);
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

	$OBJ_ESPECIALIDAD = new ClassEspecialidad();

?>
