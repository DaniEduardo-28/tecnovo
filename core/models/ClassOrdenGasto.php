<?php
class ClassOrdenGasto extends Conexion
{

	// Constructor
	public function __construct()
	{

	}

	public function getCount($valor,$fecha_inicio,$fecha_fin,$tipo_busqueda) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

			$valor = "%$valor%";
			$parametros = null;
			$sql = "SELECT COUNT(*) as cantidad FROM `tb_orden_gasto` o
							INNER JOIN vw_proveedores p ON p.id_proveedor = o.id_proveedor
							WHERE o.fecha_gasto>= ? AND o.fecha_gasto < ? ";

			$parametros[] = $fecha_inicio;
			$parametros[] = $fecha_fin;

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

	public function show($valor,$fecha_inicio,$fecha_fin,$tipo_busqueda,$offset,$limit) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

			$valor = "%$valor%";
			$parametros = null;
			$sql = "SELECT o.*,p.nombre_proveedor,mon.signo as signo_moneda,
							(SELECT COUNT(*) FROM tb_detalle_gasto dc WHERE dc.id_orden_gasto = o.id_orden_gasto) AS num_registros,
							(SELECT SUM(dc.precio_unitario*dc.cantidad) FROM tb_detalle_gasto dc WHERE dc.id_orden_gasto = o.id_orden_gasto) AS sub_total
							FROM `tb_orden_gasto` o
							INNER JOIN tb_moneda mon ON mon.id_moneda = o.id_moneda
							INNER JOIN vw_proveedores p ON p.id_proveedor = o.id_proveedor
							WHERE o.fecha_gasto >= ? AND o.fecha_gasto < ? ";

			$parametros[] = $fecha_inicio;
			$parametros[] = $fecha_fin;

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
	
	public function getCount1($valor,$fecha_inicio,$fecha_fin,$tipo_busqueda) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

			$valor = "%$valor%";
			$parametros = null;
			$sql = "SELECT COUNT(*) as cantidad FROM `tb_orden_gasto` o
							INNER JOIN vw_proveedores p ON p.id_proveedor = o.id_proveedor
							WHERE o.fecha_gasto>= ? AND o.fecha_gasto < ? ";


			$parametros[] = $fecha_inicio;
			$parametros[] = $fecha_fin;

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

	public function show1($valor,$fecha_inicio,$fecha_fin,$tipo_busqueda,$offset,$limit) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

			$valor = "%$valor%";
			$parametros = null;
			$sql = "SELECT o.*,p.nombre_proveedor,mon.signo as signo_moneda,
							(SELECT COUNT(*) FROM tb_detalle_gasto dc WHERE dc.id_orden_gasto = o.id_orden_gasto) AS num_registros,
							(SELECT SUM((dc.precio_unitario * dc.cantidad - dc.descuento) - ((dc.precio_unitario * dc.cantidad - dc.descuento) * dc.igv)) FROM tb_detalle_gasto dc WHERE dc.id_orden_gasto = o.id_orden_gasto)  AS total
							FROM `tb_orden_gasto` o
							INNER JOIN tb_moneda mon ON mon.id_moneda = o.id_moneda
							INNER JOIN vw_proveedores p ON p.id_proveedor = o.id_proveedor
							WHERE o.fecha_gasto >= ? AND o.fecha_gasto < ? ";


			$parametros[] = $fecha_inicio;
			$parametros[] = $fecha_fin;

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

