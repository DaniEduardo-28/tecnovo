<?php

	class ClassOperador extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getCount($estado,$id_documento,$valor) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {
				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_persona` p
							  INNER JOIN tb_operador c ON c.id_persona = p.id_persona
								WHERE (p.num_documento LIKE ? OR p.nombres LIKE ? OR p.apellidos LIKE ?) ";

				$parametros[] = $valor;
				$parametros[] = $valor;
				$parametros[] = $valor;

				if ($estado!="all") {
					$sql .= " AND c.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_documento!="") {
					$sql .= " AND p.id_documento = ?";
					$parametros[] = $id_documento;
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

		public function show($estado,$id_documento,$valor,$offset,$limit) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {
				$valor = "%$valor%";
				$parametros = null;
				$parametros = null;
				$sql = "SELECT p.*,c.id_operador,c.name_user,
								c.pass_user,c.estado,d.name_documento,c.src_imagen
								FROM `tb_persona` p
								INNER JOIN tb_documento_identidad d ON d.id_documento = p.id_documento
							  INNER JOIN tb_operador c ON c.id_persona = p.id_persona
								WHERE (p.num_documento LIKE ? OR p.nombres LIKE ? OR p.apellidos LIKE ?) ";
				$parametros[] = $valor;
				$parametros[] = $valor;
				$parametros[] = $valor;
				if ($estado!="all") {
					$sql .= " AND c.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_documento!="") {
					$sql .= " AND p.id_documento = ?";
					$parametros[] = $id_documento;
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

		public function getDataEditOperador($id_operador) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {
				$sql = "SELECT p.*,c.id_operador,c.name_user,
								c.pass_user,c.estado,c.src_imagen
								FROM `tb_persona` p
							  INNER JOIN tb_operador c ON c.id_persona = p.id_persona
								WHERE  c.id_operador = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_operador]);
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

		public function insert($id_persona,$id_operador,$id_documento,$num_documento,$nombres,$apellidos,$direccion,$correo,$telefono,$fecha_nacimiento,$sexo,$estado,$flag_imagen,$src_imagen,$name_user,$pass_user) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_documento = ? AND num_documento = ?");
				$stmt->execute([$id_documento,$num_documento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$id_persona = 0;

				if (count($result)>0) {

					$id_persona = $result[0]['id_persona'];

					$stmt = $conexion->prepare("SELECT * FROM `tb_operador` WHERE id_persona = ? ");
					$stmt->execute([$id_persona]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)>0) {
						throw new Exception("El operador ya se encuentra registrado en el sistema.");
					}

					if (trim($correo)!="") {
						$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
						$stmt->execute([$id_persona,$correo]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						if (count($result)>0) {
							throw new Exception("El correo ya se encuentra registrado en el sistema.");
						}
					}

					/* $stmt = $conexion->prepare("SELECT * FROM `tb_operador` WHERE id_persona != ? AND name_user = ? ");
					$stmt->execute([$id_persona,$name_user]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)>0) {
						throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, ingrese otro nombre de usuario.");
					} */

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
						throw new Exception("Ocurrió un error al actualizar los datos del operador.");
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

					/* $stmt = $conexion->prepare("SELECT * FROM `tb_operador` WHERE name_user = ? ");
					$stmt->execute([$name_user]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)>0) {
						throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, intente ingresar otro nombre de usuario.");
					} */

					$sql = "INSERT INTO tb_persona (`id_persona`, `id_documento`, `num_documento`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo`, `fecha_nacimiento`, `sexo`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(p.id_persona) WHEN 0 THEN 1 ELSE (MAX(p.id_persona) + 1) end FROM `tb_persona` p),";
					$sql .= "?,?,?,?,?,?,?,?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_documento,$num_documento,$nombres,$apellidos,$direccion,$telefono,$correo,$fecha_nacimiento,$sexo]);
					if ($stmt->rowCount()==0) {
						throw new Exception("1. Error al registrar los datos del operador.");
					}

					$stmt = $conexion->prepare("SELECT MAX(p.id_persona) as id_persona FROM `tb_persona` p");
					$stmt->execute([]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)==0) {
						throw new Exception("Error al seleccionar el id del operador.");
					}

					$id_persona = $result[0]['id_persona'];

				}

				$sql = "INSERT INTO tb_operador (`id_operador`, `id_persona`, `name_user`, `pass_user`, `fecha_activacion`, `estado`, `src_imagen`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(c.id_operador) WHEN 0 THEN 1 ELSE (MAX(c.id_operador) + 1) end FROM `tb_operador` c),";
				$sql .= "?,?,?,now(),?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_persona,$name_user,$pass_user,$estado,$src_imagen]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar el operador en la base de datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET valor_int = valor_int + 1 where id_parametro = 25";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos de parametros generales.");
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

		public function getDataOperadorForDocumento($id_documento,$num_documento) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {
				$sql = "SELECT p.*,c.id_operador,c.name_user,
								c.pass_user,c.estado,c.src_imagen
								FROM `tb_persona` p
							  INNER JOIN tb_operador c ON c.id_persona = p.id_persona
								WHERE  p.id_documento = ? and p.num_documento = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_documento,$num_documento]);
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

		public function update($id_persona,$id_operador,$id_documento,$num_documento,$nombres,$apellidos,$direccion,$correo,$telefono,$fecha_nacimiento,$sexo,$estado,$flag_imagen,$src_imagen,$name_user,$pass_user) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona = ?");
				$stmt->execute([$id_persona]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("1. No se encontró el registro del operadoor a editar.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_operador` WHERE id_operador = ?");
				$stmt->execute([$id_operador]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("2. No se encontró el registro del operador a editar.");
				}

				if (trim($correo)!="") {
					$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
					$stmt->execute([$id_persona,$correo]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)>0) {
						throw new Exception("El correo ya se encuentra registrado en el sistema.");
					}
				}

				/* $stmt = $conexion->prepare("SELECT * FROM `tb_operador` WHERE id_operador != ? AND name_user = ? ");
				$stmt->execute([$id_operador,$name_user]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, por favor ingrese otro nombre de usuario.");
				} */

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
					throw new Exception("1. Error al actualizar los datos del operador.");
				}

				$sql = "UPDATE tb_operador SET ";
				$sql .=" name_user = ?, ";
				$sql .=" pass_user = ?, ";
				$sql .=" estado = ? ";
				$sql .=" WHERE id_operador = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$name_user,$pass_user,$estado,$id_operador])==false) {
					throw new Exception("2. Error al actualizar los datos del operador.");
				}

				if ($flag_imagen=="1") {
					$stmt = $conexion->prepare("UPDATE tb_operador SET src_imagen = ? WHERE id_operador = ?");
					if ($stmt->execute([$src_imagen,$id_operador])==false) {
						throw new Exception("Error al registrar la imagen del operador.");
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

		public function delete($id_operador) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {
				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_operador` WHERE id_operador = ?");
				$stmt->execute([$id_operador]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				/* if (count($result)>0) {
					throw new Exception("No se puede eliminar este registro, se encuentra relacionado con la tabla Mascotas.");
				} */

				$stmt = $conexion->prepare("DELETE FROM tb_operador WHERE id_operador = ?");
				$stmt->execute([$id_operador]);
				if ($stmt->rowCount()==0) {
					throw new Exception("2. Ocurrió un error al eliminar el registro.");
				}

				$sql = "UPDATE tb_parametros_generales SET valor_int = valor_int - 1 where id_parametro = 25";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos de parametros generales.");
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

	$OBJ_OPERADOR = new ClassOperador();

?>
