<?php

	class ClassMetodoPago extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($estado) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$parametros = null;
				$sql = "SELECT * FROM `tb_forma_pago` t WHERE 1 = 1 ";
				if ($estado!="all") {
					$sql .= " AND t.estado = ?";
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

		public function insert($id_forma_pago,$name_forma_pago,$cod_sunat,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("INSERT INTO tb_forma_pago (id_forma_pago, name_forma_pago, cod_sunat, estado) VALUES ((SELECT CASE COUNT(t.id_forma_pago) WHEN 0 THEN 1 ELSE (MAX(t.id_forma_pago) + 1) end FROM `tb_forma_pago` t),?,?,?)");
				$stmt->execute([$name_forma_pago,$cod_sunat,$estado]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al insertar el registro.");
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

		public function update($id_forma_pago,$name_forma_pago,$cod_sunat,$estado) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();
				$stmt = $conexion->prepare("UPDATE tb_forma_pago SET name_forma_pago = ?, cod_sunat = ?, estado = ? WHERE id_forma_pago = ?");
				if ($stmt->execute([$name_forma_pago,$cod_sunat,$estado,$id_forma_pago])==false) {
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

		public function delete($id_forma_pago) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;

			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("DELETE FROM tb_forma_pago WHERE id_forma_pago = ?");
				$stmt->execute([$id_forma_pago]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Ocurrió un error al eliminar el registro.");
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

	$OBJ_METODO_PAGO = new ClassMetodoPago();

?>
