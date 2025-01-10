<?php

class ClassCronograma extends Conexion
{

  public function __construct() {}

  public function showCitas($id_maquinaria, $id_operador, $id_cliente, $id_fundo)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {
      $parametros = [];

      $sql = "SELECT 
    c.*,
    c.id_cronograma,
    c.fecha_ingreso AS start,
    c.fecha_salida AS end,
    CONCAT(pec.nombres, ' ', pec.apellidos, ' (', pec.apodo, ')') AS nombre_cliente,
    f.nombre AS nombre_fundo,
    ser.name_servicio AS nombre_servicio,
    GROUP_CONCAT(DISTINCT mq.descripcion SEPARATOR ', ') AS nombre_maquinaria,
    GROUP_CONCAT(DISTINCT CONCAT(pe.nombres) SEPARATOR ', ') AS nombre_operador
FROM tb_cronograma c
LEFT JOIN tb_cronograma_maquinaria m ON c.id_cronograma = m.id_cronograma
LEFT JOIN tb_maquinaria mq ON m.id_maquinaria = mq.id_maquinaria
LEFT JOIN tb_cliente cl ON c.id_cliente = cl.id_cliente
LEFT JOIN tb_fundo f ON c.id_fundo = f.id_fundo
LEFT JOIN tb_cronograma_operadores co ON c.id_cronograma = co.id_cronograma
LEFT JOIN tb_trabajador u ON co.id_trabajador = u.id_trabajador AND u.flag_medico = 1
LEFT JOIN tb_persona pe ON u.id_persona = pe.id_persona
LEFT JOIN tb_persona pec ON cl.id_persona = pec.id_persona
LEFT JOIN tb_servicio ser ON ser.id_servicio = c.id_servicio
WHERE 1=1 ";

      if ($id_maquinaria != "all") {
        $sql .= " AND m.id_maquinaria = ? ";
        $parametros[] = $id_maquinaria;
      }

      if ($id_operador != "all") {
        $sql .= " AND co.id_trabajador = ? ";
        $parametros[] = $id_operador;
      }

      if ($id_cliente != "all") {
        $sql .= " AND c.id_cliente = ? ";
        $parametros[] = $id_cliente;
      }

      if ($id_fundo != "all") {
        $sql .= " AND c.id_fundo = ? ";
        $parametros[] = $id_fundo;
      }

      $sql .= "GROUP BY 
                c.id_cronograma,
                c.fecha_ingreso,
                c.fecha_salida,
                pec.nombres,
                pec.apellidos,
                pec.apodo,
                f.nombre,
                ser.name_servicio ";

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

  public function registrarCronograma($id_servicio, $fecha_1, $fecha_2, $id_fundo, $cantidad, $monto_unitario, $descuento, $adelanto, $monto_total, $saldo_por_pagar, $estado_pago, $estado_trabajo, $id_cliente, $id_maquinaria, $id_operador)
  {

    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {

      $conexion->beginTransaction();

      $sql = "INSERT INTO tb_cronograma (
            id_servicio, fecha_ingreso, fecha_salida, lugar, cantidad, 
            monto_unitario, descuento, adelanto, monto_total, saldo_por_pagar, 
            estado_pago, estado_trabajo, id_fundo, id_cliente
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([
        $id_servicio,
        $fecha_1,
        $fecha_2,
        '',
        $cantidad,
        $monto_unitario,
        $descuento,
        $adelanto,
        $monto_total,
        $saldo_por_pagar,
        $estado_pago,
        $estado_trabajo,
        $id_fundo,
        $id_cliente
      ]);
      if ($stmt->rowCount() == 0) {
        throw new Exception("Error al realizar el registro en la base de datos.");
      }

      $id_cronograma = $conexion->lastInsertId();

      $sql = "INSERT INTO tb_cronograma_maquinaria (id_cronograma, id_maquinaria) VALUES (?, ?)";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_cronograma, $id_maquinaria]);

      if ($stmt->rowCount() == 0) {
        throw new Exception("Error al registrar la maquinaria en la base de datos.");
      }

      $sql = "INSERT INTO tb_cronograma_operadores (id_cronograma, id_trabajador, horas_trabajadas) VALUES (?, ?, 0.0)";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_cronograma, $id_operador]);

      if ($stmt->rowCount() == 0) {
        throw new Exception("Error al registrar el operador en la base de datos.");
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

  public function getCronogramaById($id_cronograma)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->open();
    $VD = null;

    try {
      $sql = "SELECT
                  c.id_cronograma,
                  c.id_servicio,
                  c.fecha_ingreso,
                  c.fecha_salida,
                  c.cantidad,
                  c.monto_unitario,
                  c.descuento,
                  c.adelanto,
                  c.monto_total,
                  c.saldo_por_pagar,
                  c.estado_pago,
                  c.estado_trabajo,
                  c.id_fundo,
                  c.id_cliente,
                  f.nombre AS nombre_fundo,
                  s.name_servicio AS nombre_servicio,
                  GROUP_CONCAT(DISTINCT m.descripcion SEPARATOR ', ') AS nombre_maquinaria,
                  GROUP_CONCAT(DISTINCT CONCAT(op.nombres, ' ', op.apellidos) SEPARATOR ', ') AS nombre_operador,
                  CONCAT(p.nombres, ' ', p.apellidos) AS nombre_cliente
              FROM tb_cronograma c
              LEFT JOIN tb_fundo f ON c.id_fundo = f.id_fundo
              LEFT JOIN tb_servicio s ON c.id_servicio = s.id_servicio
              LEFT JOIN tb_cliente cl ON c.id_cliente = cl.id_cliente
              LEFT JOIN tb_persona p ON cl.id_persona = p.id_persona
              LEFT JOIN tb_cronograma_maquinaria cm ON c.id_cronograma = cm.id_cronograma
              LEFT JOIN tb_maquinaria m ON cm.id_maquinaria = m.id_maquinaria
              LEFT JOIN tb_cronograma_operadores co ON c.id_cronograma = co.id_cronograma
              LEFT JOIN tb_trabajador t ON co.id_trabajador = t.id_trabajador
              LEFT JOIN tb_persona op ON t.id_persona = op.id_persona
              WHERE c.id_cronograma = :id_cronograma
              
              GROUP BY
                    c.id_cronograma,
                    c.id_servicio,
                    c.fecha_ingreso,
                    c.fecha_salida,
                    c.cantidad,
                    c.monto_unitario,
                    c.descuento,
                    c.adelanto,
                    c.monto_total,
                    c.saldo_por_pagar,
                    c.estado_pago,
                    c.estado_trabajo,
                    c.id_fundo,
                    c.id_cliente,
                    f.nombre,
                    s.name_servicio,
                    p.nombres,
                    p.apellidos";

      $stmt = $conexion->prepare($sql);
      $stmt->bindParam(':id_cronograma', $id_cronograma, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$result) {
        throw new Exception("No se encontró el cronograma");
      }

        $VD = ["error" => "NO", "data" => $result];
    } catch (PDOException $e) {
        $VD = ["error" => "SI", "message" => $e->getMessage()];
    } catch (Exception $e) {
        $VD = ["error" => "SI", "message" => $e->getMessage()];
    } finally {
        $conexionClass->Close();
    }

    return $VD;
  }

  public function registrarCitaAdmin($id_mascota, $id_trabajador, $id_servicio, $fecha_1, $fecha_2, $sintomas, $id_sucursal)
  {

    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {

      $conexion->beginTransaction();

      $sql = "INSERT INTO tb_cita (`id_cita`, `id_trabajador`, `id_servicio`, `id_mascota`, `fecha_registro`, `fecha_cita`, `fecha_termino`, `sintoma`, `estado`, `id_sucursal`) VALUES ";
      $sql .= "(";
      $sql .= "(SELECT CASE COUNT(a.id_cita) WHEN 0 THEN 1 ELSE (MAX(a.id_cita) + 1) end FROM `tb_cita` a),";
      $sql .= "?,?,?,now(),?,?,?,?,?";
      $sql .= ")";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_trabajador, $id_servicio, $id_mascota, $fecha_1, $fecha_2, $sintomas, "registrada", $id_sucursal]);
      if ($stmt->rowCount() == 0) {
        throw new Exception("Error al realizar el registro en la base de datos.");
      }

      $sql = "INSERT INTO tb_detalle_cita (`id_detalle`, `id_cita`, `name_servicio`) VALUES ";
      $sql .= "(";
      $sql .= "(SELECT CASE COUNT(a.id_detalle) WHEN 0 THEN 1 ELSE (MAX(a.id_detalle) + 1) end FROM `tb_detalle_cita` a),";
      $sql .= "(SELECT MAX(id_cita) FROM tb_cita),(SELECT name_servicio FROM tb_servicio WHERE id_servicio = ?)";
      $sql .= ")";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_servicio]);
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

  public function cancelar($id_cita, $id_cliente)
  {

    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {

      $conexion->beginTransaction();

      $stmt = $conexion->prepare("SELECT C.* FROM `tb_cita` C INNER JOIN tb_mascota M ON M.id_mascota = C.id_mascota WHERE C.id_cita = ? AND M.id_cliente = ?");
      $stmt->execute([$id_cita, $id_cliente]);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($result) == 0) {
        throw new Exception("No tienes permisos para cancelar esta cita.");
      }

      $sql = "UPDATE tb_cita SET estado = ? where id_cita = ?";
      $stmt = $conexion->prepare($sql);
      if ($stmt->execute(["cancelada", $id_cita]) == false) {
        throw new Exception("Ocurrió un error al canclar la cita en el sistema.");
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

  public function actualizarCita($id_cita, $id_cliente, $fecha_1, $fecha_2)
  {

    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {

      $conexion->beginTransaction();

      $stmt = $conexion->prepare("SELECT M.* FROM tb_mascota M INNER JOIN tb_cita C ON C.id_mascota = M.id_mascota WHERE C.id_cita = ? AND M.id_cliente = ?");
      $stmt->execute([$id_cita, $id_cliente]);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($result) == 0) {
        throw new Exception("No tienes permisos para actualizar cita, con esta mascota.", 1);
      }

      $sql = "UPDATE tb_cita SET fecha_cita = ?, fecha_termino = ? WHERE id_cita = ?";
      $stmt = $conexion->prepare($sql);
      if ($stmt->execute([$fecha_1, $fecha_2, $id_cita]) == false) {
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

  public function actualizarFechaCita($id_cronograma, $fecha_1, $fecha_2)
  {

    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {

      $conexion->beginTransaction();

      $sql = "UPDATE tb_cronograma SET fecha_ingreso = ?, fecha_salida = ? WHERE id_cronograma = ?";
      $stmt = $conexion->prepare($sql);
      if ($stmt->execute([$fecha_1, $fecha_2, $id_cronograma]) == false) {
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

  public function actualizarEstado($id_cita, $estado)
  {

    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {

      $conexion->beginTransaction();

      $sql = "UPDATE tb_cita SET estado = ? where id_cita = ?";
      $stmt = $conexion->prepare($sql);
      if ($stmt->execute([$estado, $id_cita]) == false) {
        throw new Exception("Ocurrió un error al actualizar el estado de la cita en el sistema.");
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

  public function getOperadorPorMaquinaria($id_maquinaria)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = "";

    try {
      $sql = "SELECT T.id_trabajador, CONCAT(P.nombres, ' ', P.apellidos) AS nombre
						FROM tb_trabajador T
						INNER JOIN tb_maquinaria M ON M.id_trabajador = T.id_trabajador
						INNER JOIN tb_persona P ON P.id_persona = T.id_persona
						WHERE M.id_maquinaria = ? AND T.estado = 'activo'";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_maquinaria]);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($result) == 0) {
        throw new Exception("No se encontraron operadores para la maquinaria.");
      }

      $VD['error'] = "NO";
      $VD['message'] = "Operador encontrado.";
      $VD['data'] = $result;
    } catch (Exception $e) {
      $VD['error'] = "SI";
      $VD['message'] = $e->getMessage();
    } finally {
      $conexionClass->Close();
    }

    return $VD;
  }
  public function showreporte($estado, $cliente, $fundo, $maquinaria, $operador)
  {

    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $conexion->exec("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

    $VD = "";

    try {

      $sql = "SELECT 
                  c.id_cronograma,
                  f.nombre AS nombre_fundo,
                  CONCAT(p.nombres, ' ', p.apellidos) AS nombre_cliente,
                  s.name_servicio AS nombre_servicio,
                  GROUP_CONCAT(DISTINCT CONCAT(op.nombres, ' ', op.apellidos) SEPARATOR ', ') AS nombre_operador,
                  GROUP_CONCAT(DISTINCT m.descripcion SEPARATOR ', ') AS nombre_maquinaria,
                  c.fecha_ingreso,
                  c.fecha_salida,
                  c.estado_trabajo
              FROM tb_cronograma c 
              LEFT JOIN tb_fundo f ON c.id_fundo = f.id_fundo
              LEFT JOIN tb_servicio s ON c.id_servicio = s.id_servicio
              LEFT JOIN tb_cliente cl ON c.id_cliente = cl.id_cliente
              LEFT JOIN tb_persona p ON cl.id_persona = p.id_persona
              LEFT JOIN tb_cronograma_maquinaria cm ON c.id_cronograma = cm.id_cronograma
              LEFT JOIN tb_maquinaria m ON cm.id_maquinaria = m.id_maquinaria
              LEFT JOIN tb_cronograma_operadores co ON c.id_cronograma = co.id_cronograma
              LEFT JOIN tb_trabajador t ON co.id_trabajador = t.id_trabajador
              LEFT JOIN tb_persona op ON t.id_persona = op.id_persona
              WHERE 1=1 ";

      //Aplicar filtros
      $parametros = [];

      if ($cliente != "all"){
        $sql .= "AND c.id_cliente = :cliente";
        $parametros[":cliente"] = $cliente;
      }

      if ($fundo != "all"){
        $sql .= "AND c.id_fundo = :fundo";
        $parametros[":fundo"] = $fundo;
      }

      if ($maquinaria != "all") {
        $sql .= " AND m.id_maquinaria = :maquinaria";
        $parametros[":maquinaria"] = $maquinaria;
      }

      if ($operador != "all") {
        $sql .= " AND t.id_trabajador = :operador";
        $parametros[":operador"] = $operador;
      } 

      $sql .= " GROUP BY 
                  c.id_cronograma, 
                  f.nombre, 
                  s.name_servicio, 
                  p.nombres, 
                  p.apellidos,
                  c.fecha_ingreso,
                  c.fecha_salida,
                  c.estado_trabajo
      
      ORDER BY c.fecha_ingreso DESC";

      $stmt = $conexion->prepare($sql);
      $stmt->execute($parametros);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($result) == 0) {
        throw new Exception("No se encontraron datos.");
      }

      // Respuesta
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

  public function getOperadoresByCronograma($id_cronograma)
{
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    
    try {
        $sql = "SELECT 
                    o.id_cronograma_operador, 
                    CONCAT(p.apellidos, ' ', p.nombres) AS nombre_operador,
                    o.horas_trabajadas, 
                    o.pago_por_hora, 
                    (o.horas_trabajadas * o.pago_por_hora) AS total_pago
                FROM tb_cronograma_operadores o
                INNER JOIN tb_trabajador t ON o.id_trabajador = t.id_trabajador
                INNER JOIN tb_persona p ON t.id_persona = p.id_persona
                WHERE o.id_cronograma = :id_cronograma";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":id_cronograma", $id_cronograma, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            return ["error" => "NO", "data" => $result];
        } else {
            return ["error" => "SI", "message" => "No se encontraron operadores para este cronograma."];
        }
    } catch (Exception $e) {
        return ["error" => "SI", "message" => $e->getMessage()];
    }
}


  public function addOperador($id_cronograma, $id_trabajador, $horas_trabajadas, $pago_por_hora, $total_pago)
  {
      $conexionClass = new Conexion();
      $conexion = $conexionClass->Open();
      $VD = "";
  
      try {
          $conexion->beginTransaction();
  
          $sql = "INSERT INTO tb_cronograma_operadores (id_cronograma, id_trabajador, horas_trabajadas, pago_por_hora, total_pago) 
                  VALUES (?, ?, ?, ?, ?)";
          $stmt = $conexion->prepare($sql);
          $stmt->execute([$id_cronograma, $id_trabajador, $horas_trabajadas, $pago_por_hora, $total_pago]);
  
          if ($stmt->rowCount() == 0) {
              throw new Exception("Ocurrió un error al registrar el operador.");
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

  public function deleteOperador($id_cronograma_operador)
{
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = "";

    try {
        $conexion->beginTransaction();

        $stmt = $conexion->prepare("DELETE FROM tb_cronograma_operadores WHERE id_cronograma_operador = ?");
        $stmt->execute([$id_cronograma_operador]);

        if ($stmt->rowCount() == 0) {
            throw new Exception("Ocurrió un error al eliminar el operador.");
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

$OBJ_CRONOGRAMA = new ClassCronograma();
