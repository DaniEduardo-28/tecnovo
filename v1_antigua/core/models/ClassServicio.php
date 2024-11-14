<?php

	class ClassServicio extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getCount($estado,$id_tipo_servicio,$valor) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {
				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_servicio` s
								WHERE (s.name_servicio LIKE ? OR s.descripcion_breve LIKE ?) ";

				$parametros[] = $valor;
				$parametros[] = $valor;

				if ($estado!="all") {
					$sql .= " AND s.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_tipo_servicio!="") {
					$sql .= " AND s.id_tipo_servicio = ?";
					$parametros[] = $id_tipo_servicio;
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

		public function show($estado,$id_tipo_servicio,$valor,$offset,$limit) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {
				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT s.*,t.name_tipo,M.name_moneda
								FROM `tb_servicio` s
							  INNER JOIN tb_tipo_servicio t ON t.id_tipo_servicio = s.id_tipo_servicio
								INNER JOIN tb_moneda M ON M.id_moneda = s.id_moneda
								WHERE (s.name_servicio LIKE ? OR s.descripcion_breve LIKE ?) ";
				$parametros[] = $valor;
				$parametros[] = $valor;

				if ($estado!="all") {
					$sql .= " AND s.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_tipo_servicio!="") {
					$sql .= " AND s.id_tipo_servicio = ?";
					$parametros[] = $id_tipo_servicio;
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

		public function getDataEditServicio($id_servicio) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {
				$sql = "SELECT s.*,t.name_tipo
								FROM tb_servicio s
								INNER JOIN tb_tipo_servicio t ON t.id_tipo_servicio = s.id_tipo_servicio
								WHERE  s.id_servicio = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_servicio]);
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

		public function insert($id_servicio,$id_tipo_servicio,$name_servicio,$descripcion_breve,$descripcion_larga,$precio,$estado,$flag_imagen,$src_imagen,$id_moneda,$flag_igv) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$sql = "INSERT INTO tb_servicio (`id_servicio`, `id_tipo_servicio`, `name_servicio`, `descripcion_breve`, `descripcion_larga`, `precio`, `src_imagen`, `estado`, `id_moneda`, `flag_igv`, `signo_moneda`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(s.id_servicio) WHEN 0 THEN 1 ELSE (MAX(s.id_servicio) + 1) end FROM `tb_servicio` s),";
				$sql .= "?,?,?,?,?,?,?,?,?,(SELECT M.signo FROM tb_moneda M WHERE M.id_moneda = ?)";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_tipo_servicio,$name_servicio,$descripcion_breve,$descripcion_larga,$precio,$src_imagen,$estado,$id_moneda,$flag_igv,$id_moneda]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar el producto en la base de datos.");
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

		public function update($id_servicio,$id_tipo_servicio,$name_servicio,$descripcion_breve,$descripcion_larga,$precio,$estado,$flag_imagen,$src_imagen,$id_moneda,$flag_igv) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_servicio` WHERE id_servicio = ?");
				$stmt->execute([$id_servicio]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("1. No se encontró el registro del servicio a editar.");
				}

				$sql = "UPDATE tb_servicio SET ";
				$sql .=" id_tipo_servicio = ?, ";
				$sql .=" name_servicio = ?, ";
				$sql .=" descripcion_breve = ?, ";
				$sql .=" descripcion_larga = ?, ";
				$sql .=" estado = ?, ";
				$sql .=" flag_igv = ?, ";
				$sql .=" id_moneda = ?, ";
				$sql .=" signo_moneda = (SELECT M.signo FROM tb_moneda M WHERE M.id_moneda = ?), ";
				$sql .=" precio = ? ";
				$sql .=" WHERE id_servicio = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_tipo_servicio,$name_servicio,$descripcion_breve,$descripcion_larga,$estado,$flag_igv,$id_moneda,$id_moneda,$precio,$id_servicio])==false) {
					throw new Exception("1. Error al actualizar los datos del producto.");
				}

				if ($flag_imagen=="1") {
					$stmt = $conexion->prepare("UPDATE tb_servicio SET src_imagen = ? WHERE id_servicio = ?");
					if ($stmt->execute([$src_imagen,$id_servicio])==false) {
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

		public function delete($id_servicio) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("DELETE FROM tb_servicio WHERE id_servicio = ?");
				$stmt->execute([$id_servicio]);
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

		public function show_all() {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT s.*,t.name_tipo
								FROM `tb_servicio` s
							  INNER JOIN tb_tipo_servicio t ON t.id_tipo_servicio = s.id_tipo_servicio";
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

		public function show_cantidad_limite_activos($cantidad) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT s.*,t.name_tipo
								FROM `tb_servicio` s
							  INNER JOIN tb_tipo_servicio t ON t.id_tipo_servicio = s.id_tipo_servicio
								WHERE s.estado = 'activo'
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

		public function show_activos() {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT s.*,t.name_tipo
								FROM `tb_servicio` s
							  INNER JOIN tb_tipo_servicio t ON t.id_tipo_servicio = s.id_tipo_servicio
								WHERE s.estado = 'activo'";
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

	$OBJ_SERVICIO = new ClassServicio();

?>
