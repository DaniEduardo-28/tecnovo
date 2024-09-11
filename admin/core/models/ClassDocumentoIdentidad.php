<?php

	class ClassDocumentoIdentidad extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$parametros = null;
				$sql = "SELECT d.id_documento, d.name_documento, d.codigo_sunat, d.size, case d.flag_exacto when '0' then 'NO' ELSE 'SI' END as 'flag_exacto', CASE d.flag_numerico WHEN '1' THEN 'SOLO NUMEROS' ELSE 'NUMEROS Y LETRAS' END AS 'flag_numerico', d.estado FROM `tb_documento_identidad` d WHERE 1 = 1 ";
				if ($estado!="all") {
					$sql .= " AND d.estado = ?";
					$parametros[] = $estado;
				}
				$stmt = $conexion->prepare($sql);
				$stmt->execute($parametros);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron documentos de identidad registrados.");
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

		public function getDocumentoForId($id_documento) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$stmt = $conexion->prepare("SELECT * FROM `tb_documento_identidad` WHERE id_documento = ?");
				$stmt->execute([$id_documento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontró el documento de identidad solicitado.");
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

		public function insert($name_documento,$codigo_sunat,$size,$flag_exacto,$flag_numerico,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_documento_identidad (id_documento, name_documento, size, estado, flag_numerico, flag_exacto, codigo_sunat) VALUES ((SELECT CASE COUNT(c.id_documento) WHEN 0 THEN 1 ELSE (MAX(c.id_documento) + 1) end FROM `tb_documento_identidad` c),?,?,?,?,?,?)");
				$stmt->execute([$name_documento,$size,$estado,$flag_numerico,$flag_exacto,$codigo_sunat]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar un nuevo documento.");
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

		public function update($id_documento,$name_documento,$codigo_sunat,$size,$flag_exacto,$flag_numerico,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {
				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_documento_identidad SET name_documento = ?, estado = ?, size = ?, codigo_sunat = ?, flag_exacto = ?, flag_numerico = ? WHERE id_documento = ?");
				if ($stmt->execute([$name_documento,$estado,$size,$codigo_sunat,$flag_exacto,$flag_numerico,$id_documento])==false) {
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

		public function delete($id_documento) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {
				$conexion->beginTransaction();

				$stmt = $conexion->prepare("SELECT * FROM `tb_persona` WHERE id_documento = ?");
				$stmt->execute([$id_documento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {
					throw new Exception("El tipo de documento seleccionado se encuentra siendo utilizado por la tabla Personas.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_empresa` WHERE id_documento = ?");
				$stmt->execute([$id_documento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {
					throw new Exception("El tipo de documento seleccionado se encuentra siendo utilizado por la tabla empresa.");
				}

				$stmt = $conexion->prepare("SELECT * FROM `tb_empresa` WHERE id_documento_representante = ?");
				$stmt->execute([$id_documento]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)>0) {
					throw new Exception("El tipo de documento seleccionado se encuentra siendo utilizado por el documento del representante.");
				}

				$stmt = $conexion->prepare("DELETE FROM tb_documento_identidad  WHERE id_documento = ?");
				$stmt->execute([$id_documento]);
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

	$OBJ_DOCUMENTO_IDENTIDAD = new ClassDocumentoIdentidad();

?>
