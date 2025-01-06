<?php

class ClassIngreso extends Conexion
{

	public function __construct() {}

	public function getCount($id_sucursal, $valor, $fecha_inicio, $fecha_fin, $tipo_busqueda)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$fecha_fin = date("Y-m-d", strtotime($fecha_fin . "+ 1 days"));

			$valor = "%$valor%";
			$parametros = null;
			$sql = "SELECT COUNT(*) as cantidad FROM `tb_ingreso` i
								INNER JOIN tb_orden_compra o ON o.id_orden_compra = i.id_orden_compra
								INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
								WHERE i.fecha >= ? AND i.fecha < ? AND i.id_sucursal = ? ";

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
					default:
						break;
				}
			}

			$stmt = $conexion->prepare($sql);
			$stmt->execute($parametros);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontraron datos");
			} else {
				if ($result[0]['cantidad'] == 0) {
					throw new Exception("No se encontraron datos.");
				}
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
			$parametros = null;
			$sql = "SELECT 
						i.*, 
						p.nombre_proveedor, 
						t.nombres_trabajador,
						(SELECT COUNT(*) 
						FROM tb_detalle_ingreso di 
						WHERE di.id_ingreso = i.id_ingreso) AS num_registros,
						CONCAT(td.nombre_corto, ' ', i.num_documento) AS documento, 
						mo.signo,
						(i.total_ing - IFNULL(
							(SELECT SUM(pag.monto_pagado) 
							FROM tb_pago pag 
							WHERE pag.id_ingreso = i.id_ingreso), 
							0
						)) AS saldo
					FROM 
						tb_ingreso i
					INNER JOIN 
						tb_orden_compra o ON o.id_orden_compra = i.id_ingreso
					INNER JOIN 
						tb_documento_venta td ON td.id_documento_venta = i.id_tipo_docu
					INNER JOIN 
						tb_moneda mo ON mo.id_moneda = o.id_moneda
					INNER JOIN 
						vw_proveedor p ON p.id_proveedor = o.id_proveedor
					INNER JOIN 
						vw_trabajadores t ON t.id_trabajador = o.id_trabajador
					WHERE 
						i.fecha >= ? 
						AND i.fecha < ? 
						AND i.id_sucursal = ? ";


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
					default:
						break;
				}
			}

			$sql .= " LIMIT $offset, $limit";

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

	public function showPrint($valor, $fecha_inicio, $fecha_fin, $tipo_busqueda)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$fecha_fin = date("Y-m-d", strtotime($fecha_fin . "+ 1 days"));

			$valor = "%$valor%";
			$parametros = null;
			$sql = "SELECT i.*,p.nombre_proveedor,t.nombre_trabajador,
								(SELECT COUNT(*) FROM tb_detalle_ingreso di WHERE di.id_ingreso = i.id_ingreso) AS num_registros,
								i.num_documento as documento
								FROM `tb_ingreso` i
								INNER JOIN tb_orden_compra o ON o.id_orden_compra = i.id_orden_compra
								INNER JOIN tb_tipo_documento td ON td.id_tipo_docu = i.id_tipo_docu
								INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
								INNER JOIN vw_trabajador t ON t.id_trabajador = o.id_trabajador
								WHERE o.fecha_orden >= ? AND o.fecha_orden < ? ";

			$parametros[] = $fecha_inicio;
			$parametros[] = $fecha_fin;

			if ($tipo_busqueda != '') {
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

	public function getDataEditOrdenCompraIngreso($id_orden_compra)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$stmt = $conexion->prepare("SELECT * FROM `tb_orden_compra` WHERE id_orden_compra = ? AND estado in ('0','1') ");
			$stmt->execute([$id_orden_compra]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontró la orden a editar, o ya fue cambiada de estado.");
			}

			$sql = "SELECT O.id_orden_compra,O.id_proveedor,PR.nombre_proveedor,PR.src_imagen_proveedor,
											 O.id_metodo_envio,O.fecha_orden,O.fecha_entrega,O.observaciones,DC.cantidad_ingresada,
											 CASE WHEN O.estado = '0' THEN 'EN proceso ...'
											 			WHEN O.estado = '1' THEN 'EN espera ...' END AS estado,
											 DC.cod_producto,PRO.name_producto,PRO.stock,DC.precio_unitario as precio_compra,
											 PRO.precio_unitario,DC.cantidad_solicitada as cantidad,DC.notas,
											 (DC.precio_unitario * DC.cantidad_solicitada) as total,ME.name_metodo,
											 PRO.src_imagen as src_imagen_producto,DC.cantidad_solicitada
								FROM tb_orden_compra O
								INNER JOIN vw_proveedor PR ON PR.id_proveedor = O.id_proveedor
								INNER JOIN tb_detalle_compra DC ON DC.id_orden_compra = O.id_orden_compra
								INNER JOIN tb_producto PRO ON PRO.cod_producto = DC.cod_producto
								INNER JOIN tb_metodo_envio ME ON ME.id_metodo_envio = O.id_metodo_envio
								WHERE O.id_orden_compra = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_orden_compra]);
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

	public function getDataVerIngreso($id_ingreso)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$sql = "SELECT i.id_orden_compra,i.id_ingreso,O.nombre_proveedor,O.src_imagen_proveedor,
											 O.id_metodo_envio,i.fecha,i.observaciones,ME.name_metodo,i.id_tipo_docu,
											 CASE WHEN i.estado = '0' THEN 'Anulado'
											 			WHEN i.estado = '1' THEN 'Registrado' END AS estado,
											 DI.cod_producto,O.name_producto,DI.cantidad,
											 DI.observaciones as observaciones_detalle,
											 O.src_imagen_producto,i.src_evidencia,i.total_ing,O.name_tabla,
											 i.num_documento
								FROM tb_ingreso i
								INNER JOIN tb_detalle_ingreso DI ON DI.id_ingreso = i.id_ingreso
								INNER JOIN vw_orden_compra O ON O.id_orden_compra = i.id_orden_compra
								AND O.cod_producto = DI.cod_producto AND O.name_tabla = DI.name_tabla
								INNER JOIN tb_metodo_envio ME ON ME.id_metodo_envio = O.id_metodo_envio
								WHERE i.id_ingreso = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_ingreso]);
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

	public function insert($id_sucursal, $id_trabajador, $id_orden_compra, $id_tipo_docu, $num_documento, $observaciones, $src_evidencia, $total_ing, $detalle_compra)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_orden_compra` WHERE id_orden_compra = ? AND estado IN ('0','1') ");
			$stmt->execute([$id_orden_compra]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontró la orden a ingresar, o ya fue cambiada de estado.");
			}

			$stmt = $conexion->prepare("SELECT * FROM `tb_orden_compra` WHERE id_orden_compra = ? AND estado = '0' ");
			$stmt->execute([$id_orden_compra]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) > 0) {
				$sql = "UPDATE tb_orden_compra SET estado = '1' WHERE id_orden_compra = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_orden_compra]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("Ocurrió un error al actualizar el estado de la orden de compra.");
				}
			}

			$sql = "INSERT INTO tb_ingreso (`id_ingreso`, `id_orden_compra`, `id_sucursal`, `id_trabajador`, `id_tipo_docu`, `num_documento`, `fecha`, `observaciones`, `estado`, `src_evidencia`, `total_ing`) VALUES ";
			$sql .= "(";
			$sql .= "(SELECT CASE COUNT(i.id_ingreso) WHEN 0 THEN 1 ELSE (MAX(i.id_ingreso) + 1) end FROM `tb_ingreso` i),";
			$sql .= "?,?,?,?,?,NOW(),?,'1',?,?";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_orden_compra, $id_sucursal, $id_trabajador, $id_tipo_docu, $num_documento, $observaciones, $src_evidencia, $total_ing]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("1. Error al registrar el ingreso en la base de datos.");
			}

			$cantidad_ingresada = 0;

			foreach ($detalle_compra as $key) {
				foreach ($key as $key1) {

					if ($key1->cantidad > 0) {

						$stmt = $conexion->prepare("SELECT * FROM `tb_detalle_compra` WHERE id_orden_compra = ? AND name_tabla = ? AND cod_producto = ? AND cantidad_solicitada >= cantidad_ingresada + ? ");
						$stmt->execute([$id_orden_compra, $key1->name_tabla, $key1->cod_producto, $key1->cantidad]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

						if (count($result) == 0) {
							throw new Exception("La cantidad ingresada de un producto supera la cantidad Solicitada");
						}

						$sql = "INSERT INTO tb_detalle_ingreso (`id_ingreso`, `name_tabla`, `cod_producto`, `cantidad`, `observaciones`) VALUES ";
						$sql .= "(";
						$sql .= "(SELECT MAX(i.id_ingreso) FROM `tb_ingreso` i),";
						$sql .= "?,?,?,?";
						$sql .= ")";
						$stmt = $conexion->prepare($sql);
						$stmt->execute([$key1->name_tabla, $key1->cod_producto, $key1->cantidad, $key1->observaciones]);
						if ($stmt->rowCount() == 0) {
							throw new Exception("2. Error al registrar el ingreso en la base de datos.");
						}

						$sql = "UPDATE tb_detalle_compra SET cantidad_ingresada = cantidad_ingresada + ? WHERE id_orden_compra = ? AND cod_producto = ? AND name_tabla = ? ";
						$stmt = $conexion->prepare($sql);
						if ($stmt->execute([$key1->cantidad, $id_orden_compra, $key1->cod_producto, $key1->name_tabla]) == false) {
							throw new Exception("Error al actualizar la cantidad ingresada.");
						}

						if ($key1->name_tabla == "medicamento") {
							$sql = "UPDATE tb_medicamento SET stock = stock + ? WHERE id_medicamento = ?";
							$stmt = $conexion->prepare($sql);
							if ($stmt->execute([$key1->cantidad, $key1->cod_producto]) == false) {
								throw new Exception("Ocurrió un error al actualizar el stock del producto.");
							}
						} else {
							$sql = "UPDATE tb_accesorio SET stock = stock + ? WHERE id_accesorio = ?";
							$stmt = $conexion->prepare($sql);
							if ($stmt->execute([$key1->cantidad, $key1->cod_producto]) == false) {
								throw new Exception("Ocurrió un error al actualizar el stock del producto.");
							}
						}

						$cantidad_ingresada += $key1->cantidad;
					}
				}
			}

			if ($cantidad_ingresada == 0) {
				throw new Exception("El ingreso de tus productos es cero, no puedes registrar este ingreso.");
			}

			$stmt = $conexion->prepare("SELECT * FROM `tb_detalle_compra` WHERE id_orden_compra = ? AND cantidad_solicitada != cantidad_ingresada ");
			$stmt->execute([$id_orden_compra]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				$sql = "UPDATE tb_orden_compra SET estado = '2' WHERE id_orden_compra = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_orden_compra]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("Error al actualizar el estado de la orden de compra.");
				}
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

	public function delete($id_ingreso)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_ingreso` WHERE id_ingreso = ? AND estado = '1'");
			$stmt->execute([$id_ingreso]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontró el ingreso a anular, o ya fue cambiado de estado.");
			}

			$id_orden_compra = $result[0]['id_orden_compra'];

			$stmt = $conexion->prepare("UPDATE tb_ingreso SET estado = '0' WHERE id_ingreso = ?");
			$stmt->execute([$id_ingreso]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Ocurrió un error al actualizar el estado del ingreso.");
			}

			$stmt = $conexion->prepare("SELECT * FROM `tb_detalle_ingreso` WHERE id_ingreso = ?");
			$stmt->execute([$id_ingreso]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontró el detalle de productos de este ingreso.");
			}

			foreach ($result as $key) {

				if ($key['name_tabla'] == "medicamento") {
					$sql = "UPDATE tb_medicamento SET stock = stock - ? WHERE id_medicamento = ?";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$key['cantidad'], $key['cod_producto']]) == false) {
						throw new Exception("Ocurrió un error al actualizar el stock del producto.");
					}
				} else {
					$sql = "UPDATE tb_accesorio SET stock = stock - ? WHERE id_accesorio = ?";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$key['cantidad'], $key['cod_producto']]) == false) {
						throw new Exception("Ocurrió un error al actualizar el stock del producto.");
					}
				}

				$sql = "UPDATE tb_detalle_compra SET cantidad_ingresada = cantidad_ingresada - ? WHERE cod_producto = ? AND id_orden_compra = ? AND name_tabla = ? ";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$key['cantidad'], $key['cod_producto'], $id_orden_compra, $key['name_tabla']]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("Ocurrió un error al anular el ingreso.");
				}
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

	public function getCountPagos($id_ingreso)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$parametros = null;
			$sql = "SELECT COUNT(*) as cantidad 
			FROM tb_pago WHERE id_ingreso = ?";

			$parametros[] = $id_ingreso;

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

	public function getPagos($id_ingreso)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$sql = "SELECT p.id_ingreso, i.total_ing, p.id_pago, p.fecha_pago, f.name_forma_pago, p.monto_pagado, p.src_factura
						FROM tb_pago p
						INNER JOIN tb_forma_pago f ON p.id_forma_pago = f.id_forma_pago
						INNER JOIN tb_ingreso i ON p.id_ingreso = i.id_ingreso
						WHERE p.id_ingreso = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_ingreso]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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


	public function addPagos($id_ingreso, $id_forma_pago, $fecha_pago, $monto_pagado, $src_factura)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";

		try {

			$conexion->beginTransaction();

			$sql = "INSERT INTO tb_pago (id_ingreso, id_forma_pago, fecha_pago, monto_pagado, src_factura) VALUES (?, ?, ?, ?, ?)";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_ingreso, $id_forma_pago, $fecha_pago, $monto_pagado, $src_factura]);

			if ($stmt->rowCount() == 0) {
				throw new Exception("Ocurrió un error al registrar pago.");
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

	public function deletepago($id_pago)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("DELETE FROM tb_pago WHERE id_pago = ?");
			$stmt->execute([$id_pago]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Ocurrió un error al eliminar el registro.");
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
}

$OBJ_INGRESO = new ClassIngreso();
