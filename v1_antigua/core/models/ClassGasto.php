<?php

	class ClassGasto extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getCount($estado,$id_tipo_gasto,$valor) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD= "";

			try {
				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_gasto` s
								WHERE (s.name_gasto LIKE ? OR s.descripcion_gasto LIKE ?) ";

				$parametros[] = $valor;
				$parametros[] = $valor;

				if ($estado!="all") {
					$sql .= " AND s.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_tipo_gasto!="") {
					$sql .= " AND s.id_tipo_gasto = ?";
					$parametros[] = $id_tipo_gasto;
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

		public function show($estado,$id_tipo_gasto,$valor,$offset,$limit) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {
				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT s.*,t.descripcion
								FROM `tb_gasto` s
							  INNER JOIN tb_tipo_gasto t ON t.id_tipo_gasto = s.id_tipo_gasto
								WHERE (s.name_gasto LIKE ? OR s.descripcion_gasto LIKE ?) ";
				$parametros[] = $valor;
				$parametros[] = $valor;

				if ($estado!="all") {
					$sql .= " AND s.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_tipo_gasto!="") {
					$sql .= " AND s.id_tipo_gasto = ?";
					$parametros[] = $id_tipo_gasto;
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

		public function getDataEditGasto($id_gasto) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {
				$sql = "SELECT s.*,t.descripcion
								FROM tb_gasto s
								INNER JOIN tb_tipo_gasto t ON t.id_tipo_gasto = s.id_tipo_gasto
								WHERE  s.id_gasto = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_gasto]);
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

		public function insert($id_gasto,$id_tipo_gasto,$name_gasto,$descripcion_gasto,$estado,$flag_igv) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";
			try {

				$conexion->beginTransaction();

				$sql = "INSERT INTO tb_gasto (`id_gasto`, `id_tipo_gasto`, `name_gasto`, `descripcion_gasto`, `estado`, `flag_igv`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(s.id_gasto) WHEN 0 THEN 1 ELSE (MAX(s.id_gasto) + 1) end FROM `tb_gasto` s),";
				$sql .= "?,?,?,?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_tipo_gasto, $name_gasto, $descripcion_gasto, $estado, $flag_igv]);
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

		public function update($id_gasto,$id_tipo_gasto,$name_gasto,$descripcion_gasto,$estado,$flag_igv) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_gasto` WHERE id_gasto = ?");
				$stmt->execute([$id_gasto]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("1. No se encontró el registro del gasto a editar.");
				}

				$sql = "UPDATE tb_gasto SET ";
				$sql .=" id_tipo_gasto = ?, ";
				$sql .=" name_gasto = ?, ";
				$sql .=" descripcion_gasto = ?, ";
				$sql .=" estado = ?, ";
				$sql .=" flag_igv = ? ";
				$sql .=" WHERE id_gasto = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_tipo_gasto,$name_gasto,$descripcion_gasto,$estado,$flag_igv,$id_gasto])==false) {
					throw new Exception("1. Error al actualizar los datos del producto.");
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

		public function delete($id_gasto) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("DELETE FROM tb_gasto WHERE id_gasto = ?");
				$stmt->execute([$id_gasto]);
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
			$VD="";

			try {

				$sql = "SELECT s.*,t.descripcion
								FROM `tb_gasto` s
							  INNER JOIN tb_tipo_gasto t ON t.id_tipo_gasto = s.id_tipo_gasto";
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
			$VD="";

			try {

				$sql = "SELECT s.*,t.descripcion
								FROM `tb_gasto` s
							  INNER JOIN tb_tipo_gasto t ON t.id_tipo_gasto = s.id_tipo_gasto
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
			$VD="";

			try {

				$sql = "SELECT s.*,t.descripcion
								FROM `tb_gasto` s
							  INNER JOIN tb_tipo_gasto t ON t.id_tipo_gasto = s.id_tipo_gasto
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

	$OBJ_GASTO = new ClassGasto();

?>
