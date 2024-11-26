<?php

class ClassOrdenVenta extends Conexion
{

	//constructor de la clase
	public function __construct()
	{

	}

	public function getCount($id_sucursal, $id_trabajador, $id_doc_venta, $id_doc_cliente, $estado, $valor, $fecha_inicio, $fecha_fin)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$valor = "%$valor%";
			$parametros = null;
			$sql = "SELECT COUNT(*) as cantidad FROM tb_venta WHERE id_sucursal = ? AND
				(CONCAT(serie,'-',correlativo) LIKE ? OR numero_documento_cliente LIKE ? OR
				cliente LIKE ?) AND fecha BETWEEN ? AND ? ";

			$parametros[] = $id_sucursal;
			$parametros[] = $valor;
			$parametros[] = $valor;
			$parametros[] = $valor;
			$parametros[] = $fecha_inicio;
			$parametros[] = $fecha_fin;

			if ($id_doc_venta != "") {
				$sql .= " AND id_documento_venta = ?";
				$parametros[] = $id_doc_venta;
			}

			if ($id_doc_cliente != "") {
				$sql .= " AND id_documento_cliente = ?";
				$parametros[] = $id_doc_cliente;
			}

			if ($id_trabajador != "all") {
				$sql .= " AND id_trabajador = ?";
				$parametros[] = $id_trabajador;
			}

