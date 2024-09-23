<?php

	class ClassOverall extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getOverall($id_min,$id_max) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$stmt = $conexion->prepare("SELECT * FROM `tb_parametros_generales` WHERE id_parametro >= ? AND id_parametro <= ?");
				$stmt->execute([$id_min,$id_max]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron datos en la consulta solicitada.");
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

		public function updateCabezera($flag_imagen_1,$flag_imagen_2,$flag_imagen_3,$src_imagen_1,$src_imagen_2,$src_imagen_3,$titulo_1,$titulo_2,$titulo_3,$descripcion_1,$descripcion_2,$descripcion_3,$boton_1,$boton_2,$boton_3,$enlace_1,$enlace_2,$enlace_3) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();

				if ($flag_imagen_1 == "1") {
					$sql = "UPDATE tb_parametros_generales SET ";
					$sql .=" valor_string = ? ";
					$sql .=" WHERE id_parametro = 1 ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$src_imagen_1])==false) {
						throw new Exception("Ocurrió un error al actualizar el banner 1.");
					}
				}

				if ($flag_imagen_2 == "1") {
					$sql = "UPDATE tb_parametros_generales SET ";
					$sql .=" valor_string = ? ";
					$sql .=" WHERE id_parametro = 2 ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$src_imagen_2])==false) {
						throw new Exception("Ocurrió un error al actualizar el banner 2.");
					}
				}

				if ($flag_imagen_3 == "1") {
					$sql = "UPDATE tb_parametros_generales SET ";
					$sql .=" valor_string = ? ";
					$sql .=" WHERE id_parametro = 3 ";
					$stmt = $conexion->prepare($sql);
					if ($stmt->execute([$src_imagen_3])==false) {
						throw new Exception("Ocurrió un error al actualizar el banner 3.");
					}
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 4 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$titulo_1])==false) {
					throw new Exception("Ocurrió un error al actualizar el título 1.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 5 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$titulo_2])==false) {
					throw new Exception("Ocurrió un error al actualizar el título 2.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 6 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$titulo_3])==false) {
					throw new Exception("Ocurrió un error al actualizar el título 3.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 7 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$descripcion_1])==false) {
					throw new Exception("Ocurrió un error al actualizar la descripción 1.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 8 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$descripcion_2])==false) {
					throw new Exception("Ocurrió un error al actualizar la descripción 2.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 9 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$descripcion_3])==false) {
					throw new Exception("Ocurrió un error al actualizar la descripción 3.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 10 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$boton_1])==false) {
					throw new Exception("Ocurrió un error al actualizar el texto del boton 1.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 11 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$boton_2])==false) {
					throw new Exception("Ocurrió un error al actualizar el texto del boton 2.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 12 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$boton_3])==false) {
					throw new Exception("Ocurrió un error al actualizar el texto del boton 3.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 13 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$enlace_1])==false) {
					throw new Exception("Ocurrió un error al actualizar el enlace 1.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 14 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$enlace_2])==false) {
					throw new Exception("Ocurrió un error al actualizar el enlace 2.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 15 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$enlace_3])==false) {
					throw new Exception("Ocurrió un error al actualizar el enlace 3.");
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

		public function updateRedesSociales($link_1,$link_2,$link_3,$link_4) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 19 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$link_1])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 20 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$link_2])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 21 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$link_3])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 22 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$link_4])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
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

		public function updateDatosContacto($horario_top_nav,$correo,$telefono,$direccion,$number_clientes,$number_proyectos,$number_premios,$number_horas,$horario_1,$horario_2,$horario_3,$horario_4,$horario_5,$horario_6,$horario_7,$descripcion_footer,$mapa) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 16 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$horario_top_nav])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 17 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$correo])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 18 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$telefono])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 24 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$direccion])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_int = ? ";
				$sql .=" WHERE id_parametro = 25 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$number_clientes])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_int = ? ";
				$sql .=" WHERE id_parametro = 26 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$number_proyectos])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_int = ? ";
				$sql .=" WHERE id_parametro = 27 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$number_premios])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_int = ? ";
				$sql .=" WHERE id_parametro = 28 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$number_horas])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 29 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$horario_1])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 30 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$horario_2])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 31 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$horario_3])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 32 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$horario_4])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 33 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$horario_5])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 34 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$horario_6])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 35 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$horario_7])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 36 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$descripcion_footer])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
				}

				$sql = "UPDATE tb_parametros_generales SET ";
				$sql .=" valor_string = ? ";
				$sql .=" WHERE id_parametro = 37 ";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute([$mapa])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos.");
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

		public function getTotalesReporte($id_fundo) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$stmt = $conexion->prepare("SELECT
																		(SELECT COUNT(*) FROM tb_trabajador t) as total_trabajadores,
																	  (SELECT COUNT(*) FROM tb_cliente c) as total_clientes,
																	  (SELECT COUNT(*) FROM tb_accesorio a WHERE a.id_fundo = ?) as total_accesorios,
																	  (SELECT COUNT(*) FROM tb_medicamento m WHERE m.id_fundo = ?) as total_medicamentos");
				$stmt->execute([$id_fundo,$id_fundo]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron datos en la consulta solicitada.");
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

		public function getProductosAgotados() {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$stmt = $conexion->prepare("SELECT * FROM vw_productos_agotados");
				$stmt->execute([]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron datos en la consulta solicitada.");
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

	$OBJ_OVERALL = new ClassOverall();

?>
