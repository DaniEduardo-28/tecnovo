<?php

	class ClassOrdenCompra extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getCount($id_sucursal,$valor,$fecha_inicio,$fecha_fin,$tipo_busqueda) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_orden_compra` o
								INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
								WHERE o.fecha_orden >= ? AND o.fecha_orden < ? AND o.id_sucursal = ? ";

				$parametros[] = $fecha_inicio;
				$parametros[] = $fecha_fin;
				$parametros[] = $id_sucursal;

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

		public function show($id_sucursal,$valor,$fecha_inicio,$fecha_fin,$tipo_busqueda,$offset,$limit) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT o.*,p.nombre_proveedor,t.nombres_trabajador,m.name_metodo,mon.signo as signo_moneda,
								(SELECT COUNT(*) FROM tb_detalle_compra dc WHERE dc.id_orden_compra = o.id_orden_compra) AS num_registros,
								(SELECT SUM(dc.precio_unitario*dc.cantidad_solicitada) FROM tb_detalle_compra dc WHERE dc.id_orden_compra = o.id_orden_compra) AS total
								FROM `tb_orden_compra` o
								INNER JOIN tb_moneda mon ON mon.id_moneda = o.id_moneda
								INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
								INNER JOIN vw_trabajadores t ON t.id_trabajador = o.id_trabajador
								INNER JOIN tb_metodo_envio m ON m.id_metodo_envio = o.id_metodo_envio
								WHERE o.fecha_orden >= ? AND o.fecha_orden < ? AND o.id_sucursal = ? ";

				$parametros[] = $fecha_inicio;
				$parametros[] = $fecha_fin;
				$parametros[] = $id_sucursal;

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

		public function getCount1($id_sucursal,$valor,$fecha_inicio,$fecha_fin,$tipo_busqueda) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_orden_compra` o
								INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
								WHERE o.fecha_orden >= ? AND o.fecha_orden < ? AND o.estado in ('0','1')
								AND o.id_sucursal = ? ";

				$parametros[] = $fecha_inicio;
				$parametros[] = $fecha_fin;
				$parametros[] = $id_sucursal;

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

		public function show1($id_sucursal,$valor,$fecha_inicio,$fecha_fin,$tipo_busqueda,$offset,$limit) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT o.*,p.nombre_proveedor,t.nombres_trabajador,m.name_metodo,mon.signo as signo_moneda,
								(SELECT COUNT(*) FROM tb_detalle_compra dc WHERE dc.id_orden_compra = o.id_orden_compra) AS num_registros,
								(SELECT SUM(dc.precio_unitario*dc.cantidad_solicitada) FROM tb_detalle_compra dc WHERE dc.id_orden_compra = o.id_orden_compra) AS total
								FROM `tb_orden_compra` o
								INNER JOIN tb_moneda mon ON mon.id_moneda = o.id_moneda
								INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
								INNER JOIN vw_trabajadores t ON t.id_trabajador = o.id_trabajador
								INNER JOIN tb_metodo_envio m ON m.id_metodo_envio = o.id_metodo_envio
								WHERE o.fecha_orden >= ? AND o.fecha_orden < ? AND o.estado in ('0','1')
								AND o.id_sucursal = ? ";

				$parametros[] = $fecha_inicio;
				$parametros[] = $fecha_fin;
				$parametros[] = $id_sucursal;

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

		public function getDataEditOrdenCompra($id_orden_compra) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$stmt = $conexion->prepare("SELECT * FROM `tb_orden_compra` WHERE id_orden_compra = ? AND estado = '0'");
				$stmt->execute([$id_orden_compra]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontró la orden a editar, o ya fue cambiada de estado.");
				}

				$sql = "SELECT * FROM vw_orden_compra
								WHERE id_orden_compra = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_orden_compra]);
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

		public function getDataVerOrdenCompra($id_orden_compra) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$sql = "SELECT * FROM vw_orden_compra
								WHERE id_orden_compra = ? ";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_orden_compra]);
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

		public function getCountDetalleParaOrden($id_sucursal,$tipo,$valor) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

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
					case 'accesorio':
						$sql .= "SELECT count(*) as cantidad FROM tb_accesorio WHERE id_sucursal = ? AND name_accesorio LIKE ? ";
						$parametros[] = $id_sucursal;
						$parametros[] = $valor;
						break;
					default:
						throw new Exception("Error al validar la busqueda de la tabla.");
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

		public function getDataPrintOrdenCompra($id_orden_compra) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$sql = "SELECT * FROM vw_orden_compra
								WHERE id_orden_compra = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_orden_compra]);
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

		public function getDataEditOrdenCompraIngreso($id_orden_compra) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$stmt = $conexion->prepare("SELECT * FROM `tb_orden_compra` WHERE id_orden_compra = ? AND estado in ('0','1') ");
				$stmt->execute([$id_orden_compra]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontró la orden a editar, o ya fue cambiada de estado.");
				}

				$sql = "SELECT o.*,m.name_metodo FROM vw_orden_compra o INNER JOIN tb_metodo_envio m on m.id_metodo_envio = o.id_metodo_envio
								WHERE id_orden_compra = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_orden_compra]);
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

		public function showDetalleParaOrden($id_sucursal,$tipo,$valor,$offset,$limit) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$valor = "%$valor%";
				$sql = "";
				$parametros = null;
				switch ($tipo) {
					case 'medicamento':
						$sql .= "SELECT name_medicamento as descripcion,id_medicamento as cod_producto,
										id_moneda,precio_compra as precio_unitario, src_imagen, stock
										FROM tb_medicamento WHERE id_sucursal = ? AND name_medicamento LIKE ? ";
						$parametros[] = $id_sucursal;
						$parametros[] = $valor;
						break;
					case 'accesorio':
						$sql .= "SELECT name_accesorio as descripcion,id_accesorio as cod_producto,
										id_moneda,precio_compra as precio_unitario, src_imagen, stock
										FROM tb_accesorio WHERE id_sucursal = ? AND name_accesorio LIKE ? ";
						$parametros[] = $id_sucursal;
						$parametros[] = $valor;
						break;
					default:
						throw new Exception("Error al validar la busqueda de la tabla.");
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

		public function insert($id_sucursal,$id_orden_compra,$id_proveedor,$id_trabajador,$id_metodo_envio,$codigo_moneda,$fecha_orden,$fecha_entrega,$observaciones,$detalle_compra) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";
			try {

				$conexion->beginTransaction();

				$sql = "INSERT INTO tb_orden_compra (`id_orden_compra`, `id_sucursal`, `id_metodo_envio`, `id_proveedor`, `id_trabajador`, `fecha_orden`, `fecha_entrega`, `observaciones`, `estado`, `id_moneda`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(o.id_orden_compra) WHEN 0 THEN 1 ELSE (MAX(o.id_orden_compra) + 1) end FROM `tb_orden_compra` o),";
				$sql .= "?,?,?,?,NOW(),?,?,?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_sucursal,$id_metodo_envio,$id_proveedor,$id_trabajador,$fecha_entrega,$observaciones,'0',$codigo_moneda]);
				if ($stmt->rowCount()==0) {
					throw new Exception("1. Error al registrar la orden de compra en la base de datos.");
				}

				foreach ($detalle_compra as $key) {
					foreach ($key as $key1) {
						$sql = "INSERT INTO tb_detalle_compra (`id_orden_compra`, `name_tabla`, `cod_producto`, `cantidad_solicitada`, `cantidad_ingresada`, `precio_unitario`, `notas`) VALUES ";
						$sql .= "(";
						$sql .= "(SELECT MAX(o.id_orden_compra) FROM `tb_orden_compra` o),";
						$sql .= "?,?,?,?,?,?";
						$sql .= ")";
						$stmt = $conexion->prepare($sql);
						$stmt->execute([$key1->name_tabla,$key1->cod_producto,$key1->cantidad_solicitada,'0',$key1->precio_unitario,$key1->notas]);
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

		public function update($id_sucursal,$id_orden_compra,$id_proveedor,$id_trabajador,$id_metodo_envio,$codigo_moneda,$fecha_orden,$fecha_entrega,$observaciones,$detalle_compra) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_orden_compra` WHERE id_orden_compra = ? AND estado = '0'");
				$stmt->execute([$id_orden_compra]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontró la orden a editar, o ya fue cambiada de estado.");
				}

				$sql = "UPDATE tb_orden_compra SET ";
				$sql .=" id_metodo_envio = ?, ";
				$sql .=" id_proveedor = ?, ";
				$sql .=" id_trabajador = ?, ";
				$sql .=" fecha_entrega = ?, ";
				$sql .=" id_moneda = ?, ";
				$sql .=" observaciones = ? ";
				$sql .=" WHERE id_orden_compra = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_metodo_envio,$id_proveedor,$id_trabajador,$fecha_entrega,$codigo_moneda,$observaciones,$id_orden_compra])==false) {
					throw new Exception("1. Error al actualizar los datos de la orden de compra.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_detalle_compra WHERE id_orden_compra = ?");
				$stmt->execute([$id_orden_compra]);
				if ($stmt->rowCount()==0) {
					throw new Exception("2. Ocurrió un error al actualizar el detalle de la orden.");
				}

				foreach ($detalle_compra as $key) {
					foreach ($key as $key1) {
						$sql = "INSERT INTO tb_detalle_compra (`id_orden_compra`, `name_tabla`, `cod_producto`, `cantidad_solicitada`, `cantidad_ingresada`, `precio_unitario`, `notas`) VALUES ";
						$sql .= "(";
						$sql .= "?,?,?,?,?,?,?";
						$sql .= ")";
						$stmt = $conexion->prepare($sql);
						$stmt->execute([$id_orden_compra,$key1->name_tabla,$key1->cod_producto,$key1->cantidad_solicitada,'0',$key1->precio_unitario,$key1->notas]);
						if ($stmt->rowCount()==0) {
							throw new Exception("3. Error al registrar la orden de compra en la base de datos.");
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

		public function delete($id_orden_compra) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_orden_compra` WHERE id_orden_compra = ? AND estado = '0'");
				$stmt->execute([$id_orden_compra]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontró la orden a anular, o ya fue cambiada de estado.");
				}

				$stmt = $conexion->prepare("UPDATE tb_orden_compra SET estado = '3' WHERE id_orden_compra = ?");
				$stmt->execute([$id_orden_compra]);
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

		public function eliminarOrden($id_orden_compra) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {
				$conexion->beginTransaction();
		
				// Verificar si la orden está en estado "Anulado"
				$stmt = $conexion->prepare("SELECT * FROM `tb_orden_compra` WHERE id_orden_compra = ? AND estado = '3'");
				$stmt->execute([$id_orden_compra]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
				if (count($result) == 0) {
					throw new Exception("No se encontró la orden en estado 'Anulado' o ya fue eliminada.");
				}
		
				// Eliminar registros del detalle de la orden
				$stmt = $conexion->prepare("DELETE FROM tb_detalle_compra WHERE id_orden_compra = ?");
				$stmt->execute([$id_orden_compra]);
		
				// Eliminar la orden de compra
				$stmt = $conexion->prepare("DELETE FROM tb_orden_compra WHERE id_orden_compra = ?");
				$stmt->execute([$id_orden_compra]);
		
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

	$OBJ_ORDEN_COMPRA = new ClassOrdenCompra();

?>
