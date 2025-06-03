<?php

	class ClassSuscriptor extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function add($correo_suscribirse) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD = "";
			try {

				$conexion->beginTransaction();
				$sql = "INSERT INTO tb_galeria (name_tabla,descripcion) VALUES (?,?)";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute(["4",$correo_suscribirse])==false) {
					throw new Exception("Ocurrió un error al suscribirse.");
				}

				$sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Suscriptor", "Insertar"]);
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

	$OBJ_SUSCRIPTOR = new ClassSuscriptor();

?>
