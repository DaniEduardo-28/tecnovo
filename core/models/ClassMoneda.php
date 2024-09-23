<?php

	class ClassMoneda extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$parametros = null;
				$sql = "SELECT * FROM `tb_moneda` WHERE 1=1 ";
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

		public function getMonedaForId($id_moneda) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$sql = "SELECT * FROM `tb_moneda` WHERE id_moneda = ? ";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_moneda]);
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

		public function insert($id_moneda,$estado,$flag_principal,$name_moneda,$cod_sunat,$signo,$abreviatura) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();

				if ($flag_principal=="1") {
					$stmt = $conexion->prepare("SELECT * FROM `tb_moneda` WHERE flag_principal = '1'");
					$stmt->execute([]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)>0) {
						throw new Exception("Ya existe una moneda por defecto, si desea cambiar de moneda por defecto desactive primero la actual.");
					}
				}

				$stmt = $conexion->prepare("INSERT INTO tb_moneda (id_moneda, estado, flag_principal, name_moneda, cod_sunat, signo, abreviatura) VALUES ((SELECT CASE COUNT(c.id_moneda) WHEN 0 THEN 1 ELSE (MAX(c.id_moneda) + 1) end FROM `tb_moneda` c),?,?,?,?,?,?)");
				$stmt->execute([$estado,$flag_principal,$name_moneda,$cod_sunat,$signo,$abreviatura]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar la nueva moneda.");
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

		public function update($id_moneda,$estado,$flag_principal,$name_moneda,$cod_sunat,$signo,$abreviatura) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();

				if ($flag_principal=="1") {
					$stmt = $conexion->prepare("SELECT * FROM `tb_moneda` WHERE flag_principal = '1' AND id_moneda <> ?");
					$stmt->execute([$id_moneda]);
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($result)>0) {
						throw new Exception("Ya existe una moneda por defecto, si desea cambiar de moneda por defecto desactive primero la actual.");
					}
				}

				$stmt = $conexion->prepare("UPDATE tb_moneda SET estado = ?, flag_principal = ?, name_moneda = ?, cod_sunat = ?, signo = ?, abreviatura = ? WHERE id_moneda = ?");
				if ($stmt->execute([$estado,$flag_principal,$name_moneda,$cod_sunat,$signo,$abreviatura,$id_moneda])==false) {
					throw new Exception("Error al actualizar los datos.");
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

		public function delete($id_moneda) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_servicio` WHERE id_moneda = ?");
				$stmt->execute([$id_moneda]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("Tienes servicios registrados con esta moneda.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_medicamento` WHERE id_moneda = ?");
				$stmt->execute([$id_moneda]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("Tienes medicamentos registrados con esta moneda.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_accesorio` WHERE id_moneda = ?");
				$stmt->execute([$id_moneda]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($result)>0) {
					throw new Exception("Tienes accesorios registrados con esta moneda.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_tipo_cambio  WHERE id_moneda = ?");
				if ($stmt->execute([$id_moneda])==false) {
					throw new Exception("Error al eliminar el registro.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_moneda  WHERE id_moneda = ?");
				$stmt->execute([$id_moneda]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al eliminar el registro.");
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

		public function getTipoCambio($id_moneda) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = 1.00;

			try {

				$sql = "SELECT * FROM `tb_tipo_cambio` WHERE id_moneda = ? ORDER by fecha DESC LIMIT 1";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_moneda]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron datos.");
				}

				$VD = $result[0]['tipo_cambio'];

			} catch(PDOException $e) {

				$VD = 1.00;

			} catch (Exception $exception) {

				$VD = 1.00;

    	} finally {
				$conexionClass->Close();
			}

			return $VD;
		}

		public function getMontoReporte($id_moneda,$mes,$anio) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$sql = "SELECT (SELECT SUM(total) FROM tb_venta v WHERE v.id_moneda = m.id_moneda AND
								v.estado = '2' AND MONTH(v.fecha) = ? AND YEAR(v.fecha) = ?) as total
								FROM tb_moneda m WHERE m.estado = '1' and m.id_moneda = ?";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$mes,$anio,$id_moneda]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				return $result == null || $result == "" ? 0 : $result[0]['total'];

			} catch(PDOException $e) {

				return 0;

			} catch (Exception $exception) {

				return 0;

    	} finally {
				$conexionClass->Close();
			}

			return $VD;
		}

		public function getMontoReporteCompras($id_moneda,$mes,$anio) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$sql = "SELECT (SELECT SUM(v.total) FROM vw_orden_compra v WHERE
								v.estado_int <> '3' AND MONTH(v.fecha_orden) = ? AND
								YEAR(v.fecha_orden) = ? and v.id_moneda = ? AND v.id_fundo = ? ) as total";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$mes,$anio,$id_moneda,$_SESSION['id_fundo']]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				return $result == null || $result == "" ? 0 : $result[0]['total'];

			} catch(PDOException $e) {

				return 0;

			} catch (Exception $exception) {

				return 0;

    	} finally {
				$conexionClass->Close();
			}

			return $VD;
		}

	}

	$OBJ_MONEDA = new ClassMoneda();

?>
