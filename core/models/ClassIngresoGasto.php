<?php

	class ClassIngresoGasto extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getCount($valor,$fecha_inicio,$fecha_fin,$tipo_busqueda) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT COUNT(*) as cantidad FROM `tb_ingreso_gasto` i
								INNER JOIN tb_orden_gasto o ON o.id_orden_gasto = i.id_orden_gasto
								INNER JOIN vw_proveedores p ON p.id_proveedor = o.id_proveedor
								WHERE o.fecha_gasto >= ? AND o.fecha_gasto < ? ";

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
			$VD="";

			try {

				$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT i.*,p.nombre_proveedor,t.nombres_trabajador,
								(SELECT COUNT(*) FROM tb_detalle_ingreso di WHERE di.id_ingreso_gasto = i.id_ingreso_gasto) AS num_registros,
								CONCAT(td.nombre_corto,' ',i.num_documento) as documento
								FROM `tb_ingreso_gasto` i
								INNER JOIN tb_orden_gasto o ON o.id_orden_gasto = i.id_orden_gasto
								INNER JOIN tb_documento_venta td ON td.id_documento_venta = i.id_tipo_docu
								INNER JOIN vw_proveedores p ON p.id_proveedor = o.id_proveedor
								INNER JOIN vw_trabajadores t ON t.id_trabajador = o.id_trabajador
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

		public function showPrint($valor,$fecha_inicio,$fecha_fin,$tipo_busqueda) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD=" ";

			try {

				$fecha_fin = date("Y-m-d",strtotime($fecha_fin."+ 1 days"));

				$valor = "%$valor%";
				$parametros = null;
				$sql = "SELECT i.*,p.nombre_proveedor,t.nombre_trabajador,
								(SELECT COUNT(*) FROM tb_detalle_ingreso di WHERE di.id_ingreso_gasto = i.id_ingreso_gasto) AS num_registros,
								i.num_documento as documento
								FROM `tb_ingreso_gasto` i
								INNER JOIN tb_orden_gasto o ON o.id_orden_gasto = i.id_orden_gasto
								INNER JOIN tb_tipo_documento td ON td.id_tipo_docu = i.id_tipo_docu
								INNER JOIN vw_proveedores p ON p.id_proveedor = o.id_proveedor
								INNER JOIN vw_trabajador t ON t.id_trabajador = o.id_trabajador
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

				$sql = "SELECT O.id_orden_gasto,O.id_proveedor,PR.nombre_proveedor,PR.src_imagen_proveedor,
											 O.fecha_gasto,O.observaciones,
											 DC.cod_gasto,PRO.name_gasto,DC.precio_unitario,
											 DC.cantidad_solicitada,
											 (DC.precio_unitario * DC.cantidad_solicitada) as total,
											 DC.cantidad_solicitada
								FROM tb_orden_gasto O
								INNER JOIN vw_proveedores PR ON PR.id_proveedor = O.id_proveedor
								INNER JOIN tb_detalle_gasto DC ON DC.id_orden_gasto = O.id_orden_gasto
								INNER JOIN tb_gasto PRO ON PRO.id_gasto = DC.cod_producto
								WHERE O.id_orden_gasto = ?";
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

		public function getDataVerIngreso($id_ingreso_gasto) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD=" ";

			try {

				$sql = "SELECT i.id_orden_gasto,i.id_ingreso_gasto,O.nombre_proveedor,O.src_imagen_proveedor,
											 i.fecha,i.observaciones,i.id_tipo_docu,
											 DI.cod_gasto,O.name_gasto,DI.cantidad,
											 DI.observaciones as observaciones_detalle,
											 O.name_tabla,
											 i.num_documento
								FROM tb_ingreso_gasto i
								INNER JOIN tb_detalle_ingreso DI ON DI.id_ingreso_gasto = i.id_ingreso_gasto
								INNER JOIN vw_orden_gasto O ON O.id_orden_gasto = i.id_orden_gasto
								AND O.cod_gasto = DI.cod_gasto AND O.name_tabla = DI.name_tabla
								WHERE i.id_ingreso_gasto = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_ingreso_gasto]);
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

		public function insert($id_trabajador,$id_orden_gasto,$id_tipo_docu,$num_documento,$observaciones,$detalle_gasto) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD=" ";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ? ");
				$stmt->execute([$id_orden_gasto]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontró la orden a ingresar.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_orden_gasto` WHERE id_orden_gasto = ? ");
				$stmt->execute([$id_orden_gasto]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {
					$sql = "UPDATE tb_orden_gasto WHERE id_orden_gasto = ?";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_orden_gasto]);
					if ($stmt->rowCount()==0) {
						throw new Exception("Ocurrió un error al actualizar el estado de la orden de gasto.");
					}
				}

				$sql = "INSERT INTO tb_ingreso_gasto (`id_ingreso_gasto`, `id_orden_gasto`, `id_trabajador`, `id_tipo_docu`, `num_documento`, `fecha`, `observaciones`, `estado`) VALUES ";
				$sql .= "(";
				$sql .= "(SELECT CASE COUNT(i.id_ingreso_gasto) WHEN 0 THEN 1 ELSE (MAX(i.id_ingreso_gasto) + 1) end FROM `tb_ingreso_gasto` i),";
				$sql .= "?,?,?,?,?,?,'1'";
				$sql .= ")";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_orden_gasto,$id_trabajador,$id_tipo_docu,$num_documento,$observaciones]);
				if ($stmt->rowCount()==0) {
					throw new Exception("1. Error al registrar el ingreso en la base de datos.");
				}

				$cantidad_ingresada = 0;

				foreach ($detalle_gasto as $key) {
					foreach ($key as $key1) {

						if ($key1->cantidad>0) {

							$stmt = $conexion->prepare("SELECT * FROM `tb_detalle_gasto` WHERE id_orden_gasto = ? AND name_tabla = ? AND cod_gasto = ? AND cantidad_solicitada = ? ");
							$stmt->execute([$id_orden_gasto,$key1->name_tabla,$key1->cod_gasto,$key1->cantidad]);
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

							if (count($result)==0) {
								throw new Exception("La cantidad ingresada de un producto supera la cantidad Solicitada");
							}

							$sql = "INSERT INTO tb_detalle_ingreso (`id_ingreso_gasto`, `name_tabla`, `cod_gasto`, `cantidad`, `observaciones`) VALUES ";
							$sql .= "(";
							$sql .= "(SELECT MAX(i.id_ingreso_gasto) FROM `tb_ingreso_gasto` i),";
							$sql .= "?,?,?,?";
							$sql .= ")";
							$stmt = $conexion->prepare($sql);
							$stmt->execute([$key1->name_tabla,$key1->cod_gasto,$key1->cantidad,$key1->observaciones]);
							if ($stmt->rowCount()==0) {
								throw new Exception("2. Error al registrar el ingreso en la base de datos.");
							}

							$sql = "UPDATE tb_detalle_gasto WHERE id_orden_gasto = ? AND cod_gasto = ? AND name_tabla = ? ";
							$stmt = $conexion->prepare($sql);
							if ($stmt->execute([$key1->cantidad,$id_orden_gasto,$key1->cod_gasto,$key1->name_tabla])==false) {
								throw new Exception("Error al actualizar la cantidad ingresada.");
							}

							if ($key1->name_tabla == "gasto") {
								$sql = "UPDATE tb_gasto WHERE id_gasto = ?";
								$stmt = $conexion->prepare($sql);
								if ($stmt->execute([$key1->cantidad,$key1->cod_gasto])==false) {
									throw new Exception("Ocurrió un error al actualizar el stock del gasto.");
								}
							}

							$cantidad_ingresada += $key1->cantidad;

						}

					}
				}

				if ($cantidad_ingresada==0) {
					throw new Exception("El ingreso de tus gastos es cero, no puedes registrar este ingreso.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_detalle_gasto` WHERE id_orden_gasto = ? ");
				$stmt->execute([$id_orden_gasto]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					$sql = "UPDATE tb_orden_gasto WHERE id_orden_gasto = ?";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$id_orden_gasto]);
					if ($stmt->rowCount()==0) {
						throw new Exception("Error al actualizar el estado de la orden de gasto.");
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

		public function delete($id_ingreso_gasto) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD="";

			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_ingreso_gasto` WHERE id_ingreso_gasto = ? ");
				$stmt->execute([$id_ingreso_gasto]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontró el ingreso a anular.");
				}

				$id_orden_gasto = $result[0]['id_orden_gasto'];

				$stmt = $conexion->prepare("UPDATE tb_ingreso_gasto WHERE id_ingreso_gasto = ?");
				$stmt->execute([$id_ingreso_gasto]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al actualizar el estado del ingreso.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_detalle_ingreso` WHERE id_ingreso_gasto = ?");
				$stmt->execute([$id_ingreso_gasto]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontró el detalle de gastos de este ingreso.");
				}

				foreach ($result as $key) {

					if ($key['name_tabla'] == "gasto") {
						$sql = "UPDATE tb_gasto WHERE id_gasto = ?";
						$stmt = $conexion->prepare($sql);
						if ($stmt->execute([$key['cantidad'],$key['cod_gasto']])==false) {
							throw new Exception("Ocurrió un error al actualizar el stock del gasto.");
						}
					} 

					$sql = "UPDATE tb_detalle_gasto  WHERE cod_gasto = ? AND id_orden_compra = ? AND name_tabla = ? ";
					$stmt = $conexion->prepare($sql);
					$stmt->execute([$key['cantidad'],$key['cod_gasto'],$id_orden_gasto,$key['name_tabla']]);
					if ($stmt->rowCount()==0) {
						throw new Exception("Ocurrió un error al anular el ingreso.");
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

	}

	$OBJ_INGRESO_GASTO = new ClassIngresoGasto();

?>
