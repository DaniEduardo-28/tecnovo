<?php

	class ClassProveedor extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getCount($estado,$id_documento,$valor) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {
				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_persona` p
							  INNER JOIN tb_proveedor c ON c.id_persona = p.id_persona
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
			$VD = "";

			try {
				$valor = "%$valor%";
				$parametros = null;
				$parametros = null;
				$sql = "SELECT p.*,c.id_proveedor,c.estado,d.name_documento,c.src_imagen
								FROM `tb_persona` p
								INNER JOIN tb_documento_identidad d ON d.id_documento = p.id_documento
							  INNER JOIN tb_proveedor c ON c.id_persona = p.id_persona
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

		public function getDataEditProveedor($id_proveedor) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {
				$sql = "SELECT p.*,c.id_proveedor,c.estado,c.src_imagen
								FROM `tb_persona` p
							  INNER JOIN tb_proveedor c ON c.id_persona = p.id_persona
								WHERE  c.id_proveedor = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_proveedor]);
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

		public function insert($id_persona,$id_proveedor,$id_documento,$num_documento,$nombres,$apellidos,$direccion,$correo,$telefono,$estado,$flag_imagen,$src_imagen) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_documento = ? AND num_documento = ?");
				$stmt->execute([$id_documento,$num_documento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$id_persona = 0;

				if (count($result)>0) {

					$id_persona = $result[0]['id_persona'];

					$stmt = $conexion->prepare("SELECT * FROM `tb_proveedor` WHERE id_persona = ? ");
					$stmt->execute([$id_persona]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)>0) {
						throw new Exception("El proveedor ya se encuentra registrado en el sistema.");
					}

					if (trim($correo)!="") {
						$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
						$stmt->execute([$id_persona,$correo]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						if (count($result)>0) {
							throw new Exception("El correo ya se encuentra registrado en el sistema.");
						}
					}

					$sql = "UPDATE tb_persona SET ";
					$sql .=" nombres = ?, ";
					$sql .=" apellidos = ?, ";
					$sql .=" direccion = ?, ";
					$sql .=" correo = ?, ";
					$sql .=" telefono = ? ";
					$sql .=" WHERE id_persona = ? ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$nombres,$apellidos,$direccion,$correo,$telefono,$id_persona])==false) {
						throw new Exception("Ocurrió un error al actualizar los datos del proveedor.");
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

					$sql = "INSERT INTO tb_persona (`id_persona`, `id_documento`, `num_documento`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo`, `fecha_nacimiento`, `sexo`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(p.id_persona) WHEN 0 THEN 1 ELSE (MAX(p.id_persona) + 1) end FROM `tb_persona` p),";
					$sql .= "?,?,?,?,?,?,?,?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_documento,$num_documento,$nombres,$apellidos,$direccion,$telefono,$correo,date('Y-m-d'),"masculino"]);
					if ($stmt->rowCount()==0) {
						throw new Exception("1. Error al registrar los datos del proveedor.");
					}

					$stmt = $conexion->prepare("SELECT MAX(p.id_persona) as id_persona FROM `tb_persona` p");
					$stmt->execute([]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)==0) {
						throw new Exception("Error al seleccionar el id del proveedor.");
					}

					$id_persona = $result[0]['id_persona'];

				}

				$sql = "INSERT INTO tb_proveedor (`id_proveedor`, `id_persona`, `estado`, `src_imagen`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(c.id_proveedor) WHEN 0 THEN 1 ELSE (MAX(c.id_proveedor) + 1) end FROM `tb_proveedor` c),";
				$sql .= "?,?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_persona,$estado,$src_imagen]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar el proveedor en la base de datos.");
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

		public function getDataProveedorForDocumento($id_documento,$num_documento) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {
				$sql = "SELECT p.*,c.id_proveedor,c.estado,c.src_imagen
								FROM `tb_persona` p
							  INNER JOIN tb_proveedor c ON c.id_persona = p.id_persona
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

		public function update($id_persona,$id_proveedor,$id_documento,$num_documento,$nombres,$apellidos,$direccion,$correo,$telefono,$estado,$flag_imagen,$src_imagen) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona = ?");
				$stmt->execute([$id_persona]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("1. No se encontró el registro del proveedor a editar.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_proveedor` WHERE id_proveedor = ?");
				$stmt->execute([$id_proveedor]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("2. No se encontró el registro del proveedor a editar.");
				}

				if (trim($correo)!="") {
					$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
					$stmt->execute([$id_persona,$correo]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)>0) {
						throw new Exception("El correo ya se encuentra registrado en el sistema.");
					}
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
				$sql .=" telefono = ? ";
				$sql .=" WHERE id_persona = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_documento,$num_documento,$nombres,$apellidos,$direccion,$correo,$telefono,$id_persona])==false) {
					throw new Exception("1. Error al actualizar los datos del proveedor.");
				}

				$sql = "UPDATE tb_proveedor SET ";
				$sql .=" estado = ? ";
				$sql .=" WHERE id_proveedor = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$estado,$id_proveedor])==false) {
					throw new Exception("2. Error al actualizar los datos del proveedor.");
				}

				if ($flag_imagen=="1") {
					$stmt = $conexion->prepare("UPDATE tb_proveedor SET src_imagen = ? WHERE id_proveedor = ?");
					if ($stmt->execute([$src_imagen,$id_proveedor])==false) {
						throw new Exception("Error al registrar la imagen del proveedor.");
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

		public function delete($id_proveedor) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$conexion->beginTransaction();

				// First, get the id_persona associated 
				$stmt = $conexion->prepare("SELECT id_persona FROM tb_proveedor WHERE id_proveedor = ?");
				$stmt->execute([$id_proveedor]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
				if (!$result) {
					throw new Exception("No se encontró el cliente con el ID especificado.");
				}
		
				$id_persona = $result['id_persona'];

				$stmt = $conexion->prepare("DELETE FROM tb_proveedor WHERE id_proveedor = ?");
				$stmt->execute([$id_proveedor]);
				if ($stmt->rowCount()==0) {
					throw new Exception("1. Ocurrió un error al eliminar el registro.");
				}

				// Delete from tb_persona
				$stmt = $conexion->prepare("DELETE FROM tb_persona WHERE id_persona = ?");
				$stmt->execute([$id_persona]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("Ocurrió un error al eliminar el registro de la persona asociada.");
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

		public function addObservacion($id_proveedor,$observacion) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$sql = "INSERT INTO tb_proveedor_observaciones (`id_detalle`, `id_proveedor`, `observacion`, `fecha`, `estado`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(c.id_detalle) WHEN 0 THEN 1 ELSE (MAX(c.id_detalle) + 1) end FROM `tb_proveedor_observaciones` c),";
				$sql .= "?,?,now(),'1'";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_proveedor,$observacion]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar la observación en la base de datos.");
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

		public function showObservacionesProveedor($id_proveedor) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT * FROM tb_proveedor_observaciones WHERE id_proveedor = ? AND estado = '1'";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_proveedor]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron observaciones registradas.");
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

		public function deleteObservacion($id_detalle) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("UPDATE tb_proveedor_observaciones SET estado = '0' WHERE id_detalle = ?");
				$stmt->execute([$id_detalle]);
				if ($stmt->rowCount()==0) {
					throw new Exception("1. Ocurrió un error al eliminar el registro.");
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


		public function getProveedorPorDocumento($numero_documento) {
			$conexion = $this->Open();
			$response = ["error" => "SI", "message" => ""];
	
			try {
				$sql = "SELECT * FROM vw_proveedores WHERE num_documento_proveedor = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$numero_documento]);
	
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) > 0) {
					$response["error"] = "NO";
					$response["data"] = $result;
				} else {
					throw new Exception("Proveedor no encontrado.");
				}
			} catch (PDOException $e) {
				$response["message"] = "Error en la consulta: " . $e->getMessage();
			}
	
			$this->Close();
			return $response;
		}

	}

	$OBJ_PROVEEDOR = new ClassProveedor();

?>
