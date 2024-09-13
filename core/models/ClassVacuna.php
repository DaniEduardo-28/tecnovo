<?php

	class ClassVacuna extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($id_tipo_mascota,$estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = null;

			try {

				$parametros = null;
				$sql = "SELECT v.*,t.name_tipo
							 FROM tb_vacuna v
							 INNER JOIN tb_tipo_mascota t ON t.id_tipo_mascota = v.id_tipo_mascota
							 WHERE 1=1 ";
				if ($estado!="all") {
					$sql .= " AND v.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_tipo_mascota!="all") {
					$sql .= " AND v.id_tipo_mascota = ?";
					$parametros[] = $id_tipo_mascota;
				}
				$stmt = $conexion->prepare($sql);
				$stmt->execute($parametros);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron vacunas registradas.");
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

		public function insert($id_vacuna,$id_tipo_mascota,$name_vacuna,$descripcion,$edad_minima,$edad_maxima,$estado,$tipo) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = null;
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("INSERT INTO tb_vacuna (id_vacuna, id_tipo_mascota, name_vacuna, descripcion, edad_minima, edad_maxima, tipo, estado) VALUES ((SELECT CASE COUNT(c.id_vacuna) WHEN 0 THEN 1 ELSE (MAX(c.id_vacuna) + 1) end FROM `tb_vacuna` c),?,?,?,?,?,?,?)");
				$stmt->execute([$id_tipo_mascota,$name_vacuna,$descripcion,$edad_minima,$edad_maxima,$tipo,$estado]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar la vacuna.");
				}

				if ($tipo=="1") {

					$stmt = $conexion->prepare("SELECT * FROM `tb_mascota` WHERE id_tipo_mascota = ?");
					$stmt->execute([$id_tipo_mascota]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

					if (count($result)>0) {

						foreach ($result as $key) {

							$fecha_nacimiento = $key['fecha_nacimiento'];
							$fecha_minima = date('Y-m-d', strtotime ( '+' . $edad_minima . ' day' , strtotime ($fecha_nacimiento)));
							$fecha_maxima = date('Y-m-d', strtotime ( '+' . $edad_maxima . ' day' , strtotime ($fecha_nacimiento)));

							$stmt = $conexion->prepare("INSERT INTO tb_mascota_vacuna (id_vacuna, id_mascota, fecha_minima, fecha_maxima)
																VALUES ((SELECT MAX(c.id_vacuna) FROM `tb_vacuna` c),
																?,?,?)");
							$stmt->execute([$key['id_mascota'],$fecha_minima,$fecha_maxima]);
							if ($stmt->rowCount()==0) {
								throw new Exception("Error al registrar la vacuna.");
							}

						}

					}

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

		public function update($id_vacuna,$id_tipo_mascota,$name_vacuna,$descripcion,$edad_minima,$edad_maxima,$estado,$tipo) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = null;
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_vacuna SET id_tipo_mascota = ?, name_vacuna = ?, descripcion = ?, edad_minima = ?, edad_maxima = ?, estado = ?, tipo = ? WHERE id_vacuna = ?");
				if ($stmt->execute([$id_tipo_mascota,$name_vacuna,$descripcion,$edad_minima,$edad_maxima,$estado,$tipo,$id_vacuna])==false) {
					throw new Exception("Error al actualizar los datos.");
				}

				if ($tipo=="1") {

					$stmt = $conexion->prepare("SELECT * FROM `tb_mascota` WHERE id_tipo_mascota = ?");
					$stmt->execute([$id_tipo_mascota]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

					if (count($result)>0) {

						foreach ($result as $key) {

							$fecha_nacimiento = $key['fecha_nacimiento'];
							$fecha_minima = date('Y-m-d', strtotime ( '+' . $edad_minima . ' day' , strtotime ($fecha_nacimiento)));
							$fecha_maxima = date('Y-m-d', strtotime ( '+' . $edad_maxima . ' day' , strtotime ($fecha_nacimiento)));

							$stmt = $conexion->prepare("SELECT * FROM `tb_mascota_vacuna` WHERE id_mascota = ? and id_vacuna = ?");
							$stmt->execute([$key['id_mascota'],$id_vacuna]);
							$result1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

							if (count($result1)==0) {
								$stmt = $conexion->prepare("INSERT INTO tb_mascota_vacuna (id_vacuna, id_mascota, fecha_minima, fecha_maxima)
																	VALUES (?,?,?,?)");
								$stmt->execute([$id_vacuna,$key['id_mascota'],$fecha_minima,$fecha_maxima]);
								if ($stmt->rowCount()==0) {
									throw new Exception("Error al modificar los datos de la vacuna.");
								}
							}

						}

					}

				}else {

					$stmt = $conexion->prepare("DELETE FROM tb_mascota_vacuna WHERE id_vacuna = ? AND flag_vacuna = 0");
					if ($stmt->execute([$id_vacuna])==false) {
						throw new Exception("Error al modificar los datos de la vacuna.");
					}

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

		public function delete($id_vacuna) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = null;

			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_mascota_vacuna` WHERE id_vacuna = ?");
				$stmt->execute([$id_vacuna]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {
					throw new Exception("La vacuna que intenta eliminar se encuentra relacionada con la tabla vacunas de mascotas.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_vacuna  WHERE id_vacuna = ?");
				$stmt->execute([$id_vacuna]);
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

	$OBJ_VACUNA = new ClassVacuna();

?>
