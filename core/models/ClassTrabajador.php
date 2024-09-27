<?php

	class ClassTrabajador extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getCount($estado,$id_documento,$id_grupo,$id_especialidad,$valor) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = null;

			try {
				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_persona` p
							  INNER JOIN tb_trabajador t ON t.id_persona = p.id_persona
								WHERE (p.num_documento LIKE ? OR p.nombres LIKE ? OR p.apellidos LIKE ?) ";

				$parametros[] = $valor;
				$parametros[] = $valor;
				$parametros[] = $valor;

				if ($estado!="all") {
					$sql .= " AND t.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_documento!="") {
					$sql .= " AND p.id_documento = ?";
					$parametros[] = $id_documento;
				}
				if ($id_grupo!="") {
					$sql .= " AND t.id_grupo = ?";
					$parametros[] = $id_grupo;
				}
				if ($id_especialidad!="") {
					$sql .= " AND t.id_especialidad = ?";
					$parametros[] = $id_especialidad;
				}
				$stmt = $conexion->prepare($sql);
				$stmt->execute($parametros);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron datos");
				}else {
					if ($result[0]['cantidad']==0) {
						throw new Exception("No se encontraron datos.");
					}
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

		public function show($estado,$id_documento,$id_grupo,$id_especialidad,$valor,$offset,$limit) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = null;

			try {

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT p.*,t.id_trabajador,t.id_grupo,t.id_especialidad,t.name_user,
								t.pass_user,t.estado,d.name_documento,t.src_imagen,t.descripcion,
								t.link_facebook,t.link_instagram,t.link_twitter
								FROM tb_persona p
								INNER JOIN tb_documento_identidad d ON d.id_documento = p.id_documento
							  INNER JOIN tb_trabajador t ON t.id_persona = p.id_persona
								WHERE (p.num_documento LIKE ? OR p.nombres LIKE ? OR p.apellidos LIKE ?) ";

				$parametros[] = $valor;
				$parametros[] = $valor;
				$parametros[] = $valor;

				if ($estado!="all") {
					$sql .= " AND t.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_documento!="") {
					$sql .= " AND p.id_documento = ?";
					$parametros[] = $id_documento;
				}
				if ($id_grupo!="") {
					$sql .= " AND t.id_grupo = ?";
					$parametros[] = $id_grupo;
				}
				if ($id_especialidad!="") {
					$sql .= " AND t.id_especialidad = ?";
					$parametros[] = $id_especialidad;
				}

				$sql .= " LIMIT $offset, $limit ";

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

		public function listarTrabajadores() {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = null;

			try {

				$sql = "SELECT * FROM vw_trabajadores ORDER BY apellidos_trabajador ASC";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([]);
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

		public function getDataEditTrabajador($id_trabajador) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = null;

			try {
				$sql = "SELECT p.*,t.id_trabajador,t.id_grupo,t.id_especialidad,t.name_user,
								t.pass_user,t.estado,t.src_imagen,t.flag_medico,t.descripcion,
								t.link_facebook,t.link_instagram,t.link_twitter
								FROM `tb_persona` p
							  INNER JOIN tb_trabajador t ON t.id_persona = p.id_persona
								WHERE  t.id_trabajador = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_trabajador]);
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

		public function insert($id_persona,$id_trabajador,$id_grupo,$id_especialidad,$id_documento,$num_documento,$nombres,$apellidos,$direccion,$correo,$telefono,$fecha_nacimiento,$sexo,$estado,$flag_imagen,$src_imagen,$name_user,$pass_user,$flag_medico,$descripcion,$link_facebook,$link_instagram,$link_twitter) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = null;
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_documento = ? AND num_documento = ?");
				$stmt->execute([$id_documento,$num_documento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$id_persona = 0;

				if (count($result)>0) {

					$id_persona = $result[0]['id_persona'];

					$stmt = $conexion->prepare("SELECT * FROM `tb_trabajador` WHERE id_persona = ? ");
					$stmt->execute([$id_persona]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)>0) {
						throw new Exception("El trabajador ya se encuentra registrado en el sistema.");
					}

					if (trim($correo)!="") {
						$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
						$stmt->execute([$id_persona,$correo]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						if (count($result)>0) {
							throw new Exception("El correo ya se encuentra registrado en el sistema.");
						}
					}

					$stmt = $conexion->prepare("SELECT * FROM `tb_trabajador` WHERE id_persona != ? AND name_user = ? ");
					$stmt->execute([$id_persona,$name_user]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)>0) {
						throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, ingrese otro nombre de usuario.");
					}

					$sql = "UPDATE tb_persona SET ";
					$sql .=" nombres = ?, ";
					$sql .=" apellidos = ?, ";
					$sql .=" direccion = ?, ";
					$sql .=" correo = ?, ";
					$sql .=" telefono = ?, ";
					$sql .=" fecha_nacimiento = ?, ";
					$sql .=" sexo = ? ";
					$sql .=" WHERE id_persona = ? ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$nombres,$apellidos,$direccion,$correo,$telefono,$fecha_nacimiento,$sexo,$id_persona])==false) {
						throw new Exception("Ocurrió un error al actualizar los datos del trabajador.");
					}

				}else {

					if (trim($correo)!="") {
						$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE correo = ? ");
						$stmt->execute([$correo]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						if (count($result)>0) {
							throw new Exception("El correo ya se encuentra registrado en el sistema.");
						}
					}

					$stmt = $conexion->prepare("SELECT * FROM `tb_trabajador` WHERE name_user = ? ");
					$stmt->execute([$name_user]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)>0) {
						throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, intente ingresar otro nombre de usuario.");
					}

					$sql = "INSERT INTO tb_persona (`id_persona`, `id_documento`, `num_documento`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo`, `fecha_nacimiento`, `sexo`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(p.id_persona) WHEN 0 THEN 1 ELSE (MAX(p.id_persona) + 1) end FROM `tb_persona` p),";
					$sql .= "?,?,?,?,?,?,?,?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_documento,$num_documento,$nombres,$apellidos,$direccion,$telefono,$correo,$fecha_nacimiento,$sexo]);
					if ($stmt->rowCount()==0) {
						throw new Exception("1. Error al registrar los datos del trabajador.");
					}

					$stmt = $conexion->prepare("SELECT MAX(p.id_persona) as id_persona FROM `tb_persona` p");
					$stmt->execute([]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)==0) {
						throw new Exception("Error al seleccionar el id del trabajador.");
					}

					$id_persona = $result[0]['id_persona'];

				}

				$sql = "INSERT INTO tb_trabajador (`id_trabajador`, `id_persona`, `id_grupo`, `id_especialidad`, `name_user`, `pass_user`, `fecha_activacion`, `estado`, `src_imagen`, `flag_medico`, `descripcion`, `link_facebook`, `link_instagram`, `link_twitter`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(t.id_trabajador) WHEN 0 THEN 1 ELSE (MAX(t.id_trabajador) + 1) end FROM `tb_trabajador` t),";
				$sql .= "?,?,?,?,?,now(),?,?,?,?,?,?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_persona,$id_grupo,$id_especialidad,$name_user,$pass_user,$estado,$src_imagen,$flag_medico,$descripcion,$link_facebook,$link_instagram,$link_twitter]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar el trabajador en la base de datos.");
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

		public function update($id_persona,$id_trabajador,$id_grupo,$id_especialidad,$id_documento,$num_documento,$nombres,$apellidos,$direccion,$correo,$telefono,$fecha_nacimiento,$sexo,$estado,$flag_imagen,$src_imagen,$name_user,$pass_user,$flag_medico,$descripcion,$link_facebook,$link_instagram,$link_twitter) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = null;
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona = ?");
				$stmt->execute([$id_persona]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("1. No se encontró el registro del trabajador a editar.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_trabajador` WHERE id_trabajador = ?");
				$stmt->execute([$id_trabajador]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("2. No se encontró el registro del trabajador a editar.");
				}

				if (trim($correo)!="") {
					$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
					$stmt->execute([$id_persona,$correo]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)>0) {
						throw new Exception("El correo ya se encuentra registrado en el sistema.");
					}
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_trabajador` WHERE id_trabajador != ? AND name_user = ? ");
				$stmt->execute([$id_trabajador,$name_user]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, por favor ingrese otro nombre de usuario.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND id_documento = ? AND num_documento = ?");
				$stmt->execute([$id_persona,$id_documento,$num_documento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {
					throw new Exception("El Número de documento ya se encuentra registrado en el sistema.");
				}

				$sql = "UPDATE tb_persona SET ";
				$sql .=" id_documento = ?, ";
				$sql .=" num_documento = ?, ";
				$sql .=" nombres = ?, ";
				$sql .=" apellidos = ?, ";
				$sql .=" direccion = ?, ";
				$sql .=" correo = ?, ";
				$sql .=" telefono = ?, ";
				$sql .=" fecha_nacimiento = ?, ";
				$sql .=" sexo = ? ";
				$sql .=" WHERE id_persona = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_documento,$num_documento,$nombres,$apellidos,$direccion,$correo,$telefono,$fecha_nacimiento,$sexo,$id_persona])==false) {
					throw new Exception("1. Error al actualizar los datos del trabajador.");
				}

				$sql = "UPDATE tb_trabajador SET ";
				$sql .=" id_grupo = ?, ";
				$sql .=" id_especialidad = ?, ";
				$sql .=" name_user = ?, ";
				$sql .=" pass_user = ?, ";
				$sql .=" flag_medico = ?, ";
				$sql .=" estado = ?, ";
				$sql .=" descripcion = ?, ";
				$sql .=" link_facebook = ?, ";
				$sql .=" link_instagram = ?, ";
				$sql .=" link_twitter = ? ";
				$sql .=" WHERE id_trabajador = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_grupo,$id_especialidad,$name_user,$pass_user,$flag_medico,$estado,$descripcion,$link_facebook,$link_instagram,$link_twitter,$id_trabajador])==false) {
					throw new Exception("2. Error al actualizar los datos del trabajador.");
				}

				if ($flag_imagen=="1") {
					$stmt = $conexion->prepare("UPDATE tb_trabajador SET src_imagen = ? WHERE id_trabajador = ?");
					if ($stmt->execute([$src_imagen,$id_trabajador])==false) {
						throw new Exception("Error al registrar la imagen del cliente.");
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

		public function delete($id_trabajador) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = null;
			try {
				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_cita` WHERE id_trabajador = ?");
				$stmt->execute([$id_trabajador]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {
					throw new Exception("No se puede eliminar este registro, se encuentra relacionado con la tabla Citas.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_trabajador WHERE id_trabajador = ?");
				$stmt->execute([$id_trabajador]);
				if ($stmt->rowCount()==0) {
					throw new Exception("2. Ocurrió un error al eliminar el registro.");
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

		public function getMedicos($estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = null;

			try {

				$parametros = null;
				$sql = "SELECT p.*,t.id_trabajador,t.id_grupo,
				t.name_user,t.pass_user,t.estado,t.src_imagen,t.flag_medico,
				concat(p.apellidos, ' ', p.nombres) as nombres_medico,
				t.link_twitter,t.link_facebook,t.link_instagram,t.descripcion,
				e.name_especialidad
				FROM `tb_persona` p INNER JOIN tb_trabajador t ON t.id_persona = p.id_persona
				WHERE t.flag_medico = 1";

				if ($estado != "all") {
					$sql .= " AND t.estado = ? ";
					$parametros[] = $estado;
				}

				$sql .= " ORDER BY p.apellidos ASC";

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

	}

	$OBJ_TRABAJADOR = new ClassTrabajador();

?>
