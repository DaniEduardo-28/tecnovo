<?php

	class ClassTipoCambio extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function show($fecha_1,$fecha_2) {

			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";

			try {

				$sql = "SELECT T.*,M.name_moneda FROM `tb_tipo_cambio` T
								INNER JOIN tb_moneda M ON M.id_moneda = T.id_moneda
								WHERE CAST(T.fecha AS DATE) between ? AND ?
								ORDER BY T.fecha DESC ";
				$stmt = $conexion->prepare($sql);
				$stmt->execute([$fecha_1,$fecha_2]);
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

		public function insert($id_moneda,$tipo_cambio,$name_user) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();

				$stmt = $conexion->prepare("INSERT INTO tb_tipo_cambio (id_moneda, tipo_cambio, name_user) VALUES (?,?,?)");
				$stmt->execute([$id_moneda,$tipo_cambio,$name_user]);
				if ($stmt->rowCount()==0) {
					throw new Exception("Error al registrar el tipo de cambio.");
				}

				$stmt = $conexion->prepare("UPDATE tb_moneda SET tipo_cambio = ? WHERE id_moneda = ?");
				if ($stmt->execute([$tipo_cambio,$id_moneda])==false) {
					throw new Exception("Error al registrar el tipo de cambio.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Tipo Cambio", "Insertar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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

	$OBJ_TIPO_CAMBIO = new ClassTipoCambio();

?>
