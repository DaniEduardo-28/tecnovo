<?php

	class ClassMascotaVacuna extends Conexion {

		public function showDetalleVacunas($id_mascota) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT mv.*,v.name_vacuna
								FROM tb_mascota_vacuna mv
								INNER JOIN tb_vacuna v ON v.id_vacuna = mv.id_vacuna
								WHERE mv.id_mascota = ? ORDER BY mv.fecha_minima ASC";

				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_mascota]);
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

		public function registrarVacuna($id_mascota_vacuna,$observaciones) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("UPDATE tb_mascota_vacuna SET flag_vacuna = 1, fecha_aplicacion = now(), observaciones = ?,name_user = ?, name_sucursal = ? WHERE id_mascota_vacuna = ?");
				$stmt->execute([$observaciones,$_SESSION['nombres'] . " " . $_SESSION['apellidos'],$_SESSION['nombre_sucursal'],$id_mascota_vacuna]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al registrar la vacuna en el sistema.");
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

		public function goRegistrarVacuna($id_mascota,$id_vacuna,$observaciones) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("INSERT INTO tb_mascota_vacuna (id_vacuna, id_mascota, observaciones, fecha_minima, fecha_maxima, fecha_aplicacion, flag_vacuna, name_user, name_sucursal)
													VALUES (?, ?, ?, now(), now(), now(), 1, ?, ?)");
				$stmt->execute([$id_vacuna,$id_mascota,$observaciones,$_SESSION['name_user'],$_SESSION['nombre_sucursal']]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar la vacuna.");
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

	$OBJ_MASCOTA_VACUNA = new ClassMascotaVacuna();

?>
