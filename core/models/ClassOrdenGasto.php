<?php

class ClassOrdenGasto extends Conexion {

    // Constructor de la clase
    public function __construct() {}

    // Método para contar las órdenes de gasto con criterios específicos (para paginación)
    public function getCount($estado, $id_documento, $valor) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $valor = "%$valor%";
            $parametros = [];
            $sql = "SELECT COUNT(*) as cantidad FROM `tb_orden_gasto` og
                    INNER JOIN tb_documento_identidad d ON d.id_documento = og.id_documento
                    INNER JOIN vw_proveedores p ON p.id_proveedor = og.id_proveedor
                    WHERE (og.serie LIKE ? OR og.correlativo LIKE ?)";
            
            $parametros[] = $valor;
            $parametros[] = $valor;

            if ($estado != "all") {
                $sql .= " AND og.estado = ?";
                $parametros[] = $estado;
            }
            if ($id_documento != "") {
                $sql .= " AND og.id_documento = ?";
                $parametros[] = $id_documento;
            }

            $stmt = $conexion->prepare($sql);
            $stmt->execute($parametros);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) == 0 || $result[0]['cantidad'] == 0) {
                throw new Exception("No se encontraron datos.");
            }

            $VD1['error'] = "NO";
            $VD1['message'] = "Success";
            $VD1['data'] = $result;
            $VD = $VD1;

        } catch (PDOException $e) {
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

    // Método para listar órdenes de gasto con paginación
    public function show($estado, $id_documento, $valor, $offset, $limit) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $valor = "%$valor%";
            $parametros = [];
            $sql = "SELECT og.*, d.name_documento, p.nombre_proveedor
                    FROM `tb_orden_gasto` og
                    INNER JOIN tb_documento_identidad d ON d.id_documento = og.id_documento
                    INNER JOIN vw_proveedores p ON p.id_proveedor = og.id_proveedor
                    WHERE (og.serie LIKE ? OR og.correlativo LIKE ?)";
            
            $parametros[] = $valor;
            $parametros[] = $valor;

            if ($estado != "all") {
                $sql .= " AND og.estado = ?";
                $parametros[] = $estado;
            }
            if ($id_documento != "") {
                $sql .= " AND og.id_documento = ?";
                $parametros[] = $id_documento;
            }

            $sql .= " LIMIT $offset, $limit";
            $stmt = $conexion->prepare($sql);
            $stmt->execute($parametros);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) == 0) {
                throw new Exception("No se encontraron datos.");
            }

            $VD1['error'] = "NO";
            $VD1['message'] = "Success";
            $VD1['data'] = $result;
            $VD = $VD1;

        } catch (PDOException $e) {
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

	public function getDataEditOrdenGasto($id_orden_gasto) {
		$conexionClass = new Conexion();
		$conexion = $conexionClass->Open();
		$VD = "";
	
		try {
			$sql = "SELECT * FROM tb_orden_gasto WHERE id_orden_gasto = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$id_orden_gasto]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
			if (count($result) == 0) {
				throw new Exception("No se encontraron datos para la orden de gasto.");
			}
	
			$VD1['error'] = "NO";
			$VD1['message'] = "Success";
			$VD1['data'] = $result;
			$VD = $VD1;
	
		} catch (PDOException $e) {
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
	

    // Método para insertar una nueva orden de gasto
    public function insert($data) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $conexion->beginTransaction();
            $sql = "INSERT INTO tb_orden_gasto (id_orden, id_documento, id_documento_venta, id_moneda, id_proveedor, id_gasto, id_servicio, serie, correlativo, fecha_gasto) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute($data);

            if ($stmt->rowCount() == 0) {
                throw new Exception("Error al registrar la orden de gasto.");
            }

            $VD = "OK";
            $conexion->commit();

        } catch (PDOException $e) {
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

    // Método para eliminar una orden de gasto
    public function delete($id_orden_gasto) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $conexion->beginTransaction();
            $stmt = $conexion->prepare("DELETE FROM tb_orden_gasto WHERE id_orden_gasto = ?");
            $stmt->execute([$id_orden_gasto]);

            if ($stmt->rowCount() == 0) {
                throw new Exception("Ocurrió un error al eliminar la orden de gasto.");
            }

            $VD = "OK";
            $conexion->commit();

        } catch (PDOException $e) {
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

$OBJ_ORDEN_GASTO = new ClassOrdenGasto();

?>
