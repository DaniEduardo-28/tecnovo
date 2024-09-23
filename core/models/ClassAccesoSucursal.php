<?php

class ClassAccesoSucursal extends Conexion {

	//constructor de la clase
	public function __construct(){

	}

	public function verificarPermiso($id_trabajador,$id_fundo) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = false;

		try {

			$sql = "SELECT * FROM tb_trabajador_sucursal WHERE id_trabajador = ? AND id_fundo = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_trabajador,$id_fundo]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result)==0) {
				throw new Exception("No tienes permiso");
			}

			$VD = true;

		} catch(PDOException $e) {
			$VD = false;
		} catch (Exception $exception) {
			$VD = false;
		} finally {
			$conexionClass->Close();
		}

		return $VD;

	}

	public function getPermisosSucursal($id_trabajador) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$sql = "SELECT  * FROM tb_trabajador_sucursal WHERE id_trabajador = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_trabajador]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("No tiene accesos a sucursales.");
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

	public function getAccesoTrabajadorSucursal($id_fundo) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$sql = "SELECT T.id_trabajador,T.nombres_trabajador,T.apellidos_trabajador,E.name_especialidad,
										 T.flag_medico
							FROM tb_trabajador_sucursal TS
							INNER JOIN vw_trabajadores T ON T.id_trabajador = TS.id_trabajador
							INNER JOIN tb_especialidad E ON E.id_especialidad = T.id_especialidad
							WHERE TS.id_fundo = ? AND T.flag_medico = '1' AND T.estado = 'activo'
							ORDER BY T.apellidos_trabajador ASC";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_fundo]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("No tiene accesos a sucursales.");
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

	public function updateAccesoSucursal($id_trabajador,$datos) {
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("DELETE FROM tb_trabajador_sucursal WHERE id_trabajador = ?");
			$stmt->execute([$id_trabajador]);

			if ($datos != null) {
				foreach ($datos as $key) {
		      foreach ($key as $key1) {
						$stmt = $conexion->prepare("INSERT INTO tb_trabajador_sucursal (id_fundo, id_trabajador) VALUES (?,?)");
						if ($stmt->execute([$key1->id_fundo,$id_trabajador])==false) {
							throw new Exception("Error al actualizar los permisos.");
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

}

	$OBJ_ACCESO_SUCURSAL = new ClassAccesoSucursal();

?>
