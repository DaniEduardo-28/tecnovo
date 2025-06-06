<?php

class ClassGastoServicio extends Conexion
{

	//constructor de la clase
	public function __construct() {}

	public function getCount($id_sucursal, $valor, $fecha_inicio, $fecha_fin, $tipo_busqueda)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			$fecha_fin = date("Y-m-d", strtotime($fecha_fin . "+ 1 days"));

			$valor = "%$valor%";
			$parametros = [];
			$sql = "SELECT COUNT(*) as cantidad FROM `tb_gasto_servicio` o
					INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
					WHERE o.fecha_emision >= ? AND o.fecha_emision < ? AND o.id_sucursal = ? ";

			$parametros[] = $fecha_inicio;
			$parametros[] = $fecha_fin;
			$parametros[] = $id_sucursal;

			if ($tipo_busqueda != '') {
				switch ($tipo_busqueda) {
					case "1":
						$sql .= " AND p.num_documento_proveedor LIKE ? ";
						$parametros[] = $valor;
						break;
					case "2":
						$sql .= " AND p.nombre_proveedor LIKE ? ";
						$parametros[] = $valor;
						break;
				}
			}

			error_log("Consulta getCount: " . $sql);
			error_log("Parámetros: " . json_encode($parametros));

			$stmt = $conexion->prepare($sql);
			$stmt->execute($parametros);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0 || $result[0]['cantidad'] == 0) {
				throw new Exception("No se encontraron registros.");
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {
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


	public function show($id_sucursal, $valor, $fecha_inicio, $fecha_fin, $tipo_busqueda, $offset, $limit)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			$fecha_fin = date("Y-m-d", strtotime($fecha_fin . "+ 1 days"));

			$valor = "%$valor%";
			$parametros = [];
			$sql = "SELECT o.*, p.nombre_proveedor, t.nombres_trabajador, mon.signo as signo_moneda,
			        CONCAT(dv.nombre, ' N° ', o.serie, ' - ', o.correlativo) AS numero_documento, 
					(SELECT SUM(dc.monto_gastado) FROM tb_detalle_gastoserv dc WHERE dc.id_gasto_servicio = o.id_gasto_servicio) AS total
					FROM `tb_gasto_servicio` o
					INNER JOIN tb_moneda mon ON mon.id_moneda = o.id_moneda
					INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
					INNER JOIN vw_trabajadores t ON t.id_trabajador = o.id_trabajador
					LEFT JOIN tb_documento_venta dv ON dv.id_documento_venta = o.id_documento_venta 
					WHERE o.fecha_emision >= ? AND o.fecha_emision < ? AND o.id_sucursal = ? ";

			$parametros[] = $fecha_inicio;
			$parametros[] = $fecha_fin;
			$parametros[] = $id_sucursal;

			if ($tipo_busqueda != '') {
				switch ($tipo_busqueda) {
					case "1":
						$sql .= " AND p.num_documento_proveedor LIKE ? ";
						$parametros[] = $valor;
						break;
					case "2":
						$sql .= " AND p.nombre_proveedor LIKE ? ";
						$parametros[] = $valor;
						break;
				}
			}

			$sql .= " LIMIT $offset, $limit";

			error_log("Consulta show: " . $sql);
			error_log("Parámetros: " . json_encode($parametros));

			$stmt = $conexion->prepare($sql);
			$stmt->execute($parametros);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontraron registros.");
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {
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

	public function getDataEditGastoServicio($id_gasto_servicio)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			$sql = "SELECT 
						gs.id_gasto_servicio, 
						gs.id_proveedor,
						p.nombre_proveedor,
						p.src_imagen_proveedor,
						gs.fecha_emision,
						gs.observaciones,
						gs.id_documento_venta,
						gs.serie,
						gs.correlativo,
						gs.estado,
						gs.id_moneda,
						COALESCE(SUM(dg.monto_gastado), 0) AS total
					FROM tb_gasto_servicio gs
					LEFT JOIN vw_proveedor p ON gs.id_proveedor = p.id_proveedor
					LEFT JOIN tb_detalle_gastoserv dg ON gs.id_gasto_servicio = dg.id_gasto_servicio
					WHERE gs.id_gasto_servicio = ?
					 GROUP BY gs.id_gasto_servicio, gs.id_proveedor, p.nombre_proveedor, 
                         p.src_imagen_proveedor, gs.fecha_emision, gs.observaciones, 
                         gs.id_documento_venta, gs.serie, gs.correlativo, gs.estado, gs.id_moneda";

			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_gasto_servicio]);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			if (!$result) {
				throw new Exception("No se encontraron datos.");
			}

			$sql_detalle = "SELECT d.id_detalle_gastoserv, d.id_tipo_gasto, t.desc_gasto AS desc_gasto, 
                               d.descripcion_gasto, d.cantidad, d.precio_unitario, d.monto_gastado 
                        FROM tb_detalle_gastoserv d 
                        LEFT JOIN tb_tipo_gasto t ON t.id_tipo_gasto = d.id_tipo_gasto 
                        WHERE d.id_gasto_servicio = ?";
			$stmt = $conexion->prepare($sql_detalle);
			$stmt->execute([$id_gasto_servicio]);
			$detalles = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

			$result["detalles"] = $detalles;

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {

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

	public function getDataVerGastoServicio($id_gasto_servicio)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			$sql = "SELECT 
						gs.id_gasto_servicio, 
						gs.id_proveedor,
						p.nombre_proveedor,
						p.src_imagen_proveedor,
						gs.fecha_emision,
						gs.observaciones,
						gs.id_documento_venta,
						gs.serie,
						gs.correlativo,
						gs.estado,
						gs.id_moneda,
						COALESCE(SUM(dg.monto_gastado), 0) AS total
					FROM tb_gasto_servicio gs
					LEFT JOIN vw_proveedor p ON gs.id_proveedor = p.id_proveedor
					LEFT JOIN tb_detalle_gastoserv dg ON gs.id_gasto_servicio = dg.id_gasto_servicio
					WHERE gs.id_gasto_servicio = ?
                GROUP BY gs.id_gasto_servicio, gs.id_proveedor, p.nombre_proveedor, 
                         p.src_imagen_proveedor, gs.fecha_emision, gs.observaciones, 
                         gs.id_documento_venta, gs.serie, gs.correlativo, gs.estado, gs.id_moneda";


			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_gasto_servicio]);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			if (!$result) {
				throw new Exception("No se encontraron datos.");
			}

			$sql_detalle = "SELECT d.id_detalle_gastoserv, d.id_tipo_gasto, t.desc_gasto AS desc_gasto, 
                               d.descripcion_gasto, d.cantidad, d.precio_unitario, d.monto_gastado 
                        FROM tb_detalle_gastoserv d 
                        LEFT JOIN tb_tipo_gasto t ON t.id_tipo_gasto = d.id_tipo_gasto 
                        WHERE d.id_gasto_servicio = ?";

			$stmt = $conexion->prepare($sql_detalle);
			$stmt->execute([$id_gasto_servicio]);
			$detalles = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

			$result["detalles"] = $detalles;

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {
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


	public function insert($id_sucursal, $id_proveedor, $id_trabajador, $observaciones, $codigo_moneda, $id_documento_venta, $fecha_emision, $serie, $correlativo, $detalle_gastoserv)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {
			$conexion->beginTransaction();

			$sql = "INSERT INTO tb_gasto_servicio 
                (`id_sucursal`, `observaciones`, `id_proveedor`, `id_trabajador`, `fecha_emision`, `serie`, `correlativo`, `estado`, `id_moneda`, `id_documento_venta`, `total_monto`) 
                VALUES (?, ?, ?, ?, NOW(), ?, ?, '0', ?, ?, 0)";

			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_sucursal, $observaciones, $id_proveedor, $id_trabajador, $serie, $correlativo, $codigo_moneda, $id_documento_venta]);

			$id_gasto_servicio = $conexion->lastInsertId();

			if ($stmt->rowCount() == 0) {
				throw new Exception("1. Error al registrar la orden en la base de datos.");
			}

			$total_monto = 0;

			foreach ($detalle_gastoserv->datos as $detalle) {
				$sql = "INSERT INTO tb_detalle_gastoserv (`id_gasto_servicio`, `id_tipo_gasto`, `descripcion_gasto`, `cantidad`, `precio_unitario`, `monto_gastado`) 
						VALUES (?, ?, ?, ?, ?, ?)";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_gasto_servicio, $detalle->id_tipo_gasto, $detalle->descripcion_gasto, $detalle->cantidad, $detalle->precio_unitario, $detalle->monto_gastado]);

				if ($stmt->rowCount() == 0) {
					throw new Exception("2. Error al registrar el detalle de la orden en la base de datos.");
				}
			}
			$sql = "UPDATE tb_gasto_servicio 
                SET total_monto = (SELECT COALESCE(SUM(monto_gastado), 0) FROM tb_detalle_gastoserv WHERE id_gasto_servicio = ?) 
                WHERE id_gasto_servicio = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_gasto_servicio, $id_gasto_servicio]);


			$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Gasto de Servicio", "Insertar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
			}

			$VD = "OK";
			$conexion->commit();
		} catch (PDOException $e) {
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

	public function update($id_sucursal, $id_gasto_servicio, $id_proveedor, $id_trabajador, $observaciones, $codigo_moneda, $id_documento_venta, $fecha_emision, $serie, $correlativo, $detalle_gastoserv)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {
			$conexion->beginTransaction();

			$sql = "UPDATE tb_gasto_servicio SET 
                observaciones = ?, id_proveedor = ?, id_trabajador = ?, 
                fecha_emision = ?, serie = ?, correlativo = ?, id_moneda = ?, id_documento_venta = ? 
                WHERE id_gasto_servicio = ?";

			$stmt = $conexion->prepare($sql);
			if (!$stmt->execute([$observaciones, $id_proveedor, $id_trabajador, $fecha_emision, $serie, $correlativo, $codigo_moneda, $id_documento_venta, $id_gasto_servicio])) {
				throw new Exception("1. Error al actualizar los datos de la orden.");
			}

			$stmt = $conexion->prepare("DELETE FROM tb_detalle_gastoserv WHERE id_gasto_servicio = ?");
			$stmt->execute([$id_gasto_servicio]);


			foreach ($detalle_gastoserv->datos as $detalle) {
				$sql = "INSERT INTO tb_detalle_gastoserv (`id_gasto_servicio`, `id_tipo_gasto`, `descripcion_gasto`, `cantidad`, `precio_unitario`, `monto_gastado`) 
						VALUES (?, ?, ?, ?, ?, ?)";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_gasto_servicio, $detalle->id_tipo_gasto, $detalle->descripcion_gasto, $detalle->cantidad, $detalle->precio_unitario, $detalle->monto_gastado]);
	
				if ($stmt->rowCount() == 0) {
					throw new Exception("2. Error al registrar la orden en la base de datos.");
				}
			}

			$sql = "UPDATE tb_gasto_servicio 
                SET total_monto = (SELECT COALESCE(SUM(monto_gastado), 0) FROM tb_detalle_gastoserv WHERE id_gasto_servicio = ?) 
                WHERE id_gasto_servicio = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id_gasto_servicio, $id_gasto_servicio]);


		$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Gasto Servicio", "Actualizar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
			}

			$VD = "OK";
			$conexion->commit();
		} catch (PDOException $e) {
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

	public function delete($id_gasto_servicio)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_gasto_servicio` WHERE id_gasto_servicio = ? AND estado = '0'");
			$stmt->execute([$id_gasto_servicio]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("No se encontró la orden a anular, o ya fue cambiada de estado.");
			}

			$stmt = $conexion->prepare("UPDATE tb_gasto_servicio SET estado = '3' WHERE id_gasto_servicio = ?");
			$stmt->execute([$id_gasto_servicio]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Ocurrió un error al anular la orden de gastos.");
			}

			$VD = "OK";
			$conexion->commit();
		} catch (PDOException $e) {
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

	public function eliminarOrden($id_gasto_servicio)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {
			$conexion->beginTransaction();

			// Verificar si la orden está en estado "Anulado"
			$stmt = $conexion->prepare("SELECT * FROM `tb_gasto_servicio` WHERE id_gasto_servicio = ? AND estado = '3'");
			$stmt->execute([$id_gasto_servicio]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontró la orden en estado 'Anulado' o ya fue eliminada.");
			}

			// Eliminar registros del detalle de la orden
			$stmt = $conexion->prepare("DELETE FROM tb_detalle_gastoserv WHERE id_gasto_servicio = ?");
			$stmt->execute([$id_gasto_servicio]);

			// Eliminar la orden de compra
			$stmt = $conexion->prepare("DELETE FROM tb_gasto_servicio WHERE id_gasto_servicio = ?");
			$stmt->execute([$id_gasto_servicio]);

			$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Gasto Servicio", "Eliminar Orden"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
			}

			$VD = "OK";
			$conexion->commit();
		} catch (PDOException $e) {
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


	public function getCountPagos($id_gasto_servicio)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$parametros = null;
			$sql = "SELECT COUNT(*) as cantidad 
			  FROM tb_pagos_gastos WHERE id_gasto_servicio = ?";

			$parametros[] = $id_gasto_servicio;

			$stmt = $conexion->prepare($sql);
			$stmt->execute($parametros);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontraron datos");
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {

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

	public function getPagos($id_gasto_servicio)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$sql = "SELECT p.id_gasto_servicio, p.id_pago_gasto, p.fecha_pago, f.name_forma_pago, p.monto , c.total_monto 
				  FROM tb_gasto_servicio c
				  LEFT JOIN tb_pagos_gastos p ON c.id_gasto_servicio = p.id_gasto_servicio
				  LEFT JOIN tb_forma_pago f ON p.metodo_pago = f.id_forma_pago
				  WHERE c.id_gasto_servicio = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_gasto_servicio]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			error_log("Datos obtenidos: " . print_r($result, true));

			if (empty($result)) {
				$stmt = $conexion->prepare("SELECT total_monto FROM tb_gasto_servicio WHERE id_gasto_servicio = ?");
				$stmt->execute([$id_gasto_servicio]);
				$total_monto = $stmt->fetchColumn();

				$result = [
					[
						"id_gasto_servicio" => $id_gasto_servicio,
						"total_monto" => $total_monto,
						"id_pago_cliente" => null,
						"fecha_pago" => null,
						"name_forma_pago" => null,
						"monto" => 0
					]
				];
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {
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


	public function addPagos($id_gasto_servicio, $metodo_pago, $fecha_pago, $monto)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$conexion->beginTransaction();

			$sql = "INSERT INTO tb_pagos_gastos (id_gasto_servicio, metodo_pago, fecha_pago, monto) VALUES (?, ?, ?, ?)";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_gasto_servicio, $metodo_pago, $fecha_pago, $monto]);

			if ($stmt->rowCount() == 0) {
				throw new Exception("Ocurrió un error al registrar pago.");
			}

			$sql = "SELECT COALESCE(SUM(monto), 0) FROM tb_pagos_gastos WHERE id_gasto_servicio = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_gasto_servicio]);
			$total_pagado = $stmt->fetchColumn();

			$sql = "SELECT total_monto FROM tb_gasto_servicio WHERE id_gasto_servicio = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_gasto_servicio]);
			$total_monto = $stmt->fetchColumn();

			$nuevo_estado = ($total_pagado >= $total_monto) ? 2 : 0;
			$sql = "UPDATE tb_gasto_servicio SET estado = ? WHERE id_gasto_servicio = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$nuevo_estado, $id_gasto_servicio]);

			$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Pagos - Gasto Servicio", "Insertar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
			}

			$VD = "OK";
			$conexion->commit();
		} catch (PDOException $e) {
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

	public function deletePago($id_pago_gasto)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {

			$conexion->beginTransaction();

			$sql = "SELECT id_gasto_servicio FROM tb_pagos_gastos WHERE id_pago_gasto = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_pago_gasto]);
			$id_gasto_servicio = $stmt->fetchColumn();

			$stmt = $conexion->prepare("DELETE FROM tb_pagos_gastos WHERE id_pago_gasto = ?");
			$stmt->execute([$id_pago_gasto]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Ocurrió un error al eliminar el pago.");
			}

			$sql = "SELECT COALESCE(SUM(monto), 0) FROM tb_pagos_gastos WHERE id_gasto_servicio = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_gasto_servicio]);
			$total_pagado = $stmt->fetchColumn();

			$sql = "SELECT total_monto FROM tb_gasto_servicio WHERE id_gasto_servicio = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_gasto_servicio]);
			$total_monto = $stmt->fetchColumn();

			$nuevo_estado_pago = ($total_pagado >= $total_monto) ? 2 : 0;
			$sql = "UPDATE tb_gasto_servicio SET estado = ? WHERE id_gasto_servicio = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$nuevo_estado_pago, $id_gasto_servicio]);

			$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Pagos - Gasto Servicio", "Eliminar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
			}

			$VD = "OK";
			$conexion->commit();
		} catch (PDOException $e) {
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

	public function showReportePendientes($valor, $fecha_inicio, $fecha_fin, $tipo_busqueda)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			// Ajustar fecha de fin para incluir el día completo
			$fecha_fin = date("Y-m-d", strtotime($fecha_fin . "+ 1 days"));

			$valor = "%$valor%";
			$parametros = [$fecha_inicio, $fecha_fin, $fecha_inicio, $fecha_fin];
			$sql = "
            SELECT 
                'Gasto Servicio' AS tipo_registro,
                gs.id_gasto_servicio AS id,
                gs.fecha_emision AS fecha,
                vp.nombre_proveedor,
                gs.total_monto AS total,
                COALESCE(SUM(pg.monto), 0) AS pagado,
                (gs.total_monto - COALESCE(SUM(pg.monto), 0)) AS pendiente
            FROM tb_gasto_servicio gs
            LEFT JOIN tb_pagos_gastos pg ON gs.id_gasto_servicio = pg.id_gasto_servicio
            LEFT JOIN vw_proveedor vp ON gs.id_proveedor = vp.id_proveedor
            WHERE gs.fecha_emision BETWEEN ? AND ?
        ";

			if ($tipo_busqueda != '') {
				switch ($tipo_busqueda) {
					case 1:
						$sql .= " AND vp.nombre_proveedor LIKE ? ";
						$parametros[] = $valor;
						break;
					default:
						break;
				}
			}

			$sql .= " GROUP BY gs.id_gasto_servicio HAVING pendiente > 0 ";

			$sql .= " UNION ";

			$sql .= "
            SELECT 
                'Ingreso' AS tipo_registro,
                i.id_ingreso AS id,
                i.fecha AS fecha,
                vp.nombre_proveedor,
                i.total_ing AS total,
                COALESCE(SUM(p.monto_pagado), 0) AS pagado,
                (i.total_ing - COALESCE(SUM(p.monto_pagado), 0)) AS pendiente
            FROM tb_ingreso i
            LEFT JOIN tb_pago p ON i.id_ingreso = p.id_ingreso
            LEFT JOIN tb_orden_compra oc ON i.id_orden_compra = oc.id_orden_compra
            LEFT JOIN vw_proveedor vp ON oc.id_proveedor = vp.id_proveedor
            WHERE i.fecha BETWEEN ? AND ?
        ";

			if ($tipo_busqueda != '') {
				switch ($tipo_busqueda) {
					case 1:
						$sql .= " AND vp.nombre_proveedor LIKE ? ";
						$parametros[] = $valor;
						break;
					default:
						break;
				}
			}

			$sql .= " GROUP BY i.id_ingreso HAVING pendiente > 0 ";

			$stmt = $conexion->prepare($sql);
			$stmt->execute($parametros);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontraron datos.");
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {
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

	public function showReporteCobrar($valor, $fecha_inicio, $fecha_fin, $tipo_busqueda)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {
			// Ajustar fecha de fin para incluir el día completo
			$fecha_fin = date("Y-m-d", strtotime($fecha_fin . "+ 1 days"));

			$valor = "%$valor%";
			$parametros = [$fecha_inicio, $fecha_fin];
			$sql = "
            SELECT 
                
                c.id_cronograma AS id,
				CONCAT(ts.serie, LPAD(c.codigo, 5, '0')) AS codigo,
                c.fecha_ingreso AS fecha,
				CONCAT(p.nombres, ' ', p.apellidos) AS nombre_cliente, 
                c.monto_total AS total,
                COALESCE(SUM(pg.monto), 0) AS pagado,
                (c.monto_total - COALESCE(SUM(pg.monto), 0)) AS pendiente
            FROM tb_cronograma c
			LEFT JOIN tb_pagos_clientes pg ON pg.id_cronograma = c.id_cronograma 
            LEFT JOIN tb_cliente cl ON c.id_cliente = cl.id_cliente 
			LEFT JOIN tb_persona p ON cl.id_persona = p.id_persona 
			 LEFT JOIN tb_servicio s ON c.id_servicio = s.id_servicio 
			LEFT JOIN tb_tipo_servicio ts ON s.id_tipo_servicio = ts.id_tipo_servicio 
            WHERE c.fecha_ingreso BETWEEN ? AND ?
        ";

			if (!empty($tipo_busqueda)) {
				switch ($tipo_busqueda) {
					case 1:
						$sql .= " AND (p.nombres LIKE ? OR p.apellidos LIKE ?) ";
						$parametros[] = $valor;
						$parametros[] = $valor;
						break;
				}
			}

			$sql .= " GROUP BY c.id_cronograma HAVING pendiente > 0 ";

			$stmt = $conexion->prepare($sql);
			$stmt->execute($parametros);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontraron datos.");
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
		} catch (PDOException $e) {
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

$OBJ_GASTO_SERVICIO = new ClassGastoServicio();
