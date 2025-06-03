<?php

class ClassTrabajadorServicio extends Conexion {

	//constructor de la clase
	public function __construct(){

	}

	public function show($id_trabajador) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = null;

		try {

			$sql = "SELECT T.*,S.name_servicio,S.precio,S.signo_moneda,S.flag_igv FROM tb_trabajador_servicio T INNER JOIN tb_servicio S ON S.id_servicio = T.id_servicio WHERE T.id_trabajador = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_trabajador]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("No tiene accesos a servicios.");
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

	public function updateTrabajadorServicio($id_trabajador,$datos) {
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = null;
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("DELETE FROM tb_trabajador_servicio WHERE id_trabajador = ?");
			$stmt->execute([$id_trabajador]);

			if ($datos != null) {
				foreach ($datos as $key) {
		      foreach ($key as $key1) {
						$stmt = $conexion->prepare("INSERT INTO tb_trabajador_servicio (id_servicio, id_trabajador) VALUES (?,?)");
						if ($stmt->execute([$key1->id_servicio,$id_trabajador])==false) {
							throw new Exception("Error al actualizar los permisos.");
						}
		      }
		    }
			}

			$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Trabajador Servicio", "Actualizar"]);
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

	$OBJ_TRABAJADOR_SERVICIO = new ClassTrabajadorServicio();

?>
