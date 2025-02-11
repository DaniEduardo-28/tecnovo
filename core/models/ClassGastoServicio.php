<?php

	class ClassGastoServicio extends Conexion {

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
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_gasto_servicio` o
								INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
								WHERE o.fecha_emision >= ? AND o.fecha_emision < ? AND o.id_sucursal = ? ";

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
				$sql = "SELECT o.*,p.nombre_proveedor,t.nombres_trabajador,m.desc_gasto,dv.nombre,mon.signo as signo_moneda,
								(SELECT SUM(dc.monto_gastado) FROM tb_detalle_gastoserv dc WHERE dc.id_gasto_servicio = o.id_gasto_servicio) AS total
								FROM `tb_gasto_servicio` o
								INNER JOIN tb_moneda mon ON mon.id_moneda = o.id_moneda
								INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
								INNER JOIN vw_trabajadores t ON t.id_trabajador = o.id_trabajador
								INNER JOIN tb_tipo_gasto m ON m.id_tipo_gasto = o.id_tipo_gasto 
                                INNER JOIN tb_documento_venta dv ON dv.id_documento_venta = o.id_documento_venta 
								WHERE o.fecha_emision >= ? AND o.fecha_emision < ? AND o.id_sucursal = ? ";

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
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_gasto_servicio` o
								INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
								WHERE o.fecha_emision >= ? AND o.fecha_emision < ? AND o.estado in ('0','1')
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
				$sql = "SELECT o.*,p.nombre_proveedor,t.nombres_trabajador,m.desc_gasto,dv.nombre,mon.signo as signo_moneda,
								(SELECT SUM(dc.monto_gastado) FROM tb_detalle_gastoserv dc WHERE dc.id_gasto_servicio = o.id_gasto_servicio) AS total
								FROM `tb_gasto_servicio` o
								INNER JOIN tb_moneda mon ON mon.id_moneda = o.id_moneda
								INNER JOIN vw_proveedor p ON p.id_proveedor = o.id_proveedor
								INNER JOIN vw_trabajadores t ON t.id_trabajador = o.id_trabajador
								INNER JOIN tb_tipo_gasto m ON m.id_tipo_gasto = o.id_tipo_gasto 
                                INNER JOIN tb_documento_venta dv ON dv.id_documento_venta = o.id_documento_venta
								WHERE o.fecha_emision >= ? AND o.fecha_emision < ? AND o.estado in ('0','1')
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

		public function getDataEditGastoServicio($id_gasto_servicio) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$stmt = $conexion->prepare("SELECT * FROM `tb_gasto_servicio` WHERE id_gasto_servicio = ? AND estado = '0'");
				$stmt->execute([$id_gasto_servicio]);
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

		public function getDataVerGastoServicio($id_gasto_servicio) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$sql = "SELECT * FROM `tb_gasto_servicio`
								WHERE id_gasto_servicio = ? ";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_gasto_servicio]);
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


        public function insert($id_sucursal,$id_gasto_servicio, $id_proveedor, $id_trabajador, $id_tipo_gasto, $codigo_moneda, $id_documento_venta, $fecha_emision, $serie, $correlativo, $detalle_gastoserv) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";
			try {

				$conexion->beginTransaction();

				$sql = "INSERT INTO tb_gasto_servicio (`id_gasto_servicio`, `id_sucursal`, `id_tipo_gasto`, `id_proveedor`, `id_trabajador`, `fecha_emision`, `serie`, `correlativo`, `estado`, `id_moneda`, `id_documento_venta`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(o.id_gasto_servicio) WHEN 0 THEN 1 ELSE (MAX(o.id_gasto_servicio) + 1) end FROM `tb_gasto_servicio` o),";
				$sql .= "?,?,?,?,NOW(),?,?,?,?";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_sucursal,$id_tipo_gasto,$id_proveedor,$id_trabajador,$fecha_emision,$serie,$correlativo,'0',$codigo_moneda,$id_documento_venta]);
				if ($stmt->rowCount()==0) {
					throw new Exception("1. Error al registrar la orden en la base de datos.");
				}

				foreach ($detalle_gastoserv as $key) {
					foreach ($key as $key1) {
						$sql = "INSERT INTO tb_detalle_gastoserv (`id_gasto_servicio`, `descripcion_gasto`, `monto_gastado`) VALUES ";
						$sql .= "(";
						$sql .= "(SELECT MAX(o.id_gasto_servicio) FROM `tb_gasto_servicio` o),";
						$sql .= "?,?";
						$sql .= ")";
						$stmt = $conexion->prepare($sql);
						$stmt->execute([$key1->descripcion_gasto,$key1->monto_gastado]);
						if ($stmt->rowCount()==0) {
							throw new Exception("2. Error al registrar la orden en la base de datos.");
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

		public function update($id_sucursal,$id_gasto_servicio,$id_proveedor,$id_trabajador,$id_tipo_gasto,$codigo_moneda,$id_documento_venta,$fecha_emision,$serie,$correlativo,$detalle_gastoserv) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_gasto_servicio` WHERE id_gasto_servicio = ? AND estado = '0'");
				$stmt->execute([$id_gasto_servicio]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontró la orden a editar, o ya fue cambiada de estado.");
				}

				$sql = "UPDATE tb_gasto_servicio SET ";
				$sql .=" id_tipo_gasto = ?, ";
				$sql .=" id_proveedor = ?, ";
				$sql .=" id_trabajador = ?, ";
				$sql .=" fecha_emision = ?, ";
                $sql .=" serie = ?, ";
                $sql .=" correlativo = ?, ";
				$sql .=" id_moneda = ?, ";
                $sql .=" id_documento_venta = ? ";
				$sql .=" WHERE id_gasto_servicio = ? ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$id_tipo_gasto,$id_proveedor,$id_trabajador,$fecha_emision,$codigo_moneda,$id_documento_venta,$serie,$correlativo,$id_gasto_servicio])==false) {
					throw new Exception("1. Error al actualizar los datos de la orden.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_detalle_gastoserv WHERE id_gasto_servicio = ?");
				$stmt->execute([$id_gasto_servicio]);
				if ($stmt->rowCount()==0) {
					throw new Exception("2. Ocurrió un error al actualizar el detalle de la orden.");
				}

				foreach ($detalle_gastoserv as $key) {
					foreach ($key as $key1) {
						$sql = "INSERT INTO tb_detalle_gastoserv (`id_gasto_servicio`, `descripcion_gasto`, `monto_gastado`) VALUES ";
						$sql .= "(";
						$sql .= "?,?,?";
						$sql .= ")";
						$stmt = $conexion->prepare($sql);
						$stmt->execute([$id_gasto_servicio,$key1->descripcion_gasto,$key1->monto_gastado]);
						if ($stmt->rowCount()==0) {
							throw new Exception("3. Error al registrar la orden en la base de datos.");
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

		public function delete($id_gasto_servicio) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_gasto_servicio` WHERE id_gasto_servicio = ? AND estado = '0'");
				$stmt->execute([$id_gasto_servicio]);
				if ($stmt->rowCount() == 0) {
					throw new Exception("No se encontró la orden a anular, o ya fue cambiada de estado.");
				}

				$stmt = $conexion->prepare("UPDATE tb_gasto_servicio SET estado = '3' WHERE id_gasto_servicio = ?");
				$stmt->execute([$id_gasto_servicio]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al anular la orden de gastos.");
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

		public function eliminarOrden($id_gasto_servicio) {
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

	$OBJ_GASTO_SERVICIO = new ClassGastoServicio();

?>