	public function getDataEditOrdenCompra($id_orden_gasto) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ? ");
			$stmt->execute([$id_orden_gasto]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("No se encontró la orden a editar, o ya fue cambiada de estado.");
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

	public function getDataVerOrdenCompra($id_orden_gasto) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

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

	public function getCountDetalleParaOrden($tipo,$valor) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$valor = "%$valor%";
			$sql = "";
			$parametros = null;
			switch ($tipo) {
				case 'servicio':
					$sql .= "SELECT count(*) as cantidad FROM tb_servicio WHERE name_servicio LIKE ? ";
					$parametros[] = $valor;
					break;
				case 'producto':
					$sql .= "SELECT count(*) as cantidad FROM tb_gasto WHERE name_gasto LIKE ? ";
					$parametros[] = $valor;
					break;
				default:
					throw new Exception("Error al validar la busqueda de la tabla.");
					break;
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

	public function getDataPrintOrdenCompra($id_orden_gasto) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

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

	public function getDataEditOrdenCompraIngreso($id_orden_gasto) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ? ");
			$stmt->execute([$id_orden_gasto]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("No se encontró la orden a editar, o ya fue cambiada de estado.");
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

	public function showDetalleParaOrden($tipo,$valor,$offset,$limit) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$valor = "%$valor%";
			$sql = "";
			$parametros = null;
			switch ($tipo) {
				case 'servicio':
					$sql .= "SELECT name_servicio as descripcion,id_servicio as cod_producto
									FROM tb_servicio WHERE name_servicio LIKE ? ";
					$parametros[] = $valor;
					break;
				case 'producto':
					$sql .= "SELECT name_gasto as descripcion,id_gasto as cod_producto
									FROM tb_gasto WHERE name_gasto LIKE ? ";
					$parametros[] = $valor;
					break;
				default:
					throw new Exception("Error al validar la busqueda de la tabla.");
					break;
			}

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

	public function insert($id_orden_gasto,$id_documento_venta,$id_proveedor,$id_moneda,$fecha_gasto,$serie,$correlativo,$descuento_total,$sub_total,$igv_total,$monto_total,$monto_recibido,$vuelto,$detalle_gasto) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {

			$conexion->beginTransaction();

			$sql = "INSERT INTO tb_orden_gasto (`id_orden_gasto`, `id_documento_venta`, `id_proveedor`, `id_moneda`, `fecha_gasto`, `serie`, `correlativo`, `descuento_total`, `sub_total`, `igv_total`, `monto_total`, `monto_recibido`, `vuelto`) VALUES ";
			$sql .= "(";
			$sql .= "(SELECT CASE COUNT(o.id_orden_gasto) WHEN 0 THEN 1 ELSE (MAX(o.id_orden_gasto) + 1) end FROM `tb_orden_gasto` o),";
			$sql .= "?,?,?,?,?,?,?,?,?,?,?,?";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_documento_venta,$id_proveedor,$id_moneda,$fecha_gasto,$serie,$correlativo,$descuento_total,$sub_total,$igv_total,$monto_total,$monto_recibido,$vuelto]);
			if ($stmt->rowCount()==0) {
				throw new Exception("1. Error al registrar la orden de gasto en la base de datos.");
			}

			foreach ($detalle_gasto as $key) {
				foreach ($key as $key1) {
					$sql = "INSERT INTO tb_detalle_gasto (`id_orden_gasto`, `name_tabla`, `cod_producto`, `cantidad`, `precio_unitario`, `descuento`, `sub_total`, `tipo_igv`, `igv`, `total`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT MAX(o.id_orden_gasto) FROM `tb_orden_gasto` o),";
					$sql .= "?,?,?,?,?,?,?,?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$key1->name_tabla,$key1->cod_producto,$key1->cantidad,'0',$key1->precio_unitario,$key1->descuento,$key1->sub_total,$key1->tipo_igv,$key1->igv,$key1->total]);
					if ($stmt->rowCount()==0) {
						throw new Exception("2. Error al registrar la orden de gasto en la base de datos.");
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

	public function update($id_orden_gasto,$id_documento_venta,$id_proveedor,$id_moneda,$fecha_gasto,$serie,$correlativo,$descuento_total,$sub_total,$igv_total,$monto_total,$monto_recibido,$vuelto,$detalle_gasto) {
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ? ");
			$stmt->execute([$id_orden_gasto]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("No se encontró la orden a editar.");
			}

			$sql = "UPDATE tb_orden_gasto SET ";
			$sql .=" id_documento_venta = ?, ";
			$sql .=" id_proveedor = ?, ";
			$sql .=" id_moneda = ?, ";
			$sql .=" fecha_gasto = ?, ";
			$sql .=" serie = ?, ";
			$sql .=" correlativo = ? ";
			$sql .=" descuento_total = ?, ";
			$sql .=" sub_total = ?, ";
			$sql .=" igv_total = ? ";
			$sql .=" monto_total = ?, ";
			$sql .=" monto_recibido = ?, ";
			$sql .=" vuelto = ? ";
			$sql .=" WHERE id_orden_gasto = ? ";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([$id_documento_venta,$id_proveedor,$id_moneda,$fecha_gasto,$serie,$correlativo,$descuento_total,$sub_total,$igv_total,$monto_total,$monto_recibido,$vuelto,$id_orden_gasto])==false) {
				throw new Exception("1. Error al actualizar los datos de la orden de gasto.");
			}

			$stmt = $conexion->prepare("DELETE FROM tb_detalle_gasto WHERE id_orden_gasto = ?");
			$stmt->execute([$id_orden_gasto]);
			if ($stmt->rowCount()==0) {
				throw new Exception("2. Ocurrió un error al actualizar el detalle de la orden.");
			}

			foreach ($detalle_gasto as $key) {
				foreach ($key as $key1) {
					$sql = "INSERT INTO tb_detalle_gasto (`id_orden_gasto`, `name_tabla`, `cod_producto`, `cantidad`, `precio_unitario`, `descuento`, `sub_total`, `tipo_igv`, `igv`, `total`) VALUES ";
					$sql .= "(";
					$sql .= "?,?,?,?,?,?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_orden_gasto,$key1->name_tabla,$key1->cod_producto,$key1->cantidad,'0',$key1->precio_unitario,$key1->descuento,$key1->sub_total,$key1->tipo_igv,$key1->igv,$key1->total]);
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
		$VD = "";
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ? ");
			$stmt->execute([$id_orden_gasto]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("No se encontró la orden a anular");
			}

			$stmt = $conexion->prepare("UPDATE tb_orden_gasto WHERE id_orden_gasto = ?");
			$stmt->execute([$id_orden_gasto]);
			if ($stmt->rowCount()==0) {
				throw new Exception("2. Ocurrió un error al anular la orden de gasto.");
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
