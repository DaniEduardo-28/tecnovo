<?php

	class ClassMaquinaria extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$parametros = null;
				$sql = "SELECT * FROM `tb_maquinaria` t WHERE 1 = 1 ";
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

			} catch(Exception $e) {
				$VD1['error'] = "SI";
				$VD1['message'] = $e->getMessage();
				$VD = $VD1;

    	} finally {
				$conexionClass->Close();
			}

			return $VD;
		}

		public function insert($descripcion,$observaciones,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_maquinaria (id_maquinaria, descripcion, observaciones, estado) VALUES ((SELECT CASE COUNT(t.id_maquinaria) WHEN 0 THEN 1 ELSE (MAX(t.id_maquinaria) + 1) end FROM `tb_maquinaria` t),?,?,?)");
				$stmt->execute([$descripcion, $observaciones,$estado]);
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

		public function update($id_maquinaria,$descripcion,$observaciones,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_maquinaria SET descripcion = ?, observaciones = ?, estado = ? WHERE id_maquinaria = ?");
				$stmt->execute([$descripcion,$observaciones,$estado,$id_maquinaria]);
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

		public function delete($id_maquinaria) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {
				$conexion->beginTransaction();

				$stmt = $conexion->prepare("DELETE FROM tb_maquinaria WHERE id_maquinaria = ?");
				$stmt->execute([$id_maquinaria]);
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

	$OBJ_MAQUINARIA = new ClassMaquinaria();

?>
