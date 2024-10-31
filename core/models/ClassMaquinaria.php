<?php

class ClassMaquinaria extends Conexion {

    // Constructor de la clase
    public function __construct(){
    }

    public function getCount($estado, $id_operador, $valor) {
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
            if ($id_operador != "") {
                $sql .= " AND m.id_operador = ?";
                $parametros[] = $id_operador;
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

    public function show($estado, $id_operador, $valor, $offset, $limit) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $valor = "%$valor%";
            $parametros = null;
            $sql = "SELECT m.*, o.nombre_operador
                    FROM tb_maquinaria m
                    INNER JOIN vw_operadores o ON o.id_operador = m.id_operador
                    WHERE (m.descripcion LIKE ? OR m.observaciones LIKE ?)";
            $parametros[] = $valor;
            $parametros[] = $valor;

            if ($estado != "all") {
                $sql .= " AND m.estado = ?";
                $parametros[] = $estado;
            }
            if ($id_operador != "") {
                $sql .= " AND m.id_operador = ?";
                $parametros[] = $id_operador;
            }

            $sql .= " LIMIT $offset, $limit ";

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
            $sql = "SELECT DISTINCT o.id_operador, o.nombre_operador
                    FROM vw_operadores o
                    INNER JOIN tb_maquinaria m ON o.id_operador = m.id_operador";

            if ($estado_operador != "all") {
                $sql .= " WHERE o.estado_operador = ?";
                $parametros[] = $estado_operador;
            }

            $stmt = $conexion->prepare($sql);
            $stmt->execute($parametros);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) == 0) {
                throw new Exception("No se encontraron operadores.");
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

    public function getDataEditMaquinaria($id_maquinaria) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $sql = "SELECT m.*, o.nombre_operador
                    FROM tb_maquinaria m
                    INNER JOIN vw_operadores o ON o.id_operador = m.id_operador
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

    public function insert($id_maquinaria, $descripcion, $observaciones, $estado, $id_operador) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $conexion->beginTransaction();

            $sql = "INSERT INTO tb_maquinaria (`id_maquinaria`, `descripcion`, `observaciones`, `estado`, `id_operador`) VALUES
                    ((SELECT CASE COUNT(m.id_maquinaria) WHEN 0 THEN 1 ELSE (MAX(m.id_maquinaria) + 1) END FROM `tb_maquinaria` m), ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$descripcion, $observaciones, $estado, $id_operador]);

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

    public function update($id_maquinaria, $descripcion, $observaciones, $estado, $id_operador) {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $conexion->beginTransaction();

            $stmt = $conexion->prepare("SELECT * FROM `tb_maquinaria` WHERE id_maquinaria = ?");
            $stmt->execute([$id_maquinaria]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) == 0) {
                throw new Exception("No se encontró el registro de maquinaria a editar.");
            }

            $sql = "UPDATE tb_maquinaria SET descripcion = ?, observaciones = ?, estado = ?, id_operador = ? WHERE id_maquinaria = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$descripcion, $observaciones, $estado, $id_operador, $id_maquinaria]);

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
            $sql = "SELECT m.*, o.nombre_operador
                    FROM `tb_maquinaria` m
                    INNER JOIN vw_operadores o ON o.id_operador = m.id_operador";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([]);
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

}

$OBJ_MAQUINARIA = new ClassMaquinaria();

?>