			if ($estado != "all") {
				$sql .= " AND estado = ?";
				$parametros[] = $estado;
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

	public function show($id_sucursal, $id_trabajador, $id_doc_venta, $id_doc_cliente, $estado, $valor, $offset, $limit, $fecha_inicio, $fecha_fin)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$valor = "%$valor%";
			$parametros = null;
			$sql = "SELECT * FROM tb_venta WHERE id_sucursal = ? AND
				(CONCAT(serie,'-',correlativo) LIKE ? OR numero_documento_cliente LIKE ? OR
				cliente LIKE ?) AND fecha BETWEEN ? AND ? ";

			$parametros[] = $id_sucursal;
			$parametros[] = $valor;
			$parametros[] = $valor;
			$parametros[] = $valor;
			$parametros[] = $fecha_inicio;
			$parametros[] = $fecha_fin;

			if ($id_doc_venta != "") {
				$sql .= " AND id_documento_venta = ?";
				$parametros[] = $id_doc_venta;
			}

			if ($id_doc_cliente != "") {
				$sql .= " AND id_documento_cliente = ?";
				$parametros[] = $id_doc_cliente;
			}

			if ($id_trabajador != "all") {
				$sql .= " AND id_trabajador = ?";
				$parametros[] = $id_trabajador;
			}

			if ($estado != "all") {
				$sql .= " AND estado = ?";
				$parametros[] = $estado;
			}

			$sql .= " ORDER BY serie,correlativo DESC ";

			$sql .= " LIMIT $offset, $limit ";

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

	public function showReporte($id_sucursal, $id_trabajador, $id_doc_venta, $id_doc_cliente, $estado, $valor, $fecha_inicio, $fecha_fin)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$valor = "%$valor%";
			$parametros = null;
			$sql = "SELECT * FROM tb_venta WHERE id_sucursal = ? AND
				(CONCAT(serie,'-',correlativo) LIKE ? OR numero_documento_cliente LIKE ? OR
				cliente LIKE ?) AND fecha BETWEEN ? AND ? ";

			$parametros[] = $id_sucursal;
			$parametros[] = $valor;
			$parametros[] = $valor;
			$parametros[] = $valor;
			$parametros[] = $fecha_inicio;
			$parametros[] = $fecha_fin;

			if ($id_doc_venta != "") {
				$sql .= " AND id_documento_venta = ?";
				$parametros[] = $id_doc_venta;
			}

			if ($id_doc_cliente != "") {
				$sql .= " AND id_documento_cliente = ?";
				$parametros[] = $id_doc_cliente;
			}

			if ($id_trabajador != "all") {
				$sql .= " AND id_trabajador = ?";
				$parametros[] = $id_trabajador;
			}

			if ($estado != "all") {
				$sql .= " AND estado = ?";
				$parametros[] = $estado;
			}

			$sql .= " ORDER BY serie,correlativo ASC ";

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

	public function getCountDetalleParaOrden($id_sucursal, $tipo, $valor)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$valor = "%$valor%";
			$sql = "";
			$parametros = null;
			switch ($tipo) {
				case 'medicamento':
					$sql .= "SELECT count(*) as cantidad FROM tb_medicamento WHERE id_sucursal = ? AND name_medicamento LIKE ? ";
					$parametros[] = $id_sucursal;
					$parametros[] = $valor;
					break;
				case 'producto':
					$sql .= "SELECT count(*) as cantidad FROM tb_accesorio WHERE id_sucursal = ? AND name_accesorio LIKE ? ";
					$parametros[] = $id_sucursal;
					$parametros[] = $valor;
					break;
				case 'servicio':
					$sql .= "SELECT count(*) as cantidad FROM tb_servicio WHERE name_servicio LIKE ? ";
					$parametros[] = $valor;
					break;
				default:
					throw new Exception("Error al validar la busqueda de la tabla.");
					break;
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

	public function showDetalleParaOrden($id_sucursal, $tipo, $valor, $offset, $limit)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$valor = "%$valor%";
			$sql = "";
			$parametros = null;
			switch ($tipo) {
				case 'medicamento':
					$sql .= "SELECT name_medicamento as descripcion,id_medicamento as cod_producto,
										id_moneda,precio_venta as precio_unitario
										FROM tb_medicamento WHERE id_sucursal = ? AND name_medicamento LIKE ? ";
					$parametros[] = $id_sucursal;
					$parametros[] = $valor;
					break;
				case 'producto':
					$sql .= "SELECT name_accesorio as descripcion,id_accesorio as cod_producto,
										id_moneda,precio_venta as precio_unitario
										FROM tb_accesorio WHERE id_sucursal = ? AND name_accesorio LIKE ? ";
					$parametros[] = $id_sucursal;
					$parametros[] = $valor;
					break;
				case 'servicio':
					$sql .= "SELECT name_servicio as descripcion,id_servicio as cod_producto,
										id_moneda,precio as precio_unitario
						 				FROM tb_servicio WHERE name_servicio LIKE ? ";
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

	public function insert($id_venta, $codigo_documento_venta, $serie, $correlativo, $codigo_documento_cliente, $numero_documento_cliente, $nombres, $apellidos, $direccion, $telefono, $correo, $fecha, $codigo_moneda, $codigo_forma_pago, $total_descuento, $total_gravada, $total_igv, $total_total, $detalle_venta, $id_trabajador, $id_sucursal, $monto_recibido, $vuelto, $tipo_cambio)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_documento = ? AND num_documento = ?");
			$stmt->execute([$codigo_documento_cliente, $numero_documento_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$id_persona = 0;

			if (count($result) > 0) {

				$id_persona = $result[0]['id_persona'];

				$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_persona = ? ");
				$stmt->execute([$id_persona]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result) == 0) {

					if (trim($correo) != "") {
						$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
						$stmt->execute([$id_persona, $correo]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						if (count($result) > 0) {
							throw new Exception("El correo ya se encuentra registrado en el sistema.");
						}
					}

					$name_user = $numero_documento_cliente . "@gmail.com";

					if (trim($correo) != "") {
						$name_user = $correo;
					}

					$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_persona != ? AND name_user = ? ");
					$stmt->execute([$id_persona, $name_user]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, ingrese otro nombre de usuario.");
					}

					$sql = "UPDATE tb_persona SET ";
					$sql .= " nombres = ?, ";
					$sql .= " apellidos = ?, ";
					$sql .= " direccion = ?, ";
					$sql .= " correo = ?, ";
					$sql .= " telefono = ? ";
					$sql .= " WHERE id_persona = ? ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$nombres, $apellidos, $direccion, $correo, $telefono, $id_persona]) == false) {
						throw new Exception("Ocurrió un error al actualizar los datos del cliente.");
					}

					$sql = "INSERT INTO tb_cliente (`id_cliente`, `id_persona`, `name_user`, `pass_user`, `fecha_activacion`, `estado`, `src_imagen`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(c.id_cliente) WHEN 0 THEN 1 ELSE (MAX(c.id_cliente) + 1) end FROM `tb_cliente` c),";
					$sql .= "?,?,?,now(),?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_persona, $name_user, "1234", 1, "resources/global/images/default-profile.png"]);
					if ($stmt->rowCount() == 0) {
						throw new Exception("Error al registrar el cliente en la base de datos.");
					}

					$sql = "UPDATE tb_parametros_generales SET valor_int = valor_int + 1 where id_parametro = 25";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([]) == false) {
						throw new Exception("Ocurrió un error al actualizar los datos de parametros generales.");
					}

				} else {

					if (trim($correo) != "") {
						$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
						$stmt->execute([$id_persona, $correo]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						if (count($result) > 0) {
							throw new Exception("El correo ya se encuentra registrado en el sistema.");
						}
					}

					$name_user = $numero_documento_cliente . "@gmail.com";

					if (trim($correo) != "") {
						$name_user = $correo;
					}

					$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_persona != ? AND name_user = ? ");
					$stmt->execute([$id_persona, $name_user]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, ingrese otro nombre de usuario.");
					}

					$sql = "UPDATE tb_persona SET ";
					$sql .= " nombres = ?, ";
					$sql .= " apellidos = ?, ";
					$sql .= " direccion = ?, ";
					$sql .= " correo = ?, ";
					$sql .= " telefono = ? ";
					$sql .= " WHERE id_persona = ? ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$nombres, $apellidos, $direccion, $correo, $telefono, $id_persona]) == false) {
						throw new Exception("Ocurrió un error al actualizar los datos del cliente.");
					}

				}

			} else {

				if (trim($correo) != "") {
					$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE correo = ? ");
					$stmt->execute([$correo]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El correo ya se encuentra registrado en el sistema.");
					}
				}

				$name_user = $numero_documento_cliente . "@gmail.com";

				if (trim($correo) != "") {
					$name_user = $correo;
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE name_user = ? ");
				$stmt->execute([$name_user]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) > 0) {
					throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, intente ingresar otro nombre de usuario.");
				}

				$sql = "INSERT INTO tb_persona (`id_persona`, `id_documento`, `num_documento`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo`, `fecha_nacimiento`, `sexo`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(p.id_persona) WHEN 0 THEN 1 ELSE (MAX(p.id_persona) + 1) end FROM `tb_persona` p),";
				$sql .= "?,?,?,?,?,?,?,now(),?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$codigo_documento_cliente, $numero_documento_cliente, $nombres, $apellidos, $direccion, $telefono, $correo, "masculino"]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("1. Error al registrar los datos del cliente.");
				}

				$stmt = $conexion->prepare("SELECT MAX(p.id_persona) as id_persona FROM `tb_persona` p");
				$stmt->execute([]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0) {
					throw new Exception("Error al seleccionar el id de persona.");
				}

				$id_persona = $result[0]['id_persona'];

				$sql = "INSERT INTO tb_cliente (`id_cliente`, `id_persona`, `name_user`, `pass_user`, `fecha_activacion`, `estado`, `src_imagen`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(c.id_cliente) WHEN 0 THEN 1 ELSE (MAX(c.id_cliente) + 1) end FROM `tb_cliente` c),";
				$sql .= "?,?,?,now(),?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_persona, $name_user, "1234", 1, "resources/global/images/default-profile.png"]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("Error al registrar el cliente en la base de datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET valor_int = valor_int + 1 where id_parametro = 25";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([]) == false) {
					throw new Exception("Ocurrió un error al actualizar los datos de parametros generales.");
				}

			}

			$id_documento_venta = $codigo_documento_venta;
			$stmt = $conexion->prepare("SELECT * FROM `tb_documento_venta` WHERE id_documento_venta = ?");
			$stmt->execute([$id_documento_venta]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de documento venta.");
			}
			$name_documento_venta = $result[0]['nombre_corto'];
			$codigo_documento_venta = $result[0]['cod_sunat'];
			$serie = $result[0]['serie'];
			$correlativo = $result[0]['correlativo'];
			$flag_doc_interno = $result[0]['flag_doc_interno'];


			$id_documento_cliente = $codigo_documento_cliente;
			$stmt = $conexion->prepare("SELECT * FROM `tb_documento_identidad` WHERE id_documento = ?");
			$stmt->execute([$id_documento_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de documento cliente.");
			}
			$name_documento_cliente = $result[0]['name_documento'];
			$codigo_documento_cliente = $result[0]['codigo_sunat'];


			$id_forma_pago = $codigo_forma_pago;
			$stmt = $conexion->prepare("SELECT * FROM `tb_forma_pago` WHERE id_forma_pago = ?");
			$stmt->execute([1]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de forma de pago.");
			}
			$name_forma_pago = $result[0]['name_forma_pago'];
			$codigo_forma_pago = $result[0]['cod_sunat'];

			$cliente = $nombres . " " . $apellidos;
			if (strtoupper($name_documento_venta) == "RUC") {
				$cliente = $nombres;
			}

			$pdf = "NOK";
			$xml = "NOK";
			$cdr = "NOK";

			//SI ES 0 (CERO) TIENE QUE GRABAR EN EL OSE
			if ($flag_doc_interno == "0") {
				// code...
			}

			$stmt = $conexion->prepare("SELECT * FROM `tb_sucursal` WHERE id_sucursal = ?");
			$stmt->execute([$id_sucursal]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de sucursal.");
			}
			$ruta = $result[0]['ruta'];
			$token = $result[0]['token'];



			$id_moneda = $codigo_moneda;
			$stmt = $conexion->prepare("SELECT * FROM `tb_moneda` WHERE id_moneda = ?");
			$stmt->execute([1]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de forma de pago.");
			}
			$codigo_moneda = $result[0]['cod_sunat'];
			$signo_moneda = $result[0]['signo'];
			$abreviatura_moneda = $result[0]['abreviatura'];

			$sql = "INSERT INTO tb_venta (`id_venta`, `id_sucursal`, `id_trabajador`, `id_documento_venta`,
								`name_documento_venta`, `codigo_documento_venta`, `serie`, `correlativo`,
								`id_documento_cliente`,`name_documento_cliente`, `codigo_documento_cliente`,
								`numero_documento_cliente`, `id_forma_pago`, `codigo_forma_pago`, `name_forma_pago`,
								`cliente`, `direccion`, `telefono`, `correo`, `fecha`, `fecha_vencimiento`,
								`descuento_total`, `sub_total`, `igv`, `total`, `estado`, `pdf`, `xml`, `cdr`, `ruta`,
								`token`, `flag_doc_interno`,`monto_recibido`, `vuelto`, `id_moneda`,
								`codigo_moneda`, `signo_moneda`, `abreviatura_moneda`, `flag_enviado`, `monto_tipo_cambio`) VALUES ";
			$sql .= "(";
			$sql .= "(SELECT CASE COUNT(o.id_venta) WHEN 0 THEN 1 ELSE (MAX(o.id_venta) + 1) end FROM `tb_venta` o),";
			$sql .= "?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,null,?,?,?,?,1,?,?,?,?,?,?,?,?,?,?,?,?,0,?";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([
				$id_sucursal,
				$id_trabajador,
				$id_documento_venta,
				$name_documento_venta,
				$codigo_documento_venta,
				$serie,
				$correlativo,
				$id_documento_cliente,
				$name_documento_cliente,
				$codigo_documento_cliente,
				$numero_documento_cliente,
				$id_forma_pago,
				$codigo_forma_pago,
				$name_forma_pago,
				$cliente,
				$direccion,
				$telefono,
				$correo,
				date('Y-m-d', strtotime($fecha)),
				$total_descuento,
				$total_gravada,
				$total_igv,
				$total_total,
				$pdf,
				$xml,
				$cdr,
				$ruta,
				$token,
				$flag_doc_interno,
				$monto_recibido,
				$vuelto,
				1,
				1,
				"S/",
				"PEN",
				$tipo_cambio
			]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("1. Error al registrar la orden de venta en la base de datos.");
			}


			foreach ($detalle_venta as $key) {
				foreach ($key as $key1) {
					$sql = "INSERT INTO tb_detalle_venta (`id_detalle`, `id_venta`, `name_tabla`, `cod_producto`, `descripcion`,
																									`cantidad`, `precio_unitario`, `descuento`, `sub_total`, `tipo_igv`,
																									`igv`, `total`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(o.id_detalle) WHEN 0 THEN 1 ELSE (MAX(o.id_detalle) + 1) end FROM `tb_detalle_venta` o),";
					$sql .= "(SELECT MAX(id_venta) FROM `tb_venta`),";
					$sql .= "?,?,?,?,?,?,?,?,?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([
						$key1->name_tabla,
						$key1->cod_producto,
						$key1->descripcion,
						$key1->cantidad,
						$key1->precio_unitario,
						$key1->descuento,
						$key1->sub_total,
						$key1->tipo_igv,
						$key1->igv,
						$key1->total
					]);
					if ($stmt->rowCount() == 0) {
						throw new Exception("2. Error al registrar la orden de venta en la base de datos.");
					}
				}
			}

			$stmt = $conexion->prepare("SELECT MAX(id_venta) as id_venta FROM `tb_venta`");
			$stmt->execute([]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de venta.");
			}
			$id_venta = $result[0]['id_venta'];

			//Falta disminuir stock
			//Falta aumentar el correlativo al guardar

			$VD1['error'] = "NO";
			$VD1['message'] = "Operación realizada correctamente.";
			$VD1['id_venta'] = $id_venta;
			$VD1['serie'] = $serie;
			$VD1['correlativo'] = $serie;
			$VD = $VD1;
			$conexion->commit();

		} catch (PDOException $e) {

			$conexion->rollBack();
			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;

		} catch (Exception $exception) {

			$conexion->rollBack();
			$VD1['error'] = "SI";
			$VD1['message'] = $exception->getMessage();
			$VD = $VD1;

		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	public function update($id_venta, $codigo_documento_venta, $serie, $correlativo, $codigo_documento_cliente, $numero_documento_cliente, $nombres, $apellidos, $direccion, $telefono, $correo, $fecha, $codigo_moneda, $codigo_forma_pago, $total_descuento, $total_gravada, $total_igv, $total_total, $detalle_venta, $id_trabajador, $id_sucursal, $monto_recibido, $vuelto, $tipo_cambio)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_venta` WHERE id_venta = ?");
			$stmt->execute([$id_venta]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontró la orden de venta ó ya fue eliminada.");
			}
			if ($result[0]['estado'] == "2" || $result[0]['estado'] == "3") {
				throw new Exception("No se puede editar está venta, ya se encuentra pagada o anulada.");
			}

			$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_documento = ? AND num_documento = ?");
			$stmt->execute([$codigo_documento_cliente, $numero_documento_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$id_persona = 0;

			if (count($result) > 0) {

				$id_persona = $result[0]['id_persona'];

				$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_persona = ? ");
				$stmt->execute([$id_persona]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result) == 0) {

					if (trim($correo) != "") {
						$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
						$stmt->execute([$id_persona, $correo]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						if (count($result) > 0) {
							throw new Exception("El correo ya se encuentra registrado en el sistema.");
						}
					}

					$name_user = $numero_documento_cliente . "@gmail.com";

					if (trim($correo) != "") {
						$name_user = $correo;
					}

					$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_persona != ? AND name_user = ? ");
					$stmt->execute([$id_persona, $name_user]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, ingrese otro nombre de usuario.");
					}

					$sql = "UPDATE tb_persona SET ";
					$sql .= " nombres = ?, ";
					$sql .= " apellidos = ?, ";
					$sql .= " direccion = ?, ";
					$sql .= " correo = ?, ";
					$sql .= " telefono = ? ";
					$sql .= " WHERE id_persona = ? ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$nombres, $apellidos, $direccion, $correo, $telefono, $id_persona]) == false) {
						throw new Exception("Ocurrió un error al actualizar los datos del cliente.");
					}

					$sql = "INSERT INTO tb_cliente (`id_cliente`, `id_persona`, `name_user`, `pass_user`, `fecha_activacion`, `estado`, `src_imagen`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(c.id_cliente) WHEN 0 THEN 1 ELSE (MAX(c.id_cliente) + 1) end FROM `tb_cliente` c),";
					$sql .= "?,?,?,now(),?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_persona, $name_user, "1234", 1, "resources/global/images/default-profile.png"]);
					if ($stmt->rowCount() == 0) {
						throw new Exception("Error al registrar el cliente en la base de datos.");
					}

					$sql = "UPDATE tb_parametros_generales SET valor_int = valor_int + 1 where id_parametro = 25";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([]) == false) {
						throw new Exception("Ocurrió un error al actualizar los datos de parametros generales.");
					}

				} else {

					if (trim($correo) != "") {
						$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
						$stmt->execute([$id_persona, $correo]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						if (count($result) > 0) {
							throw new Exception("El correo ya se encuentra registrado en el sistema.");
						}
					}

					$name_user = $numero_documento_cliente . "@gmail.com";

					if (trim($correo) != "") {
						$name_user = $correo;
					}

					$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_persona != ? AND name_user = ? ");
					$stmt->execute([$id_persona, $name_user]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, ingrese otro nombre de usuario.");
					}

					$sql = "UPDATE tb_persona SET ";
					$sql .= " nombres = ?, ";
					$sql .= " apellidos = ?, ";
					$sql .= " direccion = ?, ";
					$sql .= " correo = ?, ";
					$sql .= " telefono = ? ";
					$sql .= " WHERE id_persona = ? ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$nombres, $apellidos, $direccion, $correo, $telefono, $id_persona]) == false) {
						throw new Exception("Ocurrió un error al actualizar los datos del cliente.");
					}

				}

			} else {

				if (trim($correo) != "") {
					$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE correo = ? ");
					$stmt->execute([$correo]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El correo ya se encuentra registrado en el sistema.");
					}
				}

				$name_user = $numero_documento_cliente . "@gmail.com";

				if (trim($correo) != "") {
					$name_user = $correo;
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE name_user = ? ");
				$stmt->execute([$name_user]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) > 0) {
					throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, intente ingresar otro nombre de usuario.");
				}

				$sql = "INSERT INTO tb_persona (`id_persona`, `id_documento`, `num_documento`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo`, `fecha_nacimiento`, `sexo`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(p.id_persona) WHEN 0 THEN 1 ELSE (MAX(p.id_persona) + 1) end FROM `tb_persona` p),";
				$sql .= "?,?,?,?,?,?,?,now(),?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$codigo_documento_cliente, $numero_documento_cliente, $nombres, $apellidos, $direccion, $telefono, $correo, "masculino"]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("1. Error al registrar los datos del cliente.");
				}

				$stmt = $conexion->prepare("SELECT MAX(p.id_persona) as id_persona FROM `tb_persona` p");
				$stmt->execute([]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0) {
					throw new Exception("Error al seleccionar el id de persona.");
				}

				$id_persona = $result[0]['id_persona'];

				$sql = "INSERT INTO tb_cliente (`id_cliente`, `id_persona`, `name_user`, `pass_user`, `fecha_activacion`, `estado`, `src_imagen`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(c.id_cliente) WHEN 0 THEN 1 ELSE (MAX(c.id_cliente) + 1) end FROM `tb_cliente` c),";
				$sql .= "?,?,?,now(),?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_persona, $name_user, "1234", 1, "resources/global/images/default-profile.png"]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("Error al registrar el cliente en la base de datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET valor_int = valor_int + 1 where id_parametro = 25";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([]) == false) {
					throw new Exception("Ocurrió un error al actualizar los datos de parametros generales.");
				}

			}

			$id_documento_venta = $codigo_documento_venta;
			$stmt = $conexion->prepare("SELECT * FROM `tb_documento_venta` WHERE id_documento_venta = ?");
			$stmt->execute([$id_documento_venta]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de documento venta.");
			}
			$name_documento_venta = $result[0]['nombre_corto'];
			$codigo_documento_venta = $result[0]['cod_sunat'];
			$serie = $result[0]['serie'];
			$correlativo = $result[0]['correlativo'];
			$flag_doc_interno = $result[0]['flag_doc_interno'];


			$id_documento_cliente = $codigo_documento_cliente;
			$stmt = $conexion->prepare("SELECT * FROM `tb_documento_identidad` WHERE id_documento = ?");
			$stmt->execute([$id_documento_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de documento cliente.");
			}
			$name_documento_cliente = $result[0]['name_documento'];
			$codigo_documento_cliente = $result[0]['codigo_sunat'];


			$id_forma_pago = $codigo_forma_pago;
			$stmt = $conexion->prepare("SELECT * FROM `tb_forma_pago` WHERE id_forma_pago = ?");
			$stmt->execute([1]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de forma de pago.");
			}
			$name_forma_pago = $result[0]['name_forma_pago'];
			$codigo_forma_pago = $result[0]['cod_sunat'];

			$cliente = $nombres . " " . $apellidos;
			if (strtoupper($name_documento_venta) == "RUC") {
				$cliente = $nombres;
			}

			$pdf = "NOK";
			$xml = "NOK";
			$cdr = "NOK";

			//SI ES 0 (CERO) TIENE QUE GRABAR EN EL OSE
			if ($flag_doc_interno == "0") {
				// code...
			}

			$stmt = $conexion->prepare("SELECT * FROM `tb_sucursal` WHERE id_sucursal = ?");
			$stmt->execute([$id_sucursal]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de sucursal.");
			}
			$ruta = $result[0]['ruta'];
			$token = $result[0]['token'];



			$id_moneda = $codigo_moneda;
			$stmt = $conexion->prepare("SELECT * FROM `tb_moneda` WHERE id_moneda = ?");
			$stmt->execute([1]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de forma de pago.");
			}
			$codigo_moneda = $result[0]['cod_sunat'];
			$signo_moneda = $result[0]['signo'];
			$abreviatura_moneda = $result[0]['abreviatura'];

			$sql = "UPDATE `tb_venta` SET `id_sucursal` = ?,
											`id_trabajador` = ?,
											`id_documento_venta` = ?,
											`name_documento_venta` = ?,
											`codigo_documento_venta` = ?,
											`serie` = ?,
											`correlativo` = ?,
											`id_documento_cliente` = ?,
											`name_documento_cliente` = ?,
											`codigo_documento_cliente` = ?,
											`numero_documento_cliente` = ?,
											`id_forma_pago` = ?,
											`codigo_forma_pago` = ?,
											`name_forma_pago` = ?,
											`cliente` = ?,
											`direccion` = ?,
											`telefono` = ?,
											`correo` = ?,
											`fecha` = ?,
											`descuento_total` = ?,
											`sub_total` = ?,
											`igv` = ?,
											`total` = ?,
											`pdf` = ?,
											`xml` = ?,
											`cdr` = ?,
											`ruta` = ?,
											`token` = ?,
											`flag_doc_interno` = ?,
											`monto_recibido` = ?,
											`vuelto` = ?,
											`id_moneda` = ?,
											`codigo_moneda` = ?,
											`signo_moneda` = ?,
											`abreviatura_moneda` = ?,
											`monto_tipo_cambio` = ?
								WHERE id_venta = ?";
			$stmt = $conexion->prepare($sql);
			$flag_update = $stmt->execute([
				$id_sucursal,
				$id_trabajador,
				$id_documento_venta,
				$name_documento_venta,
				$codigo_documento_venta,
				$serie,
				$correlativo,
				$id_documento_cliente,
				$name_documento_cliente,
				$codigo_documento_cliente,
				$numero_documento_cliente,
				$id_forma_pago,
				$codigo_forma_pago,
				$name_forma_pago,
				$cliente,
				$direccion,
				$telefono,
				$correo,
				date('Y-m-d', strtotime($fecha)),
				$total_descuento,
				$total_gravada,
				$total_igv,
				$total_total,
				$pdf,
				$xml,
				$cdr,
				$ruta,
				$token,
				$flag_doc_interno,
				$monto_recibido,
				$vuelto,
				$id_moneda,
				$codigo_moneda,
				$signo_moneda,
				$abreviatura_moneda,
				$tipo_cambio,
				$id_venta
			]);
			if ($flag_update == false) {
				throw new Exception("1. Error al registrar la orden de venta en la base de datos.");
			}

			$sql = "DELETE FROM tb_detalle_venta WHERE id_venta = ?";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([$id_venta]) == false) {
				throw new Exception("Ocurrió un error al eliminar el detalle de la orden de venta.");
			}

			foreach ($detalle_venta as $key) {
				foreach ($key as $key1) {
					$sql = "INSERT INTO tb_detalle_venta (`id_detalle`, `id_venta`, `name_tabla`, `cod_producto`, `descripcion`,
																									`cantidad`, `precio_unitario`, `descuento`, `sub_total`, `tipo_igv`,
																									`igv`, `total`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(o.id_detalle) WHEN 0 THEN 1 ELSE (MAX(o.id_detalle) + 1) end FROM `tb_detalle_venta` o),";
					$sql .= "?,";
					$sql .= "?,?,?,?,?,?,?,?,?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([
						$id_venta,
						$key1->name_tabla,
						$key1->cod_producto,
						$key1->descripcion,
						$key1->cantidad,
						$key1->precio_unitario,
						$key1->descuento,
						$key1->sub_total,
						$key1->tipo_igv,
						$key1->igv,
						$key1->total
					]);
					if ($stmt->rowCount() == 0) {
						throw new Exception("2. Error al registrar la orden de venta en la base de datos.");
					}
				}
			}

			$stmt = $conexion->prepare("SELECT MAX(id_venta) as id_venta FROM `tb_venta`");
			$stmt->execute([]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de venta.");
			}
			$id_venta = $result[0]['id_venta'];

			//Falta disminuir stock
			//Falta aumentar el correlativo al guardar

			$VD1['error'] = "NO";
			$VD1['message'] = "Operación realizada correctamente.";
			$VD1['id_venta'] = $id_venta;
			$VD1['serie'] = $serie;
			$VD1['correlativo'] = $serie;
			$VD = $VD1;

			$conexion->commit();

		} catch (PDOException $e) {

			$conexion->rollBack();
			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;

		} catch (Exception $exception) {

			$conexion->rollBack();
			$VD1['error'] = "SI";
			$VD1['message'] = $exception->getMessage();
			$VD = $VD1;

		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	public function getDataVerOrdenVenta($id_venta)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$sql = "SELECT V.*,
				               DV.name_tabla as detalle_name_tabla,
											 DV.cod_producto as detalle_cod_producto,
											 DV.descripcion as detalle_descripcion,
											 DV.cantidad as detalle_cantidad,
											 DV.precio_unitario as detalle_precio_unitario,
											 DV.descuento as detalle_descuento,
											 DV.sub_total as detalle_sub_total,
											 DV.tipo_igv as detalle_tipo_igv,
											 DV.igv as detalle_igv,
											 DV.total as detalle_total
								FROM tb_venta V
								INNER JOIN tb_detalle_venta DV ON DV.id_venta = V.id_venta
								WHERE V.id_venta = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_venta]);
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

	public function insert_1($id_venta, $codigo_documento_venta, $serie, $correlativo, $codigo_documento_cliente, $numero_documento_cliente, $nombres, $apellidos, $direccion, $telefono, $correo, $fecha, $codigo_moneda, $codigo_forma_pago, $total_descuento, $total_gravada, $total_igv, $total_total, $detalle_venta, $id_trabajador, $id_sucursal, $monto_recibido, $vuelto, $tipo_cambio)
	{

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_documento = ? AND num_documento = ?");
			$stmt->execute([$codigo_documento_cliente, $numero_documento_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$id_persona = 0;

			if (count($result) > 0) {

				$id_persona = $result[0]['id_persona'];

				$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_persona = ? ");
				$stmt->execute([$id_persona]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result) == 0) {

					if (trim($correo) != "") {
						$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
						$stmt->execute([$id_persona, $correo]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						if (count($result) > 0) {
							throw new Exception("El correo ya se encuentra registrado en el sistema.");
						}
					}

					$name_user = $numero_documento_cliente . "@gmail.com";

					if (trim($correo) != "") {
						$name_user = $correo;
					}

					$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_persona != ? AND name_user = ? ");
					$stmt->execute([$id_persona, $name_user]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, ingrese otro nombre de usuario.");
					}

					$sql = "UPDATE tb_persona SET ";
					$sql .= " nombres = ?, ";
					$sql .= " apellidos = ?, ";
					$sql .= " direccion = ?, ";
					$sql .= " correo = ?, ";
					$sql .= " telefono = ? ";
					$sql .= " WHERE id_persona = ? ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$nombres, $apellidos, $direccion, $correo, $telefono, $id_persona]) == false) {
						throw new Exception("Ocurrió un error al actualizar los datos del cliente.");
					}

					$sql = "INSERT INTO tb_cliente (`id_cliente`, `id_persona`, `name_user`, `pass_user`, `fecha_activacion`, `estado`, `src_imagen`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(c.id_cliente) WHEN 0 THEN 1 ELSE (MAX(c.id_cliente) + 1) end FROM `tb_cliente` c),";
					$sql .= "?,?,?,now(),?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_persona, $name_user, "1234", 1, "resources/global/images/default-profile.png"]);
					if ($stmt->rowCount() == 0) {
						throw new Exception("Error al registrar el cliente en la base de datos.");
					}

					$sql = "UPDATE tb_parametros_generales SET valor_int = valor_int + 1 where id_parametro = 25";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([]) == false) {
						throw new Exception("Ocurrió un error al actualizar los datos de parametros generales.");
					}

				} else {

					if (trim($correo) != "") {
						$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
						$stmt->execute([$id_persona, $correo]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						if (count($result) > 0) {
							throw new Exception("El correo ya se encuentra registrado en el sistema.");
						}
					}

					$name_user = $numero_documento_cliente . "@gmail.com";

					if (trim($correo) != "") {
						$name_user = $correo;
					}

					$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_persona != ? AND name_user = ? ");
					$stmt->execute([$id_persona, $name_user]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, ingrese otro nombre de usuario.");
					}

					$sql = "UPDATE tb_persona SET ";
					$sql .= " nombres = ?, ";
					$sql .= " apellidos = ?, ";
					$sql .= " direccion = ?, ";
					$sql .= " correo = ?, ";
					$sql .= " telefono = ? ";
					$sql .= " WHERE id_persona = ? ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$nombres, $apellidos, $direccion, $correo, $telefono, $id_persona]) == false) {
						throw new Exception("Ocurrió un error al actualizar los datos del cliente.");
					}

				}

			} else {

				if (trim($correo) != "") {
					$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE correo = ? ");
					$stmt->execute([$correo]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El correo ya se encuentra registrado en el sistema.");
					}
				}

				$name_user = $numero_documento_cliente . "@gmail.com";

				if (trim($correo) != "") {
					$name_user = $correo;
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE name_user = ? ");
				$stmt->execute([$name_user]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) > 0) {
					throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, intente ingresar otro nombre de usuario.");
				}

				$sql = "INSERT INTO tb_persona (`id_persona`, `id_documento`, `num_documento`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo`, `fecha_nacimiento`, `sexo`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(p.id_persona) WHEN 0 THEN 1 ELSE (MAX(p.id_persona) + 1) end FROM `tb_persona` p),";
				$sql .= "?,?,?,?,?,?,?,now(),?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$codigo_documento_cliente, $numero_documento_cliente, $nombres, $apellidos, $direccion, $telefono, $correo, "masculino"]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("1. Error al registrar los datos del cliente.");
				}

				$stmt = $conexion->prepare("SELECT MAX(p.id_persona) as id_persona FROM `tb_persona` p");
				$stmt->execute([]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0) {
					throw new Exception("Error al seleccionar el id de persona.");
				}

				$id_persona = $result[0]['id_persona'];

				$sql = "INSERT INTO tb_cliente (`id_cliente`, `id_persona`, `name_user`, `pass_user`, `fecha_activacion`, `estado`, `src_imagen`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(c.id_cliente) WHEN 0 THEN 1 ELSE (MAX(c.id_cliente) + 1) end FROM `tb_cliente` c),";
				$sql .= "?,?,?,now(),?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_persona, $name_user, "1234", 1, "resources/global/images/default-profile.png"]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("Error al registrar el cliente en la base de datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET valor_int = valor_int + 1 where id_parametro = 25";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([]) == false) {
					throw new Exception("Ocurrió un error al actualizar los datos de parametros generales.");
				}

			}

			$id_documento_venta = $codigo_documento_venta;
			$stmt = $conexion->prepare("SELECT * FROM `tb_documento_venta` WHERE id_documento_venta = ?");
			$stmt->execute([$id_documento_venta]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de documento venta.");
			}
			$name_documento_venta = $result[0]['nombre_corto'];
			$codigo_documento_venta = $result[0]['cod_sunat'];
			$serie = $result[0]['serie'];
			$correlativo = $result[0]['correlativo'];
			$flag_doc_interno = $result[0]['flag_doc_interno'];


			$id_documento_cliente = $codigo_documento_cliente;
			$stmt = $conexion->prepare("SELECT * FROM `tb_documento_identidad` WHERE id_documento = ?");
			$stmt->execute([$id_documento_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de documento cliente.");
			}
			$name_documento_cliente = $result[0]['name_documento'];
			$codigo_documento_cliente = $result[0]['codigo_sunat'];


			$id_forma_pago = $codigo_forma_pago;
			$stmt = $conexion->prepare("SELECT * FROM `tb_forma_pago` WHERE id_forma_pago = ?");
			$stmt->execute([1]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de forma de pago.");
			}
			$name_forma_pago = $result[0]['name_forma_pago'];
			$codigo_forma_pago = $result[0]['cod_sunat'];

			$cliente = $nombres . " " . $apellidos;
			if (strtoupper($name_documento_venta) == "RUC") {
				$cliente = $nombres;
			}


			$stmt = $conexion->prepare("SELECT * FROM `tb_sucursal` WHERE id_sucursal = ?");
			$stmt->execute([$id_sucursal]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de sucursal.");
			}
			$ruta = $result[0]['ruta'];
			$token = $result[0]['token'];


			$id_moneda = $codigo_moneda;
			$stmt = $conexion->prepare("SELECT * FROM `tb_moneda` WHERE id_moneda = ?");
			$stmt->execute([1]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de forma de pago.");
			}
			$codigo_moneda = $result[0]['cod_sunat'];
			$signo_moneda = $result[0]['signo'];
			$abreviatura_moneda = $result[0]['abreviatura'];


			$pdf = "NOK";
			$xml = "NOK";
			$cdr = "NOK";

			$flag_envia_correo = false;
			if ($correo != "") {
				$flag_envia_correo = true;
			}

			$flag_envia_sunat = "1";
			$mensaje_sunat = "";

			//SI ES 0 (CERO) TIENE QUE GRABAR EN EL OSE
			if ($flag_doc_interno == "0") {

				$data = array(
					"operacion" => "generar_comprobante",
					"tipo_de_comprobante" => "$codigo_documento_venta",
					"serie" => "$serie",
					"numero" => "$correlativo",
					"sunat_transaction" => "1",
					"cliente_tipo_de_documento" => "$codigo_documento_cliente",
					"cliente_numero_de_documento" => "$numero_documento_cliente",
					"cliente_denominacion" => "$cliente",
					"cliente_direccion" => "$direccion",
					"cliente_email" => "$correo",
					"cliente_email_1" => "",
					"cliente_email_2" => "",
					"fecha_de_emision" => date('d-m-Y', strtotime($fecha)),
					"fecha_de_vencimiento" => "",
					"moneda" => $codigo_moneda,
					"tipo_de_cambio" => $tipo_cambio,
					"porcentaje_de_igv" => "18.00",
					"descuento_global" => "$total_descuento",
					"total_descuento" => "$total_descuento",
					"total_anticipo" => "",
					"total_gravada" => $total_gravada,
					"total_inafecta" => "",
					"total_exonerada" => "",
					"total_igv" => $total_igv,
					"total_gratuita" => "",
					"total_otros_cargos" => "",
					"total" => $total_total,
					"percepcion_tipo" => "",
					"percepcion_base_imponible" => "",
					"total_percepcion" => "",
					"total_incluido_percepcion" => "",
					"detraccion" => "false",
					"observaciones" => "",
					"documento_que_se_modifica_tipo" => "",
					"documento_que_se_modifica_serie" => "",
					"documento_que_se_modifica_numero" => "",
					"tipo_de_nota_de_credito" => "",
					"tipo_de_nota_de_debito" => "",
					"enviar_automaticamente_a_la_sunat" => "true",
					"enviar_automaticamente_al_cliente" => "$flag_envia_correo",
					"codigo_unico" => "",
					"condiciones_de_pago" => "",
					"medio_de_pago" => "$name_forma_pago",
					"placa_vehiculo" => "",
					"orden_compra_servicio" => "",
					"tabla_personalizada_codigo" => "",
					"formato_de_pdf" => "",
					"items" => array()
				);

				$dataDetalle = array();
				foreach ($detalle_venta as $key) {
					foreach ($key as $key1) {

						$name_tabla = $key1->name_tabla;
						$id_unidad_medida = 0;
						$unidad_medida = "ZZ";
						$codigo_producto = $key1->cod_producto;

						switch ($name_tabla) {
							case 'producto':
								$stmt = $conexion->prepare("SELECT * FROM `tb_accesorio` WHERE id_accesorio = ?");
								$stmt->execute([$codigo_producto]);
								$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
								if (count($result) == 0) {
									throw new Exception("Error al obtener el id de producto.");
								}
								$id_unidad_medida = $result[0]['id_unidad_medida'];
								break;
							case 'medicamento':
								$stmt = $conexion->prepare("SELECT * FROM `tb_medicamento` WHERE id_medicamento = ?");
								$stmt->execute([$codigo_producto]);
								$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
								if (count($result) == 0) {
									throw new Exception("Error al obtener el id de medicamento.");
								}
								$id_unidad_medida = $result[0]['id_unidad_medida'];
								break;
							case 'servicio':
								$id_unidad_medida = 0;
								break;
						}

						if ($id_unidad_medida != 0) {
							$stmt = $conexion->prepare("SELECT * FROM `tb_unidad_medida` WHERE id_unidad_medida = ?");
							$stmt->execute([$id_unidad_medida]);
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
							if (count($result) == 0) {
								throw new Exception("Error al obtener el id de unidad medida.");
							}
							$unidad_medida = $result[0]['cod_sunat'];
						}

						$dataDetalle[] = array(
							"unidad_de_medida" => "$unidad_medida",
							"codigo" => substr(strtoupper($key1->name_tabla), 0, 1) . $codigo_producto,
							"descripcion" => $key1->descripcion,
							"cantidad" => $key1->cantidad,
							"valor_unitario" => $key1->precio_unitario,
							"precio_unitario" => round($key1->precio_unitario + $key1->precio_unitario * 1, 2),
							"descuento" => $key1->descuento,
							"subtotal" => $key1->sub_total,
							"tipo_de_igv" => $key1->tipo_igv,
							"igv" => $key1->igv,
							"total" => $key1->total,
							"anticipo_regularizacion" => "",
							"anticipo_documento_serie" => "",
							"anticipo_documento_numero" => "",
						);

					}
				}

				$data['items'] = $dataDetalle;
				$data_json = json_encode($data);
				$respuesta = eviarDocumento($ruta, $token, $data_json);

				$leer_respuesta = json_decode($respuesta, true);

				if (isset($leer_respuesta['errors'])) {
					$mensaje_sunat = $leer_respuesta['errors'];
					$flag_envia_sunat = "0";

					// Manejar el error como advertencia y continuar
					$pdf = "NOK";
					$xml = "NOK";
					$cdr = "NOK";
					$mensaje_sunat = "Advertencia: La operación se registró localmente, pero no se pudo enviar al OSE. Detalles: $mensaje_sunat";
				} else {

					$pdf = $leer_respuesta['enlace'] . ".pdf";
					$xml = $leer_respuesta['enlace'] . ".xml";
					$cdr = $leer_respuesta['enlace'] . ".cdr";
					$aceptada_por_sunat = $leer_respuesta['aceptada_por_sunat'];
					$mensaje_sunat = $leer_respuesta['sunat_description'];
					$sunat_description = $leer_respuesta['sunat_description'];
					$sunat_note = $leer_respuesta['sunat_note'];
					$sunat_responsecode = $leer_respuesta['sunat_responsecode'];
					$sunat_soap_error = $leer_respuesta['sunat_soap_error'];
					$pdf_zip_base64 = $leer_respuesta['pdf_zip_base64'];
					$xml_zip_base64 = $leer_respuesta['xml_zip_base64'];
					$cdr_zip_base64 = $leer_respuesta['cdr_zip_base64'];
					$cadena_para_codigo_qr = $leer_respuesta['cadena_para_codigo_qr'];
					$codigo_hash = $leer_respuesta['codigo_hash'];

				}

			}

			$sql = "INSERT INTO tb_venta (`id_venta`, `id_sucursal`, `id_trabajador`, `id_documento_venta`,
								`name_documento_venta`, `codigo_documento_venta`, `serie`, `correlativo`,
								`id_documento_cliente`,`name_documento_cliente`, `codigo_documento_cliente`,
								`numero_documento_cliente`, `id_forma_pago`, `codigo_forma_pago`, `name_forma_pago`,
								`cliente`, `direccion`, `telefono`, `correo`, `fecha`, `fecha_vencimiento`,
								`descuento_total`, `sub_total`, `igv`, `total`, `estado`, `pdf`, `xml`, `cdr`, `ruta`,
								`token`, `flag_doc_interno`,`monto_recibido`, `vuelto`, `id_moneda`,
								`codigo_moneda`, `signo_moneda`, `abreviatura_moneda`, `flag_enviado`, `monto_tipo_cambio`,
							  `mensaje_sunat`) VALUES ";
			$sql .= "(";
			$sql .= "(SELECT CASE COUNT(o.id_venta) WHEN 0 THEN 1 ELSE (MAX(o.id_venta) + 1) end FROM `tb_venta` o),";
			$sql .= "?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,null,?,?,?,?,2,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([
				$id_sucursal,
				$id_trabajador,
				$id_documento_venta,
				$name_documento_venta,
				$codigo_documento_venta,
				$serie,
				$correlativo,
				$id_documento_cliente,
				$name_documento_cliente,
				$codigo_documento_cliente,
				$numero_documento_cliente,
				$id_forma_pago,
				$codigo_forma_pago,
				$name_forma_pago,
				$cliente,
				$direccion,
				$telefono,
				$correo,
				date('Y-m-d', strtotime($fecha)),
				$total_descuento,
				$total_gravada,
				$total_igv,
				$total_total,
				$pdf,
				$xml,
				$cdr,
				$ruta,
				$token,
				$flag_doc_interno,
				$monto_recibido,
				$vuelto,
				$id_moneda,
				$codigo_moneda,
				$signo_moneda,
				$abreviatura_moneda,
				$flag_envia_sunat,
				$tipo_cambio,
				$mensaje_sunat
			]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("1. Error al registrar la orden de venta en la base de datos.");
			}

			foreach ($detalle_venta as $key) {
				foreach ($key as $key1) {
					$sql = "INSERT INTO tb_detalle_venta (
						`id_detalle`, `id_venta`, `name_tabla`, `cod_producto`, `descripcion`,
						`cantidad`, `precio_unitario`, `descuento`, `sub_total`, `tipo_igv`,
						`igv`, `total`
					) VALUES (
						(SELECT CASE COUNT(o.id_detalle) WHEN 0 THEN 1 ELSE (MAX(o.id_detalle) + 1) END FROM `tb_detalle_venta` o),
						(SELECT MAX(id_venta) FROM `tb_venta`),
						?, ?, ?, ?, 0, 0, 0, 0, 0, 0
					)";
			
					$stmt = $conexion->prepare($sql);
					$stmt->execute([
						$key1->name_tabla,
						$key1->cod_producto,
						$key1->descripcion,
						$key1->cantidad
					]);
			
					if ($stmt->rowCount() == 0) {
						throw new Exception("Error al registrar el detalle de la orden de venta en la base de datos.");
					}

					$name_tabla = $key1->name_tabla;
					switch ($name_tabla) {
						case 'producto':
							$sql = "UPDATE tb_accesorio SET stock = stock - ? where id_accesorio = ?";
							$stmt = $conexion->prepare($sql);
							if ($stmt->execute([$key1->cantidad, $key1->cod_producto]) == false) {
								throw new Exception("Ocurrió un error al actualizar el stock.");
							}
							break;
						case 'medicamento':
							$sql = "UPDATE tb_medicamento SET stock = stock - ? where id_medicamento = ?";
							$stmt = $conexion->prepare($sql);
							if ($stmt->execute([$key1->cantidad, $key1->cod_producto]) == false) {
								throw new Exception("Ocurrió un error al actualizar el stock.");
							}
							break;
					}

				}
			}
			var_dump($detalle_venta);

			

			$stmt = $conexion->prepare("SELECT MAX(id_venta) as id_venta FROM `tb_venta`");
			$stmt->execute([]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de venta.");
			}
			$id_venta = $result[0]['id_venta'];

			$sql = "UPDATE tb_documento_venta SET correlativo = correlativo + 1 where id_documento_venta = ?";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([$id_documento_venta]) == false) {
				throw new Exception("Ocurrió un error al actualizar el correlativo.");
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Operación realizada correctamente. " . $mensaje_sunat;
			$VD1['id_venta'] = $id_venta;
			$VD1['serie'] = $serie;
			$VD1['correlativo'] = $correlativo;
			$VD = $VD1;
			$conexion->commit();

		} catch (PDOException $e) {

			$conexion->rollBack();
			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;

		} catch (Exception $exception) {

			$conexion->rollBack();
			$VD1['error'] = "SI";
			$VD1['message'] = $exception->getMessage();
			$VD = $VD1;

		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	public function update_1($id_venta, $codigo_documento_venta, $serie, $correlativo, $codigo_documento_cliente, $numero_documento_cliente, $nombres, $apellidos, $direccion, $telefono, $correo, $fecha, $codigo_moneda, $codigo_forma_pago, $total_descuento, $total_gravada, $total_igv, $total_total, $detalle_venta, $id_trabajador, $id_sucursal, $monto_recibido, $vuelto, $tipo_cambio)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_venta` WHERE id_venta = ?");
			$stmt->execute([$id_venta]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("No se encontró la orden de venta ó ya fue eliminada.");
			}
			if ($result[0]['estado'] == "2" || $result[0]['estado'] == "3") {
				throw new Exception("No se puede editar está venta, ya se encuentra pagada o anulada.");
			}

			$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_documento = ? AND num_documento = ?");
			$stmt->execute([$codigo_documento_cliente, $numero_documento_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$id_persona = 0;

			if (count($result) > 0) {

				$id_persona = $result[0]['id_persona'];

				$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_persona = ? ");
				$stmt->execute([$id_persona]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result) == 0) {

					if (trim($correo) != "") {
						$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
						$stmt->execute([$id_persona, $correo]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						if (count($result) > 0) {
							throw new Exception("El correo ya se encuentra registrado en el sistema.");
						}
					}

					$name_user = $numero_documento_cliente . "@gmail.com";

					if (trim($correo) != "") {
						$name_user = $correo;
					}

					$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_persona != ? AND name_user = ? ");
					$stmt->execute([$id_persona, $name_user]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, ingrese otro nombre de usuario.");
					}

					$sql = "UPDATE tb_persona SET ";
					$sql .= " nombres = ?, ";
					$sql .= " apellidos = ?, ";
					$sql .= " direccion = ?, ";
					$sql .= " correo = ?, ";
					$sql .= " telefono = ? ";
					$sql .= " WHERE id_persona = ? ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$nombres, $apellidos, $direccion, $correo, $telefono, $id_persona]) == false) {
						throw new Exception("Ocurrió un error al actualizar los datos del cliente.");
					}

					$sql = "INSERT INTO tb_cliente (`id_cliente`, `id_persona`, `name_user`, `pass_user`, `fecha_activacion`, `estado`, `src_imagen`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(c.id_cliente) WHEN 0 THEN 1 ELSE (MAX(c.id_cliente) + 1) end FROM `tb_cliente` c),";
					$sql .= "?,?,?,now(),?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_persona, $name_user, "1234", 1, "resources/global/images/default-profile.png"]);
					if ($stmt->rowCount() == 0) {
						throw new Exception("Error al registrar el cliente en la base de datos.");
					}

					$sql = "UPDATE tb_parametros_generales SET valor_int = valor_int + 1 where id_parametro = 25";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([]) == false) {
						throw new Exception("Ocurrió un error al actualizar los datos de parametros generales.");
					}

				} else {

					if (trim($correo) != "") {
						$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_persona != ? AND correo = ? ");
						$stmt->execute([$id_persona, $correo]);
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						if (count($result) > 0) {
							throw new Exception("El correo ya se encuentra registrado en el sistema.");
						}
					}

					$name_user = $numero_documento_cliente . "@gmail.com";

					if (trim($correo) != "") {
						$name_user = $correo;
					}

					$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE id_persona != ? AND name_user = ? ");
					$stmt->execute([$id_persona, $name_user]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, ingrese otro nombre de usuario.");
					}

					$sql = "UPDATE tb_persona SET ";
					$sql .= " nombres = ?, ";
					$sql .= " apellidos = ?, ";
					$sql .= " direccion = ?, ";
					$sql .= " correo = ?, ";
					$sql .= " telefono = ? ";
					$sql .= " WHERE id_persona = ? ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$nombres, $apellidos, $direccion, $correo, $telefono, $id_persona]) == false) {
						throw new Exception("Ocurrió un error al actualizar los datos del cliente.");
					}

				}

			} else {

				if (trim($correo) != "") {
					$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE correo = ? ");
					$stmt->execute([$correo]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result) > 0) {
						throw new Exception("El correo ya se encuentra registrado en el sistema.");
					}
				}

				$name_user = $numero_documento_cliente . "@gmail.com";

				if (trim($correo) != "") {
					$name_user = $correo;
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_cliente` WHERE name_user = ? ");
				$stmt->execute([$name_user]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) > 0) {
					throw new Exception("El nombre de usuario ya se encuentra registrado en el sistema, intente ingresar otro nombre de usuario.");
				}

				$sql = "INSERT INTO tb_persona (`id_persona`, `id_documento`, `num_documento`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo`, `fecha_nacimiento`, `sexo`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(p.id_persona) WHEN 0 THEN 1 ELSE (MAX(p.id_persona) + 1) end FROM `tb_persona` p),";
				$sql .= "?,?,?,?,?,?,?,now(),?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$codigo_documento_cliente, $numero_documento_cliente, $nombres, $apellidos, $direccion, $telefono, $correo, "masculino"]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("1. Error al registrar los datos del cliente.");
				}

				$stmt = $conexion->prepare("SELECT MAX(p.id_persona) as id_persona FROM `tb_persona` p");
				$stmt->execute([]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result) == 0) {
					throw new Exception("Error al seleccionar el id de persona.");
				}

				$id_persona = $result[0]['id_persona'];

				$sql = "INSERT INTO tb_cliente (`id_cliente`, `id_persona`, `name_user`, `pass_user`, `fecha_activacion`, `estado`, `src_imagen`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(c.id_cliente) WHEN 0 THEN 1 ELSE (MAX(c.id_cliente) + 1) end FROM `tb_cliente` c),";
				$sql .= "?,?,?,now(),?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_persona, $name_user, "1234", 1, "resources/global/images/default-profile.png"]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("Error al registrar el cliente en la base de datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET valor_int = valor_int + 1 where id_parametro = 25";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([]) == false) {
					throw new Exception("Ocurrió un error al actualizar los datos de parametros generales.");
				}

			}

			$id_documento_venta = $codigo_documento_venta;
			$stmt = $conexion->prepare("SELECT * FROM `tb_documento_venta` WHERE id_documento_venta = ?");
			$stmt->execute([$id_documento_venta]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de documento venta.");
			}
			$name_documento_venta = $result[0]['nombre_corto'];
			$codigo_documento_venta = $result[0]['cod_sunat'];
			$serie = $result[0]['serie'];
			$correlativo = $result[0]['correlativo'];
			$flag_doc_interno = $result[0]['flag_doc_interno'];


			$id_documento_cliente = $codigo_documento_cliente;
			$stmt = $conexion->prepare("SELECT * FROM `tb_documento_identidad` WHERE id_documento = ?");
			$stmt->execute([$id_documento_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de documento cliente.");
			}
			$name_documento_cliente = $result[0]['name_documento'];
			$codigo_documento_cliente = $result[0]['codigo_sunat'];


			$id_forma_pago = $codigo_forma_pago;
			$stmt = $conexion->prepare("SELECT * FROM `tb_forma_pago` WHERE id_forma_pago = ?");
			$stmt->execute([1]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de forma de pago.");
			}
			$name_forma_pago = $result[0]['name_forma_pago'];
			$codigo_forma_pago = $result[0]['cod_sunat'];

			$cliente = $nombres . " " . $apellidos;
			if (strtoupper($name_documento_venta) == "RUC") {
				$cliente = $nombres;
			}

			$stmt = $conexion->prepare("SELECT * FROM `tb_sucursal` WHERE id_sucursal = ?");
			$stmt->execute([$id_sucursal]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de sucursal.");
			}
			$ruta = $result[0]['ruta'];
			$token = $result[0]['token'];

			$id_moneda = $codigo_moneda;
			$stmt = $conexion->prepare("SELECT * FROM `tb_moneda` WHERE id_moneda = ?");
			$stmt->execute([1]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("Error al obtener el id de forma de pago.");
			}
			$codigo_moneda = $result[0]['cod_sunat'];
			$signo_moneda = $result[0]['signo'];
			$abreviatura_moneda = $result[0]['abreviatura'];


			$pdf = "NOK";
			$xml = "NOK";
			$cdr = "NOK";

			$flag_envia_correo = false;
			if ($correo != "") {
				$flag_envia_correo = true;
			}

			$flag_envia_sunat = "1";
			$mensaje_sunat = "";

			//SI ES 0 (CERO) TIENE QUE GRABAR EN EL OSE
			if ($flag_doc_interno == "0") {

				$data = array(
					"operacion" => "generar_comprobante",
					"tipo_de_comprobante" => "$codigo_documento_venta",
					"serie" => "$serie",
					"numero" => "$correlativo",
					"sunat_transaction" => "1",
					"cliente_tipo_de_documento" => "$codigo_documento_cliente",
					"cliente_numero_de_documento" => "$numero_documento_cliente",
					"cliente_denominacion" => "$cliente",
					"cliente_direccion" => "$direccion",
					"cliente_email" => "$correo",
					"cliente_email_1" => "",
					"cliente_email_2" => "",
					"fecha_de_emision" => date('d-m-Y', strtotime($fecha)),
					"fecha_de_vencimiento" => "",
					"moneda" => $codigo_moneda,
					"tipo_de_cambio" => $tipo_cambio,
					"porcentaje_de_igv" => "18.00",
					"descuento_global" => "$total_descuento",
					"total_descuento" => "$total_descuento",
					"total_anticipo" => "",
					"total_gravada" => $total_gravada,
					"total_inafecta" => "",
					"total_exonerada" => "",
					"total_igv" => $total_igv,
					"total_gratuita" => "",
					"total_otros_cargos" => "",
					"total" => $total_total,
					"percepcion_tipo" => "",
					"percepcion_base_imponible" => "",
					"total_percepcion" => "",
					"total_incluido_percepcion" => "",
					"detraccion" => "false",
					"observaciones" => "",
					"documento_que_se_modifica_tipo" => "",
					"documento_que_se_modifica_serie" => "",
					"documento_que_se_modifica_numero" => "",
					"tipo_de_nota_de_credito" => "",
					"tipo_de_nota_de_debito" => "",
					"enviar_automaticamente_a_la_sunat" => "true",
					"enviar_automaticamente_al_cliente" => "$flag_envia_correo",
					"codigo_unico" => "",
					"condiciones_de_pago" => "",
					"medio_de_pago" => "$name_forma_pago",
					"placa_vehiculo" => "",
					"orden_compra_servicio" => "",
					"tabla_personalizada_codigo" => "",
					"formato_de_pdf" => "",
					"items" => array()
				);

				$dataDetalle = array();
				foreach ($detalle_venta as $key) {
					foreach ($key as $key1) {

						$name_tabla = $key1->name_tabla;
						$id_unidad_medida = 0;
						$unidad_medida = "ZZ";
						$codigo_producto = $key1->cod_producto;

						switch ($name_tabla) {
							case 'producto':
								$stmt = $conexion->prepare("SELECT * FROM `tb_accesorio` WHERE id_accesorio = ?");
								$stmt->execute([$codigo_producto]);
								$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
								if (count($result) == 0) {
									throw new Exception("Error al obtener el id de accesorio.");
								}
								$id_unidad_medida = $result[0]['id_unidad_medida'];
								break;
							case 'medicamento':
								$stmt = $conexion->prepare("SELECT * FROM `tb_medicamento` WHERE id_medicamento = ?");
								$stmt->execute([$codigo_producto]);
								$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
								if (count($result) == 0) {
									throw new Exception("Error al obtener el id de medicamento.");
								}
								$id_unidad_medida = $result[0]['id_unidad_medida'];
								break;
							case 'servicio':
								$id_unidad_medida = 0;
								break;
						}

						if ($id_unidad_medida != 0) {
							$stmt = $conexion->prepare("SELECT * FROM `tb_unidad_medida` WHERE id_unidad_medida = ?");
							$stmt->execute([$id_unidad_medida]);
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
							if (count($result) == 0) {
								throw new Exception("Error al obtener el id de unidad medida.");
							}
							$unidad_medida = $result[0]['cod_sunat'];
						}

						$dataDetalle[] = array(
							"unidad_de_medida" => "$unidad_medida",
							"codigo" => substr(strtoupper($key1->name_tabla), 0, 1) . $codigo_producto,
							"descripcion" => $key1->descripcion,
							"cantidad" => $key1->cantidad,
							"valor_unitario" => $key1->precio_unitario,
							"precio_unitario" => round($key1->precio_unitario + $key1->precio_unitario * 1, 2),
							"descuento" => $key1->descuento,
							"subtotal" => $key1->sub_total,
							"tipo_de_igv" => $key1->tipo_igv,
							"igv" => $key1->igv,
							"total" => $key1->total,
							"anticipo_regularizacion" => "",
							"anticipo_documento_serie" => "",
							"anticipo_documento_numero" => "",
						);

					}
				}

				$data['items'] = $dataDetalle;
				$data_json = json_encode($data);
				$respuesta = eviarDocumento($ruta, $token, $data_json);

				$leer_respuesta = json_decode($respuesta, true);

				if (isset($leer_respuesta['errors'])) {

					$mensaje_sunat = $leer_respuesta['errors'];
					$flag_envia_sunat = "0";
					throw new Exception("$mensaje_sunat");

				} else {

					$pdf = $leer_respuesta['enlace'] . ".pdf";
					$xml = $leer_respuesta['enlace'] . ".xml";
					$cdr = $leer_respuesta['enlace'] . ".cdr";
					$aceptada_por_sunat = $leer_respuesta['aceptada_por_sunat'];
					$mensaje_sunat = $leer_respuesta['sunat_description'];
					$sunat_description = $leer_respuesta['sunat_description'];
					$sunat_note = $leer_respuesta['sunat_note'];
					$sunat_responsecode = $leer_respuesta['sunat_responsecode'];
					$sunat_soap_error = $leer_respuesta['sunat_soap_error'];
					$pdf_zip_base64 = $leer_respuesta['pdf_zip_base64'];
					$xml_zip_base64 = $leer_respuesta['xml_zip_base64'];
					$cdr_zip_base64 = $leer_respuesta['cdr_zip_base64'];
					$cadena_para_codigo_qr = $leer_respuesta['cadena_para_codigo_qr'];
					$codigo_hash = $leer_respuesta['codigo_hash'];

				}

			}

			$sql = "UPDATE `tb_venta` SET `id_sucursal` = ?,
											`id_trabajador` = ?,
											`id_documento_venta` = ?,
											`name_documento_venta` = ?,
											`codigo_documento_venta` = ?,
											`serie` = ?,
											`correlativo` = ?,
											`id_documento_cliente` = ?,
											`name_documento_cliente` = ?,
											`codigo_documento_cliente` = ?,
											`numero_documento_cliente` = ?,
											`id_forma_pago` = ?,
											`codigo_forma_pago` = ?,
											`name_forma_pago` = ?,
											`cliente` = ?,
											`direccion` = ?,
											`telefono` = ?,
											`correo` = ?,
											`fecha` = ?,
											`descuento_total` = ?,
											`sub_total` = ?,
											`igv` = ?,
											`total` = ?,
											`pdf` = ?,
											`xml` = ?,
											`cdr` = ?,
											`ruta` = ?,
											`token` = ?,
											`flag_doc_interno` = ?,
											`monto_recibido` = ?,
											`vuelto` = ?,
											`id_moneda` = ?,
											`codigo_moneda` = ?,
											`signo_moneda` = ?,
											`estado` = 2,
											`abreviatura_moneda` = ?,
											`mensaje_sunat` = ?,
											`flag_enviado` = ?,
											`monto_tipo_cambio` = ?
								WHERE id_venta = ?";
			$stmt = $conexion->prepare($sql);
			$flag_update = $stmt->execute([
				$id_sucursal,
				$id_trabajador,
				$id_documento_venta,
				$name_documento_venta,
				$codigo_documento_venta,
				$serie,
				$correlativo,
				$id_documento_cliente,
				$name_documento_cliente,
				$codigo_documento_cliente,
				$numero_documento_cliente,
				$id_forma_pago,
				$codigo_forma_pago,
				$name_forma_pago,
				$cliente,
				$direccion,
				$telefono,
				$correo,
				date('Y-m-d', strtotime($fecha)),
				$total_descuento,
				$total_gravada,
				$total_igv,
				$total_total,
				$pdf,
				$xml,
				$cdr,
				$ruta,
				$token,
				$flag_doc_interno,
				$monto_recibido,
				$vuelto,
				$id_moneda,
				$codigo_moneda,
				$signo_moneda,
				$abreviatura_moneda,
				$mensaje_sunat,
				$flag_envia_sunat,
				$tipo_cambio,
				$id_venta
			]);
			if ($flag_update == false) {
				throw new Exception("1. Error al registrar la orden de venta en la base de datos.");
			}

			$sql = "DELETE FROM tb_detalle_venta WHERE id_venta = ?";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([$id_venta]) == false) {
				throw new Exception("Ocurrió un error al eliminar el detalle de la orden de venta.");
			}

			foreach ($detalle_venta as $key) {
				foreach ($key as $key1) {
					$sql = "INSERT INTO tb_detalle_venta (`id_detalle`, `id_venta`, `name_tabla`, `cod_producto`, `descripcion`,
																									`cantidad`, `precio_unitario`, `descuento`, `sub_total`, `tipo_igv`,
																									`igv`, `total`) VALUES ";
					$sql .= "(";
					$sql .= "(SELECT CASE COUNT(o.id_detalle) WHEN 0 THEN 1 ELSE (MAX(o.id_detalle) + 1) end FROM `tb_detalle_venta` o),";
					$sql .= "?,";
					$sql .= "?,?,?,?,?,?,?,?,?,?";
					$sql .= ")";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([
						$id_venta,
						$key1->name_tabla,
						$key1->cod_producto,
						$key1->descripcion,
						$key1->cantidad,
						$key1->precio_unitario,
						$key1->descuento,
						$key1->sub_total,
						$key1->tipo_igv,
						$key1->igv,
						$key1->total
					]);
					if ($stmt->rowCount() == 0) {
						throw new Exception("2. Error al registrar la orden de venta en la base de datos.");
					}

					$name_tabla = $key1->name_tabla;
					switch ($name_tabla) {
						case 'producto':
							$sql = "UPDATE tb_accesorio SET stock = stock - ? where id_accesorio = ?";
							$stmt = $conexion->prepare($sql);
							if ($stmt->execute([$key1->cantidad, $key1->cod_producto]) == false) {
								throw new Exception("Ocurrió un error al actualizar el stock.");
							}
							break;
						case 'medicamento':
							$sql = "UPDATE tb_medicamento SET stock = stock - ? where id_medicamento = ?";
							$stmt = $conexion->prepare($sql);
							if ($stmt->execute([$key1->cantidad, $key1->cod_producto]) == false) {
								throw new Exception("Ocurrió un error al actualizar el stock.");
							}
							break;
					}

				}
			}

			$sql = "UPDATE tb_documento_venta SET correlativo = correlativo + 1 where id_documento_venta = ?";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([$id_documento_venta]) == false) {
				throw new Exception("Ocurrió un error al actualizar el correlativo.");
			}

			$VD1['error'] = "NO";
			$VD1['message'] = "Operación realizada correctamente. " . $mensaje_sunat;
			$VD1['id_venta'] = $id_venta;
			$VD1['serie'] = $serie;
			$VD1['correlativo'] = $correlativo;
			$VD = $VD1;
			$conexion->commit();

		} catch (PDOException $e) {

			$conexion->rollBack();
			$VD1['error'] = "SI";
			$VD1['message'] = $e->getMessage();
			$VD = $VD1;

		} catch (Exception $exception) {

			$conexion->rollBack();
			$VD1['error'] = "SI";
			$VD1['message'] = $exception->getMessage();
			$VD = $VD1;

		} finally {
			$conexionClass->Close();
		}
		return $VD;
	}

	public function update_ruta_pdf($id_venta, $pdf)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_venta` WHERE id_venta = ?");
			$stmt->execute([$id_venta]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) == 0) {
				throw new Exception("1. No se encontró el registro de la venta a editar el enlace.");
			}

			$sql = "UPDATE tb_venta SET ";
			$sql .= " pdf = ? ";
			$sql .= " WHERE id_venta = ? ";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([$pdf, $id_venta]) == false) {
				throw new Exception("Error al actualizar el enlace del documento.");
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

	public function delete($id_venta)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_venta` WHERE id_venta = ?");
			$stmt->execute([$id_venta]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("1. No se encontró el registro de la venta.");
			}

			if ($result[0]['estado'] != "1") {
				throw new Exception("No puedes eliminar una orden ya se encuentra enviada o anulada.");
			}

			$stmt = $conexion->prepare("DELETE FROM tb_detalle_venta WHERE id_venta = ?");
			$stmt->execute([$id_venta]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Ocurrió un error al eliminar el detalle de la orden de venta.");
			}

			$stmt = $conexion->prepare("DELETE FROM tb_venta WHERE id_venta = ?");
			$stmt->execute([$id_venta]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Ocurrió un error al eliminar la orden de venta.");
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

	public function anular($id_venta)
	{
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("SELECT * FROM `tb_venta` WHERE id_venta = ?");
			$stmt->execute([$id_venta]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("1. No se encontró el registro de la venta.");
			}

			if ($result[0]['estado'] != "2") {
				throw new Exception("No puedes anular una orden que no se encuentra enviada o ya está anulada.");
			}

			$flag_enviado = 1;
			/**/
			$pdf = $result[0]['pdf'];
			$flag_doc_interno = $result[0]['flag_doc_interno'];
			$mensaje_sunat = "";

			if ($flag_doc_interno == 0) {

				$ruta = $result[0]['ruta'];
				$token = $result[0]['token'];
				$serie = $result[0]['serie'];
				$correlativo = $result[0]['correlativo'];
				$codigo_documento_venta = $result[0]['codigo_documento_venta'];
				$data = array(
					"operacion" => "generar_anulacion",
					"tipo_de_comprobante" => $codigo_documento_venta,
					"serie" => $serie,
					"numero" => $correlativo,
					"motivo" => "ERROR DEL SISTEMA",
					"codigo_unico" => ""
				);

				$data_json = json_encode($data);
				$respuesta = eviarDocumento($ruta, $token, $data_json);
				$leer_respuesta = json_decode($respuesta, true);
				if (!isset($leer_respuesta['errors'])) {
					$pdf = $leer_respuesta['enlace'] . '.pdf';
					$mensaje_sunat = $leer_respuesta['sunat_ticket_numero'];
				} else {
					$mensaje_sunat = $leer_respuesta['errors'];
					$flag_enviado = 0;
				}

			}

			$mensaje_error = "Ocurrió un error al actualizar el estado de la orden de venta. ";

			$stmt = $conexion->prepare("UPDATE tb_venta SET estado = '3', flag_enviado = ?
																		WHERE id_venta = ?");
			$stmt->execute([$flag_enviado, $id_venta]);
			if ($stmt->rowCount() == 0) {
				if ($flag_doc_interno == 1) {
					$mensaje_error .= "Este mensaje retornó del OSE(Operador de Servicios Electrónicos) : ";
					$mensaje_error .= $mensaje_sunat;
				}
				throw new Exception($mensaje_error);
			}

			$stmt = $conexion->prepare("SELECT * FROM `tb_detalle_venta` WHERE id_venta = ?");
			$stmt->execute([$id_venta]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 0) {
				throw new Exception("3. No se encontraron registros en el detalle de la orden.");
			}

			foreach ($result as $key) {

				$name_tabla = $key['name_tabla'];
				switch ($name_tabla) {
					case 'accesorio':
						$sql = "UPDATE tb_accesorio SET stock = stock + ? where id_accesorio = ?";
						$stmt = $conexion->prepare($sql);
						if ($stmt->execute([$key['cantidad'], $key['cod_producto']]) == false) {
							throw new Exception("Ocurrió un error al actualizar el stock.");
						}
						break;
					case 'medicamento':
						$sql = "UPDATE tb_medicamento SET stock = stock + ? where id_medicamento = ?";
						$stmt = $conexion->prepare($sql);
						if ($stmt->execute([$key['cantidad'], $key['cod_producto']]) == false) {
							throw new Exception("Ocurrió un error al actualizar el stock.");
						}
						break;
				}

			}

			$sql = "UPDATE tb_venta SET ";
			$sql .= " pdf = ? ";
			$sql .= " WHERE id_venta = ? ";
			$stmt = $conexion->prepare($sql);
			if ($stmt->execute([$pdf, $id_venta]) == false) {
				$mensaje_error = "Error al actualizar el enlace de pdf en la base de datos. ";
				$mensaje_error .= "Este mensaje retornó del OSE(Operador de Servicios Electrónicos) : ";
				$mensaje_error .= $mensaje_sunat;
				throw new Exception($mensaje_error);
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

$OBJ_ORDEN_VENTA = new ClassOrdenVenta();

?>