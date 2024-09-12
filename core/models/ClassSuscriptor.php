<?php

	class ClassSuscriptor extends Conexion {

		//constructor de la clase
		public function __construct(){

		}

		public function add($correo_suscribirse) {
			$conexionClass = new Conexion();
			$conexion = $conexionClass->Open();
			$VD;
			try {

				$conexion->beginTransaction();
				$sql = "INSERT INTO tb_galeria (name_tabla,descripcion) VALUES (?,?)";
				$stmt = $conexion->prepare($sql);
				if ($stmt->execute(["4",$correo_suscribirse])==false) {
					throw new Exception("Ocurrió un error al suscribirse.");
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
