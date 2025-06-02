<?php
class ClassAuditoria extends Conexion {
    
    public function __construct() {
    }

    public function showReporte($estado, $fecha_inicio, $fecha_fin)
{
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {
        $fecha_fin = date("Y-m-d", strtotime($fecha_fin . "+ 0 days"));
		$fecha_inicio = date("Y-m-d", strtotime($fecha_inicio . "+ 0 days"));


        $parametros = [];
        
        // Consulta base para tb_auditoria
        $sql = "SELECT
                    a.id_auditoria,
                    CONCAT(p.nombres, ' ', p.apellidos) AS nombres,
                    gu.name_grupo,
                    a.nombre_tabla,
                    a.tipo_transaccion,
                    a.fecha
                FROM
                    tb_auditoria a
                    INNER JOIN tb_trabajador u ON a.id_usuario = u.id_trabajador
                    INNER JOIN tb_persona p ON u.id_persona = p.id_persona 
                    INNER JOIN tb_grupo_usuario gu ON gu.id_grupo = u.id_grupo
                WHERE
                    1 = 1";
        

            $sql .= " AND DATE(a.fecha) BETWEEN ? AND ?";
            $parametros[] = $fecha_inicio;
            $parametros[] = $fecha_fin;
        

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


public function getNombreTablas()
{
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {
        // Consulta para obtener tablas únicas
        $sql = "SELECT DISTINCT nombre_tabla FROM tb_auditoria ORDER BY nombre_tabla";
        
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) == 0) {
            throw new Exception("No se encontraron tablas.");
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

    
    
}


$OBJ_AUDITORIA = new ClassAuditoria();

?>
