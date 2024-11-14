<?php

class ClassAccesoOpcion extends Conexion {

	//constructor de la clase
	public function __construct(){

	}

	public function getPermitsOptions($id_grupo,$id_option) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$stmt = $conexion->prepare("SELECT * FROM tb_acceso_opcion WHERE id_opcion = ? AND id_grupo = ?");
			$stmt->execute([$id_option,$id_grupo]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("Ocurrió un error al verificar los permisos");
			}

			$flag_agregar = $result[0]['flag_agregar'];
			$flag_buscar = $result[0]['flag_buscar'];
			$flag_editar = $result[0]['flag_editar'];
			$flag_eliminar = $result[0]['flag_eliminar'];
			$flag_anular = $result[0]['flag_anular'];
			$flag_ver = $result[0]['flag_ver'];
			$flag_descargar = $result[0]['flag_descargar'];

			$options[] =array(
				"error" => "NO",
				"flag_agregar" => $flag_agregar,
				"flag_buscar" => $flag_buscar,
				"flag_editar" => $flag_editar,
				"flag_eliminar" => $flag_eliminar,
				"flag_anular" => $flag_anular,
				"flag_ver" => $flag_ver,
				"flag_descargar" => $flag_descargar,
			);

			$VD = $options;

		} catch(PDOException $e) {

			$options[] =array(
				"error" => "SI",
				"message" => $e->getMessage(),
			);
			$VD = $options;

		} catch (Exception $exception) {

			$options[] =array(
				"error" => "SI",
				"message" => $exception->getMessage(),
			);
			$VD = $options;

		} finally {
			$conexionClass->Close();
		}

		return $VD;

	}

	public function checkOptionController($id_grupo,$id_option) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$stmt = $conexion->prepare("SELECT A.* FROM tb_acceso_opcion A
																	INNER JOIN tb_opcion O ON O.id_opcion = A.id_opcion
																	WHERE A.id_opcion = ? AND A.id_grupo = ? AND O.estado = 'activo'");
			$stmt->execute([$id_option,$id_grupo]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("Ocurrió un error al verificar los permisos");
			}

			$flag_agregar = $result[0]['flag_agregar'];
			$flag_buscar = $result[0]['flag_buscar'];
			$flag_editar = $result[0]['flag_editar'];
			$flag_eliminar = $result[0]['flag_eliminar'];
			$flag_anular = $result[0]['flag_anular'];
			$flag_ver = $result[0]['flag_ver'];
			$flag_descargar = $result[0]['flag_descargar'];

			if ($flag_agregar || $flag_buscar || $flag_editar || $flag_eliminar || $flag_anular || $flag_ver || $flag_descargar) {
				$VD = true;
			} else {
				$VD = false;
			}

		} catch(PDOException $e) {

			$VD = false;

		} catch (Exception $exception) {

			$VD = false;

		} finally {
			$conexionClass->Close();
		}

		return $VD;

	}

	public function getModulos() {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$stmt = $conexion->prepare("SELECT * FROM tb_opcion WHERE estado = 'activo' AND id_opcion MOD 100 = 0 order by id_opcion asc");
			$stmt->execute([]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("No se encontraron opciones para mostrar, posiblemete se encuentren deshalitadas por el área de sistemas.");
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

	public function getOpcionesSistema($id_modulo,$id_grupo) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$id_modulo_fin = $id_modulo + 100;
			$sql = "SELECT a.*,op.name_opcion FROM tb_acceso_opcion a
							INNER JOIN tb_grupo_usuario gu ON a.id_grupo = gu.id_grupo
							INNER JOIN tb_opcion op ON a.id_opcion = op.id_opcion
							WHERE op.estado = 'activo' AND
										a.id_opcion > ? AND
										a.id_opcion < ? AND
										a.id_grupo = ?
							ORDER BY id_opcion asc";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_modulo,$id_modulo_fin,$id_grupo]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("No se encontraron opciones para mostrar, posiblemete se encuentren deshalitadas por el área de sistemas.");
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

	public function updatePermisos($id_grupo,$datos) {
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;
		try {

			$conexion->beginTransaction();

			foreach ($datos as $key) {
	      foreach ($key as $key1) {
					$stmt = $conexion->prepare("UPDATE tb_acceso_opcion SET flag_agregar = ?, flag_editar = ?, flag_eliminar = ?, flag_anular = ?, flag_buscar = ?, flag_ver = ?, flag_descargar = ? WHERE id_grupo = ? AND id_opcion = ?");
					if ($stmt->execute([$key1->flag_agregar,$key1->flag_editar,$key1->flag_eliminar,$key1->flag_anular,$key1->flag_buscar,$key1->flag_ver,$key1->flag_descargar,$id_grupo,$key1->id_opcion])==false) {
						throw new Exception("Error al actualizar los permisos.");
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

	$OBJ_ACCESO_OPCION = new ClassAccesoOpcion();

?>
