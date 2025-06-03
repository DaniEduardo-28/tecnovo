<?php

class ClassTipoGasto extends Conexion
{

    // Constructor de la clase
    public function __construct() {}

    public function getCount($estado, $id_tipo_servicio, $valor)
    {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $valor = "%$valor%";
            $parametros = [$valor]; 
            $sql = "SELECT COUNT(*) as cantidad FROM `tb_tipo_gasto` tg 
                WHERE tg.desc_gasto LIKE ?";

            if ($estado != "all") {
                $sql .= " AND tg.estado = ?";
                $parametros[] = $estado;
            }
            if (!empty($id_tipo_servicio)) {
                $sql .= " AND tg.id_tipo_servicio = ?";
                $parametros[] = $id_tipo_servicio;
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

    public function showActivos()
    {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {

            $parametros = null;
            $sql = "SELECT tg.*
                    FROM tb_tipo_gasto tg where tg.estado = 'activo'";

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

    public function show($estado, $id_tipo_servicio, $valor)
    {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $valor = "%$valor%";
            $parametros = [$valor];
            $sql = "SELECT tg.*, 
                       ts.name_tipo 
                FROM tb_tipo_gasto tg
                LEFT JOIN tb_tipo_servicio ts ON ts.id_tipo_servicio = tg.id_tipo_servicio
                WHERE (tg.desc_gasto LIKE ?)";

            if ($estado != "all") {
                $sql .= " AND tg.estado = ?";
                $parametros[] = $estado;
            }
            if ($id_tipo_servicio != "") {
                $sql .= " AND tg.id_tipo_servicio = ?";
                $parametros[] = $id_tipo_servicio;
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


    public function getDataEditTipoGasto($id_tipo_gasto)
    {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $sql = "SELECT tg.*,
                        ts.name_tipo 
                    FROM tb_tipo_gasto tg
                    LEFT JOIN tb_tipo_servicio ts ON ts.id_tipo_servicio = tg.id_tipo_servicio
                    WHERE tg.id_tipo_gasto = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$id_tipo_gasto]);
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

    public function insert($id_tipo_gasto, $desc_gasto, $estado, $id_tipo_servicio)
    {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $conexion->beginTransaction();

            $sql = "INSERT INTO tb_tipo_gasto (`id_tipo_gasto`, `desc_gasto`, `estado`, `id_tipo_servicio`) VALUES
                    ((SELECT CASE COUNT(tg.id_tipo_gasto) WHEN 0 THEN 1 ELSE (MAX(tg.id_tipo_gasto) + 1) END FROM `tb_tipo_gasto` tg), ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$desc_gasto, $estado, $id_tipo_servicio]);

            if ($stmt->rowCount() == 0) {
                throw new Exception("Ocurrió un error al insertar el registro.");
            }

            $sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Tipo Gasto", "Insertar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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

    public function update($id_tipo_gasto, $desc_gasto, $estado, $id_tipo_servicio)
    {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $conexion->beginTransaction();

            $stmt = $conexion->prepare("SELECT COUNT(*) FROM `tb_tipo_gasto` WHERE id_tipo_gasto = ?");
            $stmt->execute([$id_tipo_gasto]);
            $exists = $stmt->fetchColumn();

            if ($exists == 0) {
                throw new Exception("No se encontró el registro a editar.");
            }

            $sql = "UPDATE tb_tipo_gasto SET desc_gasto = ?, estado = ?, id_tipo_servicio = ?
             WHERE id_tipo_gasto = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$desc_gasto, $estado, $id_tipo_servicio, $id_tipo_gasto]);

            if ($stmt->rowCount() == 0) {
                throw new Exception("Error al actualizar los datos.");
            }

            $sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Tipo Gasto", "Actualizar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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


    public function delete($id_tipo_gasto)
    {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $conexion->beginTransaction();

            $stmt = $conexion->prepare("DELETE FROM tb_tipo_gasto WHERE id_tipo_gasto = ?");
            $stmt->execute([$id_tipo_gasto]);

            if ($stmt->rowCount() == 0) {
                throw new Exception("Ocurrió un error al eliminar el registro.");
            }

            $sql = "INSERT INTO tb_auditoria (`id_trabajador`, `nombre_tabla`, `tipo_transaccion`, `fecha`) VALUES ";
			$sql .= "(";
			$sql .= "?,?,?,now()";
			$sql .= ")";
			$stmt = $conexion->prepare($sql);
			$stmt->execute([$_SESSION['id_trabajador'], "Tipo Gasto", "Eliminar"]);
			if ($stmt->rowCount() == 0) {
				throw new Exception("Error al realizar el registro en la base de datos.");
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

    public function show_all()
    {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        $VD = "";

        try {
            $sql = "SELECT tg.*,
                        ts.name_tipo
                    FROM `tb_tipo_gasto` tg
                    LEFT JOIN tb_tipo_servicio ts ON ts.id_tipo_servicio = tg.id_tipo_servicio";
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

    public function getTipoGastoPorUnidad($id_tipo_servicio)
    {
        $conexionClass = new Conexion();
        $conexion = $conexionClass->Open();
        try {
            $sql = "SELECT id_tipo_gasto, desc_gasto 
                    FROM tb_tipo_gasto 
                    WHERE id_tipo_servicio = :id_tipo_servicio AND estado = 'activo'";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id_tipo_servicio', $id_tipo_servicio, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}

$OBJ_TIPO_GASTO = new ClassTipoGasto();
