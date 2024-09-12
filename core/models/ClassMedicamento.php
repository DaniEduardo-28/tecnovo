<?php

	class ClassMedicamento extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getCount($estado,$id_tipo_medicamento,$valor,$id_sucursal) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {
				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_medicamento` m
								WHERE (m.name_medicamento LIKE ?) AND m.id_sucursal = ? ";

				$parametros[] = $valor;
				$parametros[] = $id_sucursal;

				if ($estado!="all") {
					$sql .= " AND m.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_tipo_medicamento!="") {
					$sql .= " AND m.id_tipo_medicamento = ?";
					$parametros[] = $id_tipo_medicamento;
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

		public function show($estado,$id_tipo_medicamento,$valor,$offset,$limit,$id_sucursal) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {
				$valor = "%$valor%";
				$parametros = null;
				$parametros = null;
				$sql = "SELECT a.*,c.name_tipo,u.name_unidad
								FROM `tb_medicamento` a
							  INNER JOIN tb_tipo_medicamento c ON c.id_tipo_medicamento = a.id_tipo_medicamento
								INNER JOIN tb_unidad_medida u ON u.id_unidad_medida = a.id_unidad_medida
								WHERE (a.name_medicamento LIKE ? ) AND a.id_sucursal = ? ";
				$parametros[] = $valor;
				$parametros[] = $id_sucursal;

				if ($estado!="all") {
					$sql .= " AND a.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_tipo_medicamento!="") {
					$sql .= " AND a.id_tipo_medicamento = ?";
					$parametros[] = $id_tipo_medicamento;
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

		public function showReporte($estado,$id_tipo_medicamento,$valor,$id_sucursal) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {
				$valor = "%$valor%";
				$parametros = null;
				$parametros = null;
				$sql = "SELECT a.*,c.name_tipo,u.cod_sunat as name_unidad
								FROM `tb_medicamento` a
							  INNER JOIN tb_tipo_medicamento c ON c.id_tipo_medicamento = a.id_tipo_medicamento
								INNER JOIN tb_unidad_medida u ON u.id_unidad_medida = a.id_unidad_medida
								WHERE (a.name_medicamento LIKE ? ) AND a.id_sucursal = ? ";
				$parametros[] = $valor;
				$parametros[] = $id_sucursal;

				if ($estado!="all") {
					$sql .= " AND a.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_tipo_medicamento!="") {
					$sql .= " AND a.id_tipo_medicamento = ?";
					$parametros[] = $id_tipo_medicamento;
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

		public function getDataEditMedicamento($id_medicamento) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {
				$sql = "SELECT a.*,c.name_tipo
								FROM tb_medicamento a
								INNER JOIN tb_tipo_medicamento c ON c.id_tipo_medicamento = a.id_tipo_medicamento
								WHERE  a.id_medicamento = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_medicamento]);
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

		public function insert($id_medicamento,$id_tipo_medicamento,$name_medicamento,$descripcion,$stock,$stock_minimo,$precio_compra,$precio_venta,$estado,$flag_imagen,$src_imagen,$id_sucursal,$id_unidad_medida,$id_moneda,$flag_igv) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();

				$sql = "INSERT INTO tb_medicamento (`id_medicamento`, `id_tipo_medicamento`, `name_medicamento`, `descripcion`, `stock`, `stock_minimo`, `precio_compra`, `precio_venta`, `estado`, `src_imagen`, `id_sucursal`, `id_unidad_medida`, `id_moneda`, `flag_igv`, `signo_moneda`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(a.id_medicamento) WHEN 0 THEN 1 ELSE (MAX(a.id_medicamento) + 1) end FROM `tb_medicamento` a),";
				$sql .= "?,?,?,?,?,?,?,?,?,?,?,?,?,(SELECT signo FROM tb_moneda WHERE id_moneda = ?)";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_tipo_medicamento,$name_medicamento,$descripcion,$stock,$stock_minimo,$precio_compra,$precio_venta,$estado,$src_imagen, $id_sucursal, $id_unidad_medida, $id_moneda, $flag_igv, $id_moneda]);
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

		public function update($id_medicamento,$id_tipo_medicamento,$name_medicamento,$descripcion,$stock,$stock_minimo,$precio_compra,$precio_venta,$estado,$flag_imagen,$src_imagen,$id_sucursal,$id_unidad_medida,$id_moneda,$flag_igv) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_medicamento` WHERE id_medicamento = ?");
				$stmt->execute([$id_medicamento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("1. No se encontró el registro a editar.");
				}

				$sql = "UPDATE tb_medicamento SET ";
				$sql .=" id_tipo_medicamento = ?, ";
				$sql .=" name_medicamento = ?, ";
				$sql .=" descripcion = ?, ";
				$sql .=" stock = ?, ";
				$sql .=" stock_minimo = ?, ";
				$sql .=" precio_compra = ?, ";
				$sql .=" precio_venta = ?, ";
				$sql .=" estado = ?, ";
				$sql .=" id_sucursal = ?, ";
				$sql .=" id_unidad_medida = ?, ";
				$sql .=" id_moneda = ?, ";
				$sql .=" flag_igv = ?, ";
				$sql .=" signo_moneda = (SELECT signo FROM tb_moneda WHERE id_moneda = ?) ";
				$sql .=" WHERE id_medicamento = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_tipo_medicamento,$name_medicamento,$descripcion,$stock,$stock_minimo,$precio_compra,$precio_venta,$estado,$id_sucursal,$id_unidad_medida,$id_moneda,$flag_igv,$id_moneda,$id_medicamento])==false) {
					throw new Exception("1. Error al actualizar los datos.");
				}

				if ($flag_imagen=="1") {
					$stmt = $conexion->prepare("UPDATE tb_medicamento SET src_imagen = ? WHERE id_medicamento = ?");
					if ($stmt->execute([$src_imagen,$id_medicamento])==false) {
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

		public function delete($id_medicamento) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("DELETE FROM tb_medicamento WHERE id_medicamento = ?");
				$stmt->execute([$id_medicamento]);
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

		public function showLista($estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$parametros = null;
				$sql = "SELECT * FROM `tb_medicamento` WHERE 1=1 ";

				if ($estado!="all") {
					$sql .= " AND estado = ?";
					$parametros[] = $estado;
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

	}

	$OBJ_MEDICAMENTO = new ClassMedicamento();

?>
