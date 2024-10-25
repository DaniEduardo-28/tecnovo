<?php

	class ClassDetalleCita extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getDetalleCita($id_cita) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT M.*,C.id_cita,C.id_fundo,C.id_trabajador,C.id_servicio,
									   C.fecha_registro,C.fecha_cita,C.fecha_termino,C.sintoma,C.observaciones,
								       C.mensaje_cita,C.estado AS estado_cita,DC.name_servicio as detalle_name_servicio,
								       DC.motivo as detalle_motivo,DC.sintomas as detalle_sintomas,
								       DC.tratamiento as detalle_tratamiento, DC.vacunas_aplicadas as detalle_vacunas_aplicadas,
								       DC.observaciones as detalle_observaciones,DC.peso as detalle_peso
								FROM vw_mascotas M
								INNER JOIN tb_cita C ON C.id_mascota = M.id_mascota
								INNER JOIN tb_detalle_cita DC ON DC.id_cita = C.id_cita
								WHERE C.id_cita = ?";

				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_cita]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

		public function getHistorialClinico($id_mascota) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT M.*,C.id_cita,C.id_fundo,C.id_trabajador,C.id_servicio,
									   C.fecha_registro,C.fecha_cita,C.fecha_termino,C.sintoma,C.observaciones,
								       C.mensaje_cita,C.estado AS estado_cita,DC.name_servicio as detalle_name_servicio,
								       DC.motivo as detalle_motivo,DC.sintomas as detalle_sintomas,
								       DC.tratamiento as detalle_tratamiento, DC.vacunas_aplicadas as detalle_vacunas_aplicadas,
								       DC.observaciones as detalle_observaciones,DC.peso as detalle_peso,DC.fecha_detalle_cita
								FROM vw_mascotas M
								INNER JOIN tb_cita C ON C.id_mascota = M.id_mascota
								INNER JOIN tb_detalle_cita DC ON DC.id_cita = C.id_cita
								WHERE M.id_mascota = ? AND C.estado = 'atendida' ORDER BY DC.fecha_detalle_cita ASC";

				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_mascota]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

		public function goRegistrarAtencion($id_cita,$peso,$observaciones,$sintomas,$tratamiento,$vacunas,$motivo) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$conexion->beginTransaction();

				$sql = "UPDATE tb_cita SET estado = 'atendida' where id_cita = ?";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_cita])==false) {
					throw new Exception("Ocurrió un error al actualizar el estado de la cita en el sistema.");
				}

				$sql = "UPDATE tb_mascota SET peso = ? where id_mascota = (SELECT id_mascota FROM tb_cita WHERE id_cita = ?)";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$peso,$id_cita])==false) {
					throw new Exception("Ocurrió un error al actualizar el peso de la mascota en el sistema.");
				}

				$sql = "UPDATE tb_detalle_cita SET motivo = ?,sintomas = ?,tratamiento = ?,vacunas_aplicadas = ?,observaciones = ?,peso = ?, fecha_detalle_cita = now() where id_cita = ?";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$motivo,$sintomas,$tratamiento,$vacunas,$observaciones,$peso,$id_cita])==false) {
					throw new Exception("Ocurrió un error al actualizar el estado de la cita en el sistema.");
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

	$OBJ_DETALLE_CITA = new ClassDetalleCita();

?>
