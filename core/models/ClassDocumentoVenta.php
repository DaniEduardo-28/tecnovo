<?php

	class ClassDocumentoVenta extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($id_sucursal,$estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT * FROM `tb_documento_venta` WHERE id_sucursal = ? ";
				$parametros[] = $id_sucursal;
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

		public function getDocumentoVentaForId($id_documento_venta) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT * FROM `tb_documento_venta` WHERE id_documento_venta = ? ";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$id_documento_venta]);
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

		public function insert($id_documento_venta,$id_sucursal,$estado,$flag_doc_interno,$nombre,$nombre_corto,$cod_sunat,$serie,$correlativo) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_documento_venta (id_documento_venta, id_sucursal, estado, flag_doc_interno, nombre, nombre_corto, cod_sunat, serie, correlativo) VALUES ((SELECT CASE COUNT(c.id_documento_venta) WHEN 0 THEN 1 ELSE (MAX(c.id_documento_venta) + 1) end FROM `tb_documento_venta` c),?,?,?,?,?,?,?,?)");
				$stmt->execute([$id_sucursal,$estado,$flag_doc_interno,$nombre,$nombre_corto,$cod_sunat,$serie,$correlativo]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar la nueva sucursal.");
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

		public function update($id_documento_venta,$id_sucursal,$estado,$flag_doc_interno,$nombre,$nombre_corto,$cod_sunat,$serie,$correlativo) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {
				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_documento_venta SET estado = ?, flag_doc_interno = ?, nombre = ?, nombre_corto = ?, cod_sunat = ?, serie = ?, correlativo = ? WHERE id_documento_venta = ? AND id_sucursal = ?");
				if ($stmt->execute([$estado,$flag_doc_interno,$nombre,$nombre_corto,$cod_sunat,$serie,$correlativo,$id_documento_venta,$id_sucursal])==false) {
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

		public function delete($id_documento_venta) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("DELETE FROM tb_documento_venta  WHERE id_documento_venta = ?");
				$stmt->execute([$id_documento_venta]);
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

	}

	$OBJ_DOCUMENTO_VENTA = new ClassDocumentoVenta();

?>
