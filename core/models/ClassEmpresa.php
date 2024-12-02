<?php

	class ClassEmpresa extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function getEmpresa() {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$stmt = $conexion->prepare("SELECT e.*,di.name_documento as name_documento_empresa,di1.name_documento as name_documento_representante FROM `tb_empresa` e INNER JOIN tb_documento_identidad di ON di.id_documento = e.id_documento INNER JOIN tb_documento_identidad di1 ON di1.id_documento = e.id_documento_representante limit 1");
				$stmt->execute([]);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (count($result)==0) {
					throw new Exception("No se encontraron datos de la empresa.");
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

		public function update($id_empresa,$id_documento,$num_documento,$razon_social,$nombre_comercial,$direccion,$fono01,$fono02,$correo01,$correo02,$web,$id_documento_representante,$num_documento_representante,$nombres_representante,$apellidos_representante,$flag_imagen,$src_imagen) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$sql = "UPDATE tb_empresa SET ";
				$sql .=" id_documento = ?, ";
				$sql .=" num_documento = ?, ";
				$sql .=" razon_social = ?, ";
				$sql .=" nombre_comercial = ?, ";
				$sql .=" direccion = ?, ";
				$sql .=" fono01 = ?, ";
				$sql .=" fono02 = ?, ";
				$sql .=" correo01 = ?, ";
				$sql .=" correo02 = ?, ";
				$sql .=" web = ?, ";
				$sql .=" id_documento_representante = ?, ";
				$sql .=" num_documento_representante = ?, ";
				$sql .=" nombres_representante = ?, ";
				$sql .=" apellidos_representante = ? ";
				$sql .=" WHERE id_empresa = ? ";
				$stmt = $conexion->prepare($sql);

				if ($stmt->execute([$id_documento,$num_documento,$razon_social,$nombre_comercial,$direccion,$fono01,$fono02,$correo01,$correo02,$web,$id_documento_representante,$num_documento_representante,$nombres_representante,$apellidos_representante,$id_empresa])==false) {
					throw new Exception("Ocurrió un error al actualizar los datos de la empresa.");
				}

				if ($flag_imagen=="1") {

					$sql = "UPDATE tb_empresa SET ";
					$sql .=" src_logo = ? ";
					$sql .=" WHERE id_empresa = ? ";
					$stmt = $conexion->prepare($sql);

					if ($stmt->execute([$src_imagen,$id_empresa])==false) {
						throw new Exception("Ocurrió un error al actualizar los datos de la empresa.");
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

	$OBJ_EMPRESA = new ClassEmpresa();

?>
