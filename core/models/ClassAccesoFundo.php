<?php

class ClassAccesoFundo extends Conexion {

	//constructor de la clase
	public function __construct(){

	}

	public function verificarPermiso($id_cliente,$id_fundo) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = false;

		try {

			$sql = "SELECT * FROM tb_cliente_fundo WHERE id_cliente = ? AND id_fundo = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_cliente,$id_fundo]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result)==0) {
				throw new Exception("No tienes permiso");
			}

			$VD = true;

		} catch(PDOException $e) {
			$VD = false;
		} catch (Exception $exception) {
			$VD = false;
		} finally {
			$conexionClass->Close();
		}

		return $VD;

	}

	public function getPermisosFundo($id_cliente) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$sql = "SELECT  * FROM tb_cliente_fundo WHERE id_cliente = ?";
			/* $sql= "SELECT f.id_fundo, f.nombre, cf.cantidad_hc 
			        FROM tb_fundo f
			        LEFT JOIN tb_cliente_fundo cf ON f.id_fundo = cf.id_fundo AND cf.id_cliente = ?
			        ORDER BY f.nombre"; */

			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_cliente]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("No tiene accesos a fundos.");
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

	public function getAccesoClienteFundo($id_fundo) {

		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;

		try {

			$sql = "SELECT T.id_cliente,T.nombres_cliente,T.apellidos_cliente
							FROM tb_cliente_fundo TS
							INNER JOIN vw_clientes T ON T.id_cliente = TS.id_cliente
							WHERE TS.id_fundo = ? AND T.estado = 'activo'
							ORDER BY T.apellidos_cliente ASC";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_fundo]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (count($result)==0) {
				throw new Exception("No tiene accesos a fundos.");
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

	public function updateAccesoFundo($id_cliente,$datos) {
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD;
		try {

			$conexion->beginTransaction();

			$stmt = $conexion->prepare("DELETE FROM tb_cliente_fundo WHERE id_cliente = ?");
			$stmt->execute([$id_cliente]);

			if ($datos != null) {
				foreach ($datos as $key) {
		      foreach ($key as $key1) {
						$stmt = $conexion->prepare("INSERT INTO tb_cliente_fundo (id_fundo, id_cliente) VALUES (?,?)");
						if ($stmt->execute([$key1->id_fundo,$id_cliente])==false) {
							throw new Exception("Error al actualizar los permisos.");
						}
		      }
		    }
			}

			/* if ($datos != null) {
				foreach ($datos as $key) {
					$stmt = $conexion->prepare("INSERT INTO tb_cliente_fundo (id_fundo, id_cliente, cantidad_hc) VALUES (?, ?, ?)");
					if ($stmt->execute([$key->id_fundo, $id_cliente, $key->cantidad_hc]) == false) {
						throw new Exception("Error al actualizar los permisos.");
					}
				}
			} */

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

	/* $datos = [
    (object) ['id_fundo' => 1, 'cantidad_hc' => 50],
    (object) ['id_fundo' => 2, 'cantidad_hc' => 100]
	]; */

	$OBJ_ACCESO_FUNDO = new ClassAccesoFundo();

?>