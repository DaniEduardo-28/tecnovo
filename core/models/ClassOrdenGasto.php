<?php

	class ClassOrdenGasto extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getCount($id_gasto,$valor,$fecha_inicio,$fecha_fin,$tipo_busqueda) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_orden_gasto` og
								INNER JOIN vw_proveedores p ON p.id_proveedor = og.id_proveedor
								WHERE og.fecha_gasto >= ? AND og.fecha_gasto < ? AND og.id_gasto = ? ";

				$parametros[] = $fecha_inicio;
				$parametros[] = $fecha_fin;
				$parametros[] = $id_gasto;

				if ($tipo_busqueda!='') {
					switch ($tipo_busqueda) {
						case "1":
							$sql .= " AND p.num_documento_proveedor LIKE ? ";
							$parametros[] = $valor;
							break;
						case "2":
							$sql .= " AND p.nombre_proveedor LIKE ? ";
							$parametros[] = $valor;
							break;
						default:
							break;
					}
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

		public function show($id_gasto,$valor,$fecha_inicio,$fecha_fin,$tipo_busqueda,$offset,$limit) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT o.*,p.nombre_proveedor,t.nombres_trabajador,m.name_metodo,mon.signo as signo_moneda,
								(SELECT COUNT(*) FROM tb_orden_gasto AS num_registros,
                                (SELECT SUM(o.precio_unit*o.cantidad_ga) AS total
								FROM `tb_orden_gasto` o
								INNER JOIN tb_moneda mon ON mon.id_moneda = o.id_moneda
								INNER JOIN vw_proveedores p ON p.id_proveedor = o.id_proveedor
								INNER JOIN vw_trabajadores t ON t.id_trabajador = o.id_trabajador
								WHERE o.fecha_gasto >= ? AND o.fecha_gasto < ? AND o.id_gasto = ? ";

				$parametros[] = $fecha_inicio;
				$parametros[] = $fecha_fin;
				$parametros[] = $id_gasto;

				if ($tipo_busqueda!='') {
					switch ($tipo_busqueda) {
						case 1:
							$sql .= " AND p.num_documento_proveedor LIKE ? ";
							$parametros[] = $valor;
							break;
						case 2:
							$sql .= " AND p.nombre_proveedor LIKE ? ";
							$parametros[] = $valor;
							break;
						default:
							break;
					}
				}

				$sql .= " LIMIT $offset, $limit";


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

		public function getCount1($id_gasto,$valor,$fecha_inicio,$fecha_fin,$tipo_busqueda) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_orden_gasto` o
								INNER JOIN vw_proveedores p ON p.id_proveedor = o.id_proveedor
								WHERE o.fecha_gasto >= ? AND o.fecha_gasto < ?
								AND o.id_gasto = ? ";

				$parametros[] = $fecha_inicio;
				$parametros[] = $fecha_fin;
				$parametros[] = $id_gasto;

				if ($tipo_busqueda!='') {
					switch ($tipo_busqueda) {
						case "1":
							$sql .= " AND p.num_documento_proveedor LIKE ? ";
							$parametros[] = $valor;
							break;
						case "2":
							$sql .= " AND p.nombre_proveedor LIKE ? ";
							$parametros[] = $valor;
							break;
						default:
							break;
					}
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

		public function show1($id_gasto,$valor,$fecha_inicio,$fecha_fin,$tipo_busqueda,$offset,$limit) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT o.*,p.nombre_proveedor,t.nombres_trabajador,mon.signo as signo_moneda,
								(SELECT COUNT(*) FROM tb_orden_gasto AS num_registros,
								(SELECT SUM(o.precio_unit*o.cantidad_ga) AS total
								FROM `tb_orden_gasto` o
								INNER JOIN tb_moneda mon ON mon.id_moneda = o.id_moneda
								INNER JOIN vw_proveedores p ON p.id_proveedor = o.id_proveedor
								INNER JOIN vw_trabajadores t ON t.id_trabajador = o.id_trabajador
								WHERE o.fecha_gasto >= ? AND o.fecha_gasto < ? 
								AND o.id_gasto = ? ";

				$parametros[] = $fecha_inicio;
				$parametros[] = $fecha_fin;
				$parametros[] = $id_gasto;

				if ($tipo_busqueda!='') {
					switch ($tipo_busqueda) {
						case 1:
							$sql .= " AND p.num_documento_proveedor LIKE ? ";
							$parametros[] = $valor;
							break;
						case 2:
							$sql .= " AND p.nombre_proveedor LIKE ? ";
							$parametros[] = $valor;
							break;
						default:
							break;
					}
				}

				$sql .= " LIMIT $offset, $limit";

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

		public function getDataEditOrdenGasto($id_orden_gasto) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ?");
				$stmt->execute([$id_orden_gasto]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontró la orden a editar.");
				}

				$sql = "SELECT * FROM vw_orden_gasto
								WHERE id_orden_gasto = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_orden_gasto]);
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

		public function getDataVerOrdenGasto($id_orden_gasto) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD=" ";

			try {

				$sql = "SELECT * FROM vw_orden_gasto
								WHERE id_orden_gasto = ? ";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_orden_gasto]);
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

		public function getCountDetalleParaOrden($id_gasto,$valor) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD=" ";

			try {

				$valor = "%$valor%";
				$sql = "SELECT count(*) as cantidad FROM tb_gasto WHERE id_gasto = ? AND name_gasto LIKE ? ";
						$parametros[] = $id_gasto;
						$parametros[] = $valor;

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

		public function getDataPrintOrdenGasto($id_orden_gasto) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD=" ";

			try {

				$sql = "SELECT * FROM vw_orden_gasto
								WHERE id_orden_gasto = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_orden_gasto]);
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

		public function getDataEditOrdenGastoIngreso($id_orden_gasto) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD=" ";

			try {

				$stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ? ");
				$stmt->execute([$id_orden_gasto]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontró la orden a editar.");
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

		public function showDetalleParaOrden($id_gasto,$tipo,$valor,$offset,$limit) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD=" ";

			try {

				$valor = "%$valor%";
				$sql = "SELECT name_gasto as descripcion,id_gasto as cod_gasto,
										descripcion_gasto as detalle_gasto
										FROM tb_gasto WHERE id_gasto = ? AND name_gasto LIKE ? ";
						$parametros[] = $id_gasto;
						$parametros[] = $valor;

				$sql .= " LIMIT $offset, $limit ";

				$stmt = $conexion->prepare($sql);
				$stmt->execute($parametros);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron datos");
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

		public function insert($id_gasto,$id_orden_gasto,$id_proveedor,$id_trabajador,$codigo_moneda,$fecha_gasto,$observaciones,$detalle_gasto) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD=" ";
			try {

				$conexion->beginTransaction();

				$sql = "INSERT INTO tb_orden_gasto (`id_orden_gasto`, `id_gasto`, `id_proveedor`, `id_trabajador`, `fecha_gasto`, `observaciones`, `id_moneda`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(o.id_orden_gasto) WHEN 0 THEN 1 ELSE (MAX(o.id_orden_gasto) + 1) end FROM `tb_orden_gasto` o),";
				$sql .= "?,?,?,?,?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_gasto,$id_proveedor,$id_trabajador,$fecha_gasto,$observaciones,$codigo_moneda]);
				if ($stmt->rowCount()==0) {
					throw new Exception("1. Error al registrar la orden de compra en la base de datos.");
				}

				foreach ($detalle_gasto as $key) {
					foreach ($key as $key1) {
						$sql = "INSERT INTO tb_detalle_gasto (`id_orden_gasto`, `name_tabla`, `cod_gasto`, `cantidad_solicitada`, `precio_unitario`) VALUES ";
						$sql .= "(";
						$sql .= "(SELECT MAX(o.id_orden_gasto) FROM `tb_orden_gasto` o),";
						$sql .= "?,?,?,?";
						$sql .= ")";
						$stmt = $conexion->prepare($sql);
						$stmt->execute([$key1->name_tabla,$key1->cod_gasto,$key1->cantidad_solicitada,$key1->precio_unitario]);
						if ($stmt->rowCount()==0) {
							throw new Exception("2. Error al registrar la orden de compra en la base de datos.");
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

		public function update($id_gasto,$id_orden_gasto,$id_proveedor,$id_trabajador,$codigo_moneda,$fecha_gasto,$observaciones,$detalle_gasto) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ?");
				$stmt->execute([$id_orden_gasto]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontró la orden a editar.");
				}

				$sql = "UPDATE tb_orden_gasto SET ";
				$sql .=" id_proveedor = ?, ";
				$sql .=" id_trabajador = ?, ";
				$sql .=" fecha_gasto = ?, ";
				$sql .=" id_moneda = ?, ";
				$sql .=" observaciones = ? ";
				$sql .=" WHERE id_orden_gasto = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_proveedor,$id_trabajador,$fecha_gasto,$codigo_moneda,$observaciones,$id_orden_gasto])==false) {
					throw new Exception("1. Error al actualizar los datos de la orden de gasto.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_detalle_gasto WHERE id_orden_gasto = ?");
				$stmt->execute([$id_orden_gasto]);
				if ($stmt->rowCount()==0) {
					throw new Exception("2. Ocurrió un error al actualizar el detalle del gasto.");
				}

				foreach ($detalle_gasto as $key) {
					foreach ($key as $key1) {
						$sql = "INSERT INTO tb_detalle_gasto (`id_orden_gasto`, `name_tabla`, `cod_gasto`, `cantidad_solicitada`, `precio_unitario`) VALUES ";
						$sql .= "(";
						$sql .= "?,?,?,?,?,?,?";
						$sql .= ")";
						$stmt = $conexion->prepare($sql);
						$stmt->execute([$id_orden_gasto,$key1->name_tabla,$key1->cod_gasto,$key1->cantidad_solicitada,$key1->precio_unitario]);
						if ($stmt->rowCount()==0) {
							throw new Exception("3. Error al registrar la orden de gasto en la base de datos.");
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

		public function delete($id_orden_gasto) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD=" ";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ? ");
				$stmt->execute([$id_orden_gasto]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontró la orden a anular.");
				}

				$stmt = $conexion->prepare("UPDATE tb_orden_gasto WHERE id_orden_gasto = ?");
				$stmt->execute([$id_orden_gasto]);
				if ($stmt->rowCount()==0) {
					throw new Exception("2. Ocurrió un error al anular la orden de Compra.");
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

	$OBJ_ORDEN_GASTO = new ClassOrdenGasto();

?>
