<?php

	class ClassUnidadMedida extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$parametros = null;
				$sql = "SELECT * FROM `tb_unidad_medida` t WHERE 1 = 1 ";
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

		public function insert($id_unidad_medida,$name_unidad,$cod_sunat,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_unidad_medida (id_unidad_medida, name_unidad, cod_sunat, estado) VALUES ((SELECT CASE COUNT(t.id_unidad_medida) WHEN 0 THEN 1 ELSE (MAX(t.id_unidad_medida) + 1) end FROM `tb_unidad_medida` t),?,?,?)");
				$stmt->execute([$name_unidad,$cod_sunat,$estado]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al insertar el registro.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Unidad Medida", "Insertar"]);
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

		public function update($id_unidad_medida,$name_unidad,$cod_sunat,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_unidad_medida SET name_unidad = ?, cod_sunat = ?, estado = ? WHERE id_unidad_medida = ?");
				if ($stmt->execute([$name_unidad,$cod_sunat,$estado,$id_unidad_medida])==false) {
					throw new Exception("Error al actualizar los datos.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Unidad Medida", "Actualizar"]);
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

		public function delete($id_unidad_medida) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_medicamento` WHERE id_unidad_medida = ?");
				$stmt->execute([$id_unidad_medida]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("Esta unidad de medida tiene medicamentos registrados con esta unidad.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_accesorio` WHERE id_unidad_medida = ?");
				$stmt->execute([$id_unidad_medida]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("Esta unidad de medida tiene accesorios registrados con esta unidad.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_unidad_medida WHERE id_unidad_medida = ?");
				$stmt->execute([$id_unidad_medida]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al eliminar el registro.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Unidad Medida", "Eliminar"]);
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

	$OBJ_UNIDAD_MEDIDA = new ClassUnidadMedida();

?>
