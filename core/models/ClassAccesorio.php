<?php

	class ClassAccesorio extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getCount($estado,$id_categoria,$valor,$id_sucursal) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_accesorio` a
								WHERE (a.name_accesorio LIKE ?) AND a.id_sucursal = ? ";

				$parametros[] = $valor;
				$parametros[] = $id_sucursal;

				if ($estado!="all") {
					$sql .= " AND a.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_categoria!="") {
					$sql .= " AND a.id_categoria = ?";
					$parametros[] = $id_categoria;
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

		public function show($estado,$id_categoria,$valor,$offset,$limit,$id_sucursal) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT a.*,c.name_categoria,u.name_unidad
								FROM `tb_accesorio` a
							  INNER JOIN tb_categoria_accesorio c ON c.id_categoria = a.id_categoria
								INNER JOIN tb_unidad_medida u ON u.id_unidad_medida = a.id_unidad_medida
								WHERE (a.name_accesorio LIKE ? ) AND a.id_sucursal = ? ";
				$parametros[] = $valor;
				$parametros[] = $id_sucursal;

				if ($estado!="all") {
					$sql .= " AND a.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_categoria!="") {
					$sql .= " AND a.id_categoria = ?";
					$parametros[] = $id_categoria;
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

		public function showReporte($estado,$id_categoria,$valor,$id_sucursal) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT a.*,c.name_categoria,u.cod_sunat as name_unidad
								FROM `tb_accesorio` a
							  INNER JOIN tb_categoria_accesorio c ON c.id_categoria = a.id_categoria
								INNER JOIN tb_unidad_medida u ON u.id_unidad_medida = a.id_unidad_medida
								WHERE (a.name_accesorio LIKE ? ) AND a.id_sucursal = ? ";
				$parametros[] = $valor;
				$parametros[] = $id_sucursal;

				if ($estado!="all") {
					$sql .= " AND a.estado = ?";
					$parametros[] = $estado;
				}
				if ($id_categoria!="") {
					$sql .= " AND a.id_categoria = ?";
					$parametros[] = $id_categoria;
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

		public function getDataEditAccesorio($id_accesorio) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {
				$sql = "SELECT a.*,c.name_categoria
								FROM tb_accesorio a
								INNER JOIN tb_categoria_accesorio c ON c.id_categoria = a.id_categoria
								WHERE  a.id_accesorio = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_accesorio]);
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

		public function insert($id_accesorio,$id_categoria,$name_accesorio,$descripcion,$stock,$stock_minimo,$precio_compra,$precio_venta,$estado,$flag_imagen,$src_imagen,$id_sucursal,$id_unidad_medida,$id_moneda,$flag_igv) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();

				$sql = "INSERT INTO tb_accesorio (`id_accesorio`, `id_categoria`, `name_accesorio`, `descripcion`, `stock`, `stock_minimo`, `precio_compra`, `precio_venta`, `estado`, `src_imagen`, `id_sucursal`, `id_unidad_medida`, `id_moneda`, `flag_igv`, `signo_moneda`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(a.id_accesorio) WHEN 0 THEN 1 ELSE (MAX(a.id_accesorio) + 1) end FROM `tb_accesorio` a),";
				$sql .= "?,?,?,?,?,?,?,?,?,?,?,?,?,(SELECT signo FROM tb_moneda WHERE id_moneda = ?)";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_categoria,$name_accesorio,$descripcion,$stock,$stock_minimo,$precio_compra,1.00,$estado,$src_imagen,$id_sucursal,$id_unidad_medida,$id_moneda,$flag_igv,$id_moneda]);
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

		public function update($id_accesorio,$id_categoria,$name_accesorio,$descripcion,$stock,$stock_minimo,$precio_compra,$precio_venta,$estado,$flag_imagen,$src_imagen,$id_sucursal,$id_unidad_medida,$id_moneda,$flag_igv) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_accesorio` WHERE id_accesorio = ?");
				$stmt->execute([$id_accesorio]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("1. No se encontró el registro a editar.");
				}

				$sql = "UPDATE tb_accesorio SET ";
				$sql .=" id_categoria = ?, ";
				$sql .=" name_accesorio = ?, ";
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
				$sql .=" WHERE id_accesorio = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_categoria,$name_accesorio,$descripcion,$stock,$stock_minimo,$precio_compra,1.00,$estado,$id_sucursal,$id_unidad_medida,$id_moneda,$flag_igv,$id_moneda,$id_accesorio])==false) {
					throw new Exception("1. Error al actualizar los datos.");
				}

				if ($flag_imagen=="1") {
					$stmt = $conexion->prepare("UPDATE tb_accesorio SET src_imagen = ? WHERE id_accesorio = ?");
					if ($stmt->execute([$src_imagen,$id_accesorio])==false) {
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

		public function delete($id_accesorio) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("DELETE FROM tb_accesorio WHERE id_accesorio = ?");
				$stmt->execute([$id_accesorio]);
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

		public function show_activos($id_sucursal) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$sql = "SELECT a.*,c.name_categoria
								FROM `tb_accesorio` a
							  INNER JOIN tb_categoria_accesorio c ON c.id_categoria = a.id_categoria
								WHERE a.estado = 'activo' AND a.id_sucursal = ? ";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_sucursal]);
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

	$OBJ_ACCESORIO = new ClassAccesorio();

?>
