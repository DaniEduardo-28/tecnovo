<?php

class ClassMaquinaria extends Conexion {

    // Constructor de la clase
    public function __construct(){
    }

    public function getCount($estado, $id_trabajador, $valor) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $valor = "%$valor%";
            $parametros = null;
            $sql = "SELECT COUNT(*) as cantidad FROM `tb_maquinaria` m
                    WHERE (m.descripcion LIKE ? OR m.observaciones LIKE ?)";

            $parametros[] = $valor;
            $parametros[] = $valor;

            if ($estado != "all") {
                $sql .= " AND m.estado = ?";
                $parametros[] = $estado;
            }
            if ($id_trabajador != "") {
                $sql .= " AND m.id_operador = ?";
                $parametros[] = $id_trabajador;
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

    public function showActivos() {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {

            $parametros = null;
            $sql = "SELECT m.*
                    FROM tb_maquinaria m where m.estado = 1";

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
    
    public function show($estado, $id_trabajador, $valor) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $valor = "%$valor%";
        $parametros = [$valor, $valor];
        $sql = "SELECT m.*, 
                       CONCAT(p.nombres, ' ', p.apellidos) AS nombre_operador
                FROM tb_maquinaria m
                LEFT JOIN tb_trabajador t ON t.id_trabajador = m.id_trabajador
                LEFT JOIN tb_persona p ON t.id_persona = p.id_persona
                WHERE (m.descripcion LIKE ? OR m.observaciones LIKE ?)";

            if ($estado != "all") {
                $sql .= " AND m.estado = ?";
                $parametros[] = $estado;
            }
            if ($id_trabajador != "") {
                $sql .= " AND m.id_trabajador = ?";
                $parametros[] = $id_trabajador;
            }

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

	public function showOperators($estado_operador = "all") {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";
    
        try {
            $parametros = [];
            $sql = "SELECT t.id_trabajador, CONCAT(p.nombres, ' ', p.apellidos) AS nombre_operador
                    FROM tb_trabajador t
                    INNER JOIN tb_persona p ON t.id_persona = p.id_persona
                    WHERE t.flag_medico = 1 AND t.estado = 'activo'"; // Filtrar trabajadores activos
    
            if ($estado_operador === "activo") {
                $sql .= " AND t.estado = ?";
                $parametros[] = "activo";
            }
    
            $stmt = $conexion->prepare($sql);
            $stmt->execute($parametros);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Agrega esta línea para verificar el resultado en el log de PHP
            error_log(print_r($result, true));
    
            $VD1['data'] = $result ? $result : [];
            $VD1['error'] = "NO";
            $VD1['message'] = "Success";
            $VD = $VD1;
    
        } catch (PDOException $e) {
            $VD1['error'] = "SI";
            $VD1['message'] = $e->getMessage();
            $VD1['data'] = [];
        } catch (Exception $exception) {
            $VD1['error'] = "SI";
            $VD1['message'] = $exception->getMessage();
            $VD1['data'] = [];
        } finally {
            $conexionClass->Close();
        }
    
        return $VD;
    }
    
    public function getDataEditMaquinaria($id_maquinaria) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $sql = "SELECT m.*, CONCAT(p.nombres, ' ', p.apellidos) AS nombre_operador
                    FROM tb_maquinaria m
                    LEFT JOIN tb_trabajador t ON t.id_trabajador = m.id_trabajador
                    LEFT JOIN tb_persona p ON t.id_persona = p.id_persona
                    WHERE m.id_maquinaria = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$id_maquinaria]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) == 0) {
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

    public function insert($id_maquinaria, $descripcion, $observaciones, $estado, $id_trabajador) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $conexion->beginTransaction();

            $sql = "INSERT INTO tb_maquinaria (`id_maquinaria`, `descripcion`, `observaciones`, `estado`, `id_trabajador`) VALUES
                    ((SELECT CASE COUNT(m.id_maquinaria) WHEN 0 THEN 1 ELSE (MAX(m.id_maquinaria) + 1) END FROM `tb_maquinaria` m), ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$descripcion, $observaciones, $estado, $id_trabajador]);

            if ($stmt->rowCount() == 0) {
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

    public function update($id_maquinaria, $descripcion, $observaciones, $estado, $id_trabajador) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";
	
		try {
			$conexion->beginTransaction();

            $stmt = $conexion->prepare("SELECT COUNT(*) FROM `tb_maquinaria` WHERE id_maquinaria = ?");
            $stmt->execute([$id_maquinaria]);
            $exists = $stmt->fetchColumn();
	
			if ($exists == 0) {
                throw new Exception("No se encontró el registro de maquinaria a editar.");
            }

            $sql = "UPDATE tb_maquinaria SET descripcion = ?, observaciones = ?, estado = ?, id_trabajador = ? WHERE id_maquinaria = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$descripcion, $observaciones, $estado, $id_trabajador, $id_maquinaria]);

            if ($stmt->rowCount() == 0) {
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
	

    public function delete($id_maquinaria) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $conexion->beginTransaction();

            $stmt = $conexion->prepare("DELETE FROM tb_maquinaria WHERE id_maquinaria = ?");
            $stmt->execute([$id_maquinaria]);

            if ($stmt->rowCount() == 0) {
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

    public function show_all() {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $sql = "SELECT m.*, CONCAT(p.nombres, ' ', p.apellidos) AS nombre_operador
                    FROM `tb_maquinaria` m
                    INNER JOIN tb_trabajador t ON t.id_trabajador = m.id_trabajador
                    INNER JOIN tb_persona p ON t.id_persona = p.id_persona
                    WHERE t.flag_medico = 1";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) == 0) {
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

    public function getMaquinariasActivas() {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";
    
        try {
            // Consulta para obtener las maquinarias activas
            $sql = "SELECT id_maquinaria, descripcion 
                    FROM tb_maquinaria 
                    WHERE estado = 'activo'";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if (count($result) == 0) {
                throw new Exception("No se encontraron maquinarias activas.");
            }
    
            $VD1['error'] = "NO";
            $VD1['message'] = "Success";
            $VD1['data'] = $result;
            $VD = $VD1;
    
        } catch(PDOException $e) {
            $VD1['error'] = "SI";
            $VD1['message'] = $e->getMessage();
            $VD1['data'] = [];
            $VD = $VD1;
        } catch (Exception $exception) {
            $VD1['error'] = "SI";
            $VD1['message'] = $exception->getMessage();
            $VD1['data'] = [];
            $VD = $VD1;
        } finally {
            $conexionClass->Close();
        }
    
        return $VD;
    }
    

    

}

$OBJ_MAQUINARIA = new ClassMaquinaria();

?>
