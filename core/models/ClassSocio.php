<?php

	class ClassSocio extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getCount($estado,$name_tabla) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_galeria`
								WHERE  name_tabla = ? ";

				$parametros[] = $name_tabla;

				if ($estado!="all") {
					$sql .= " AND estado = ?";
					$parametros[] = $estado;
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

		public function show($estado,$name_tabla,$offset,$limit) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$parametros = null;
				$sql = "SELECT g.*
								FROM `tb_galeria` g
								WHERE g.name_tabla = ? ";

				$parametros[] = $name_tabla;

				if ($estado!="all") {
					$sql .= " AND g.estado = ?";
					$parametros[] = $estado;
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

		public function getDataEditSocio($id) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {
				$sql = "SELECT *
								FROM tb_galeria
								WHERE  id = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id]);
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

		public function insert($id,$titulo,$descripcion,$estado,$flag_imagen,$src_imagen) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$sql = "INSERT INTO tb_galeria (`id`, `titulo`, `descripcion`, `estado`, `src`, `name_tabla`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(a.id) WHEN 0 THEN 1 ELSE (MAX(a.id) + 1) end FROM `tb_galeria` a),";
				$sql .= "?,?,?,?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$titulo,$descripcion,$estado,$src_imagen,"2"]);
				if ($stmt->rowCount()==0) {
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

		public function update($id,$titulo,$descripcion,$estado,$flag_imagen,$src_imagen) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_galeria` WHERE id = ?");
				$stmt->execute([$id]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("1. No se encontró el registro a editar.");
				}

				$sql = "UPDATE tb_galeria SET ";
				$sql .=" titulo = ?, ";
				$sql .=" descripcion = ?, ";
				$sql .=" estado = ? ";
				$sql .=" WHERE id = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$titulo,$descripcion,$estado,$id])==false) {
					throw new Exception("1. Error al actualizar los datos.");
				}

				if ($flag_imagen=="1") {
					$stmt = $conexion->prepare("UPDATE tb_galeria SET src = ? WHERE id = ?");
					if ($stmt->execute([$src_imagen,$id])==false) {
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

		public function delete($id) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("DELETE FROM tb_galeria WHERE id = ?");
				$stmt->execute([$id]);
				if ($stmt->rowCount()==0) {
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

		public function show_cantidad_limite_activos($cantidad) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$parametros = null;
				$sql = "SELECT g.*
								FROM `tb_galeria` g
								WHERE g.name_tabla = 2 AND g.estado = 'activo'
								LIMIT $cantidad";

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

	}

	$OBJ_SOCIO = new ClassSocio();

?>
