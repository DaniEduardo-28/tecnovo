<?php

	class ClassMascota extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($id_tipo_mascota,$id_documento,$valor) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT * FROM vw_mascotas WHERE (nombres like ? OR apellidos like ? OR num_documento like ? OR nombre like ?)";
				$parametros[] = $valor;
				$parametros[] = $valor;
				$parametros[] = $valor;
				$parametros[] = $valor;

				if ($id_tipo_mascota!="") {
					$sql .= " AND id_tipo_mascota = ?";
					$parametros[] = $id_tipo_mascota;
				}

				if ($id_documento!="") {
					$sql .= " AND id_documento = ?";
					$parametros[] = $id_documento;
				}

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

		public function showMascotasDocumento($id_documento,$num_documento) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT * FROM vw_mascotas WHERE  num_documento = ? AND id_documento = ? AND estado = 'activo' ";

				$stmt = $conexion->prepare($sql);
				$stmt->execute([$num_documento,$id_documento]);
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

		public function show_mis_mascotas($id_cliente) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT * FROM vw_mascotas WHERE id_cliente = ? ";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_cliente]);
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

		public function getDataEditMascota($id_mascota) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT * FROM vw_mascotas WHERE id_mascota = ?";
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

		public function getVacunasMiMascota($id_mascota) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT v.name_vacuna ,mv.*
								FROM `tb_mascota_vacuna` mv
								INNER JOIN tb_vacuna v on v.id_vacuna = mv.id_vacuna
								WHERE mv.id_mascota = ?";
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

		public function insert($id_mascota,$id_documento,$num_documento,$nombres,$apellidos,$id_tipo_mascota,$nombre_mascota,$raza,$color,$peso,$sexo,$fecha_nacimiento,$observaciones,$estado,$flag_imagen,$src_imagen) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_documento = ? AND num_documento = ?");
				$stmt->execute([$id_documento,$num_documento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$id_persona = 0;

				if (count($result)==0) {

					$sql = "INSERT INTO tb_persona (`id_persona`, `id_documento`, `num_documento`, `nombres`, `apellidos`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(p.id_persona) WHEN 0 THEN 1 ELSE (MAX(p.id_persona) + 1) end FROM `tb_persona` p),";
					$sql .= "?,?,?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_documento,$num_documento,$nombres,$apellidos]);
					if ($stmt->rowCount()==0) {
						throw new Exception("1. Error al registrar los datos del cliente.");
					}

					$sql = "INSERT INTO tb_cliente (`id_cliente`, `id_persona`, `name_user`, `src_imagen`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(p.id_cliente) WHEN 0 THEN 1 ELSE (MAX(p.id_cliente) + 1) end FROM `tb_cliente` p),";
					$sql .= "(SELECT id_persona FROM tb_persona WHERE id_documento = ? AND num_documento = ? ),?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_documento,$num_documento,$num_documento,"resources/global/images/sin_imagen.png"]);
					if ($stmt->rowCount()==0) {
						throw new Exception("1. Error al registrar los datos del cliente.");
					}

				}else {

					$id_persona = $result[0]['id_persona'];

					$sql = "UPDATE tb_persona SET ";
					$sql .=" nombres = ?, ";
					$sql .=" apellidos = ? ";
					$sql .=" WHERE id_persona = ? ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$nombres,$apellidos,$id_persona])==false) {
						throw new Exception("Ocurrió un error al actualizar los datos del cliente.");
					}
				}

				$stmt = $conexion->prepare("SELECT c.id_cliente FROM `tb_persona` p inner join tb_cliente c on c.id_persona = p.id_persona WHERE p.id_documento = ? AND p.num_documento = ?");
				$stmt->execute([$id_documento,$num_documento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$id_cliente = 0;

				if (count($result)==0) {
					throw new Exception("Error al obtener el id del cliente.");
				}

				$id_cliente = $result[0]['id_cliente'];

				$sql = "INSERT INTO tb_mascota (`id_mascota`, `id_cliente`, `id_tipo_mascota`, `nombre`, `raza`, `color`, `peso`, `sexo`, `fecha_nacimiento`, `observaciones`, `estado`, `src_imagen`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(a.id_mascota) WHEN 0 THEN 1 ELSE (MAX(a.id_mascota) + 1) end FROM `tb_mascota` a),";
				$sql .= "?,?,?,?,?,?,?,?,?,?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_cliente,$id_tipo_mascota,$nombre_mascota,$raza,$color,$peso,$sexo,$fecha_nacimiento,$observaciones,$estado,$src_imagen]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al realizar el registro en la base de datos.");
				}

				$stmt = $conexion->prepare("SELECT * FROM tb_vacuna WHERE id_tipo_mascota = ?");
				$stmt->execute([$id_tipo_mascota]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {

					foreach ($result as $key) {

						$fecha_minima = date('Y-m-d', strtotime ( '+' . $key['edad_minima'] . ' day' , strtotime ($fecha_nacimiento)));
						$fecha_maxima = date('Y-m-d', strtotime ( '+' . $key['edad_maxima'] . ' day' , strtotime ($fecha_nacimiento)));

						$stmt = $conexion->prepare("INSERT INTO tb_mascota_vacuna (id_vacuna, id_mascota, fecha_minima, fecha_maxima)
															VALUES (?,(SELECT MAX(id_mascota) FROM tb_mascota),?,?)");
						$stmt->execute([$key['id_vacuna'],$fecha_minima,$fecha_maxima]);
						if ($stmt->rowCount()==0) {
							throw new Exception("Error al registrar la vacuna.");
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

		public function insert_mi_mascota($id_mascota,$id_cliente,$id_tipo_mascota,$nombre_mascota,$raza,$color,$peso,$sexo,$fecha_nacimiento,$observaciones,$estado,$flag_imagen,$src_imagen) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$sql = "INSERT INTO tb_mascota (`id_mascota`, `id_cliente`, `id_tipo_mascota`, `nombre`, `raza`, `color`, `peso`, `sexo`, `fecha_nacimiento`, `observaciones`, `estado`, `src_imagen`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(a.id_mascota) WHEN 0 THEN 1 ELSE (MAX(a.id_mascota) + 1) end FROM `tb_mascota` a),";
				$sql .= "?,?,?,?,?,?,?,?,?,?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_cliente,$id_tipo_mascota,$nombre_mascota,$raza,$color,$peso,$sexo,$fecha_nacimiento,$observaciones,$estado,$src_imagen]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al realizar el registro en la base de datos.");
				}

				$stmt = $conexion->prepare("SELECT * FROM tb_vacuna WHERE id_tipo_mascota = ?");
				$stmt->execute([$id_tipo_mascota]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {

					foreach ($result as $key) {

						$fecha_minima = date('Y-m-d', strtotime ( '+' . $key['edad_minima'] . ' day' , strtotime ($fecha_nacimiento)));
						$fecha_maxima = date('Y-m-d', strtotime ( '+' . $key['edad_maxima'] . ' day' , strtotime ($fecha_nacimiento)));

						$stmt = $conexion->prepare("INSERT INTO tb_mascota_vacuna (id_vacuna, id_mascota, fecha_minima, fecha_maxima)
															VALUES (?,(SELECT MAX(id_mascota) FROM tb_mascota),?,?)");
						$stmt->execute([$key['id_vacuna'],$fecha_minima,$fecha_maxima]);
						if ($stmt->rowCount()==0) {
							throw new Exception("Error al registrar la vacuna.");
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

		public function update($id_mascota,$id_documento,$num_documento,$nombres,$apellidos,$id_tipo_mascota,$nombre_mascota,$raza,$color,$peso,$sexo,$fecha_nacimiento,$observaciones,$estado,$flag_imagen,$src_imagen) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_documento = ? AND num_documento = ?");
				$stmt->execute([$id_documento,$num_documento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$id_persona = 0;

				if (count($result)==0) {

					$sql = "INSERT INTO tb_persona (`id_persona`, `id_documento`, `num_documento`, `nombres`, `apellidos`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(p.id_persona) WHEN 0 THEN 1 ELSE (MAX(p.id_persona) + 1) end FROM `tb_persona` p),";
					$sql .= "?,?,?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_documento,$num_documento,$nombres,$apellidos]);
					if ($stmt->rowCount()==0) {
						throw new Exception("1. Error al registrar los datos del cliente.");
					}

					$sql = "INSERT INTO tb_cliente (`id_cliente`, `id_persona`, `name_user`, `src_imagen`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(p.id_cliente) WHEN 0 THEN 1 ELSE (MAX(p.id_cliente) + 1) end FROM `tb_cliente` p),";
					$sql .= "(SELECT id_persona FROM tb_persona WHERE id_documento = ? AND num_documento = ? ),?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_documento,$num_documento,$num_documento,"resources/global/images/sin_imagen.png"]);
					if ($stmt->rowCount()==0) {
						throw new Exception("1. Error al registrar los datos del cliente.");
					}

				} else {

					$id_persona = $result[0]['id_persona'];

					$sql = "UPDATE tb_persona SET ";
					$sql .=" nombres = ?, ";
					$sql .=" apellidos = ? ";
					$sql .=" WHERE id_persona = ? ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$nombres,$apellidos,$id_persona])==false) {
						throw new Exception("Ocurrió un error al actualizar los datos del cliente.");
					}

				}

				$stmt = $conexion->prepare("SELECT c.id_cliente FROM `tb_persona` p inner join tb_cliente c on c.id_persona = p.id_persona WHERE p.id_documento = ? AND p.num_documento = ?");
				$stmt->execute([$id_documento,$num_documento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$id_cliente = 0;

				if (count($result)==0) {
					throw new Exception("Error al obtener el id del cliente.");
				}

				$id_cliente = $result[0]['id_cliente'];

				$stmt = $conexion->prepare("SELECT * FROM `tb_mascota` WHERE id_mascota = ?");
				$stmt->execute([$id_mascota]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("1. No se encontró el registro a editar.");
				}

				$sql = "UPDATE tb_mascota SET ";
				$sql .=" id_cliente = ?, ";
				$sql .=" id_tipo_mascota = ?, ";
				$sql .=" nombre = ?, ";
				$sql .=" raza = ?, ";
				$sql .=" color = ?, ";
				$sql .=" peso = ?, ";
				$sql .=" sexo = ?, ";
				$sql .=" fecha_nacimiento = ?, ";
				$sql .=" observaciones = ?, ";
				$sql .=" estado = ? ";
				$sql .=" WHERE id_mascota = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_cliente,$id_tipo_mascota,$nombre_mascota,$raza,$color,$peso,$sexo,$fecha_nacimiento,$observaciones,$estado,$id_mascota])==false) {
					throw new Exception("1. Error al actualizar los datos.");
				}

				if ($flag_imagen=="1") {
					$stmt = $conexion->prepare("UPDATE tb_mascota SET src_imagen = ? WHERE id_mascota = ?");
					if ($stmt->execute([$src_imagen,$id_mascota])==false) {
						throw new Exception("Error al registrar la imagen del servicio.");
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

		public function update_mi_mascota($id_mascota,$id_cliente,$id_tipo_mascota,$nombre_mascota,$raza,$color,$peso,$sexo,$fecha_nacimiento,$observaciones,$estado,$flag_imagen,$src_imagen) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_mascota` WHERE id_mascota = ?");
				$stmt->execute([$id_mascota]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("1. No se encontró el registro a editar.");
				}

				if ($result[0]['id_cliente']!=$id_cliente) {
					throw new Exception("No puedes editar esta mascota.");
				}

				$sql = "UPDATE tb_mascota SET ";
				$sql .=" id_cliente = ?, ";
				$sql .=" id_tipo_mascota = ?, ";
				$sql .=" nombre = ?, ";
				$sql .=" raza = ?, ";
				$sql .=" color = ?, ";
				$sql .=" peso = ?, ";
				$sql .=" sexo = ?, ";
				$sql .=" fecha_nacimiento = ?, ";
				$sql .=" observaciones = ?, ";
				$sql .=" estado = ? ";
				$sql .=" WHERE id_mascota = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_cliente,$id_tipo_mascota,$nombre_mascota,$raza,$color,$peso,$sexo,$fecha_nacimiento,$observaciones,$estado,$id_mascota])==false) {
					throw new Exception("1. Error al actualizar los datos.");
				}

				if ($flag_imagen=="1") {
					$stmt = $conexion->prepare("UPDATE tb_mascota SET src_imagen = ? WHERE id_mascota = ?");
					if ($stmt->execute([$src_imagen,$id_mascota])==false) {
						throw new Exception("Error al registrar la imagen del servicio.");
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

		public function delete($id_mascota) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$conexion->beginTransaction();

				$sql = "DELETE tb_cita,tb_detalle_cita
							  FROM tb_cita
								INNER JOIN tb_detalle_cita
								on tb_cita.id_cita = tb_detalle_cita.id_cita
							  where tb_cita.id_mascota = ?";

				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_mascota])==false) {
					throw new Exception("Ocurrió un error al eliminar el registro.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_mascota_vacuna WHERE id_mascota = ?");
				if ($stmt->execute([$id_mascota])==false) {
					throw new Exception("Ocurrió un error al eliminar el registro.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_mascota WHERE id_mascota = ?");
				if ($stmt->execute([$id_mascota])==false) {
					throw new Exception("Ocurrió un error al eliminar el registro.");
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

	$OBJ_MASCOTA = new ClassMascota();

?>
