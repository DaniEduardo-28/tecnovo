<?php

	class ClassGrupoUsuario extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$parametros = null;
				$sql = "SELECT * FROM `tb_grupo_usuario` g WHERE 1 = 1 ";
				if ($estado!="all") {
					$sql .= " AND g.estado = ?";
					$parametros[] = $estado;
				}
				$stmt = $conexion->prepare($sql);
				$stmt->execute($parametros);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron grupos registrados.");
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

		public function insert($name_grupo,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_grupo_usuario (id_grupo, name_grupo, estado) VALUES ((SELECT CASE COUNT(g.id_grupo) WHEN 0 THEN 1 ELSE (MAX(g.id_grupo) + 1) end FROM `tb_grupo_usuario` g),?,?)");
				$stmt->execute([$name_grupo,$estado]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al registrar el grupo de usuario.");
				}

				$sql = "INSERT INTO tb_acceso_opcion
				(id_grupo,id_opcion,flag_agregar,flag_editar,flag_eliminar,flag_anular,flag_buscar,flag_ver,flag_descargar)
				SELECT (select max(id_grupo) from tb_grupo_usuario),id_opcion,'0','0','0','0','0','0','0'
				FROM tb_opcion";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al registrar los permisos de grupo de usuario.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_usuario`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_usuario'], "Grupo de Usuarios", "Insertar"]);
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

		public function update($id_grupo,$name_grupo,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_grupo_usuario SET name_grupo = ?, estado = ? WHERE id_grupo = ?");
				$stmt->execute([$name_grupo,$estado,$id_grupo]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al actualizar los datos.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_usuario`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_usuario'], "Grupos de Usuarios", "Actualizar"]);
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

		public function delete($id_grupo) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {
				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_trabajador` WHERE id_grupo = ?");
				$stmt->execute([$id_grupo]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {
					throw new Exception("No se puede eliminar este registro, se encuentra relacionado con la tabla trabajadores.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_acceso_opcion WHERE id_grupo = ?");
				$stmt->execute([$id_grupo]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al eliminar los permisos del grupo de usuario.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_grupo_usuario WHERE id_grupo = ?");
				$stmt->execute([$id_grupo]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al eliminar el registro.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_usuario`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_usuario'], "Grupos de Usuarios", "Eliminar"]);
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

	$OBJ_GRUPO_USUARIO = new ClassGrupoUsuario();

?>
