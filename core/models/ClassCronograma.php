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
    CONCAT(ts.serie, LPAD(c.codigo, 5, '0')) AS codigo_servi,
    c.fecha_ingreso AS start,
    c.fecha_salida AS end,
    c.fecha_pago,
    pec.apodo AS nombre_cliente,
    f.nombre AS nombre_fundo,
    ser.name_servicio AS nombre_servicio,
    GROUP_CONCAT(DISTINCT mq.descripcion SEPARATOR ', ') AS nombre_maquinaria,
    GROUP_CONCAT(DISTINCT CONCAT(pe.apodo) SEPARATOR ', ') AS nombre_operador, 
    CONCAT(c.cantidad, ' ', um.cod_sunat) AS cantidad_hectarea 
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
LEFT JOIN tb_tipo_servicio ts ON ser.id_tipo_servicio = ts.id_tipo_servicio 
LEFT JOIN tb_unidad_medida um ON um.id_unidad_medida = ser.id_unidad_medida 
WHERE 1=1 
AND c.estado_trabajo != 'ANULADO' ";

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
                ser.name_servicio,
                c.cantidad,
                um.cod_sunat,
                c.codigo ";

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

  public function registrarCronograma($id_servicio, $fecha_1, $fecha_2, $fecha_3, $id_fundo, $cantidad, $monto_unitario, $descuento, $adelanto, $monto_total, $saldo_por_pagar, $estado_pago, $estado_trabajo, $id_cliente, $id_maquinaria, $id_operador)
  {

    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {

      if (!empty($id_maquinaria) && is_numeric($id_maquinaria)) {
      $validacion = $this->validarDisponibilidadMaquinaria($id_maquinaria, $fecha_1, $fecha_2);
      if ($validacion['error'] === "SI") {
        throw new Exception($validacion['mensaje']);
      }
    }

      $conexion->beginTransaction();

      $sql = "SELECT id_tipo_servicio FROM tb_servicio WHERE id_servicio = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_servicio]);
      $id_tipo_servicio = $stmt->fetchColumn();

      if (!$id_tipo_servicio) {
        throw new Exception("No se encontró el tipo de servicio para el ID de servicio proporcionado.");
      }

      $sql = "SELECT MAX(codigo) 
                FROM tb_cronograma c
                JOIN tb_servicio s ON c.id_servicio = s.id_servicio
                WHERE s.id_tipo_servicio = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_tipo_servicio]);
      $ultimoCodigo = $stmt->fetchColumn();
      $nuevoCodigo = $ultimoCodigo ? $ultimoCodigo + 1 : 1;

      $sql = "SELECT (c.cantidad - COALESCE(SUM(o.horas_trabajadas), 0)) AS cantidad_restante
        FROM tb_cronograma c
        LEFT JOIN tb_cronograma_operadores o ON c.id_cronograma = o.id_cronograma
        WHERE c.id_cronograma = ?
        GROUP BY c.id_cronograma, c.cantidad";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_servicio]);
      $cantidad_restante = $stmt->fetchColumn();

      if ($cantidad_restante === false) {
        $cantidad_restante = $cantidad;
      }

      $sql = "INSERT INTO tb_cronograma (
            codigo, id_servicio, fecha_ingreso, fecha_salida, fecha_pago, lugar, cantidad, 
            monto_unitario, descuento, adelanto, monto_total, saldo_por_pagar, 
            estado_pago, estado_trabajo, id_fundo, id_cliente, cantidad_restante 
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conexion->prepare($sql);
      $fecha_pago_calculada = date('Y-m-d H:i:s', strtotime($fecha_2 . ' +10 days'));
      $fecha_pago_final = empty($fecha_3) ? $fecha_pago_calculada : $fecha_3;

      if (strtotime($fecha_2) < strtotime($fecha_1)) {
        throw new Exception("La fecha de salida no puede ser menor que la fecha de ingreso.");
      }
      if (empty($id_fundo) || !is_numeric($id_fundo) || $id_fundo <= 0) {
        throw new Exception("Es obligatorio elegir un fundo válido para el servicio.");
      }
      $stmt->execute([
        $nuevoCodigo,
        $id_servicio,
        $fecha_1,
        $fecha_2,
        $fecha_pago_final,
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
        $id_cliente,
        $cantidad_restante
      ]);
      if ($stmt->rowCount() == 0) {
        throw new Exception("Error al realizar el registro en la base de datos.");
      }

      $id_cronograma = $conexion->lastInsertId();

      if (!empty($id_maquinaria) && is_numeric($id_maquinaria)) {
      $sql = "INSERT INTO tb_cronograma_maquinaria (id_cronograma, id_maquinaria) VALUES (?, ?)";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_cronograma, $id_maquinaria]);

      if ($stmt->rowCount() == 0) {
        throw new Exception("Error al registrar la maquinaria en la base de datos.");
      }
    }

      $sql = "SELECT pago_operador FROM tb_servicio WHERE id_servicio = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_servicio]);
      $pago_operador = $stmt->fetchColumn();

      if (!$pago_operador) {
        throw new Exception("No se encontró el pago del operador para el servicio proporcionado.");
      }
      
      if (!empty($id_maquinaria) && is_numeric($id_maquinaria)) {
      $sql = "INSERT INTO tb_cronograma_operadores (id_cronograma, id_trabajador, horas_trabajadas, pago_por_hora) VALUES (?, ?, 0.0, ?)";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_cronograma, $id_operador, $pago_operador]);

      if ($stmt->rowCount() == 0) {
        throw new Exception("Error al registrar el operador en la base de datos.");
      }
    }

      if ($adelanto >= 0) {
        $sql = "INSERT INTO tb_pagos_clientes (id_cronograma, fecha_pago, metodo_pago, monto) 
                VALUES (?, NOW(), 1, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id_cronograma, $adelanto]);

        if ($stmt->rowCount() == 0) {
          throw new Exception("Error al registrar el adelanto en los pagos del cliente.");
        }
      }

      $VD = "OK";
      $conexion->commit();
    } catch (PDOException $e) {
      if ($conexion->inTransaction()) {
        $conexion->rollBack();
      }
      $VD = "Error de base de datos: " . $e->getMessage();
    } catch (Exception $exception) {
      if ($conexion->inTransaction()) {
        $conexion->rollBack();
      }
      $VD = $exception->getMessage();
    } finally {
      $conexionClass->Close();
    }
    return $VD;
  }

  public function eliminarCronograma($id_cronograma)
  {

    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {

      $conexion->beginTransaction();
      // Validar que el ID sea numérico y mayor a 0
      if (empty($id_cronograma) || !is_numeric($id_cronograma) || $id_cronograma <= 0) {
        throw new Exception("ID de cronograma inválido.");
      }

      // Preparar la consulta de eliminación
      $sql = "DELETE FROM tb_cronograma WHERE id_cronograma = :id_cronograma";
      $stmt = $conexion->prepare($sql);
      $stmt->bindParam(':id_cronograma', $id_cronograma, PDO::PARAM_INT);

      // Ejecutar la consulta
      if ($stmt->execute()) {
        return "OK"; // Retornar OK si la eliminación fue exitosa
      } else {
        throw new Exception("No se pudo eliminar el cronograma. Error en la base de datos.");
      }
    } catch (Exception $e) {
      // Capturar cualquier excepción y retornar el mensaje de error
      return $e->getMessage();
    }
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
                  c.fecha_pago,
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
                  um.cod_sunat AS unidad_servicio, 
                  f.nombre AS nombre_fundo,
                  s.name_servicio AS nombre_servicio,
                  GROUP_CONCAT(DISTINCT m.descripcion SEPARATOR ', ') AS nombre_maquinaria,
                  GROUP_CONCAT(DISTINCT CONCAT(op.nombres, ' ', op.apellidos) SEPARATOR ', ') AS nombre_operador,
                  CONCAT(p.nombres, ' ', p.apellidos) AS nombre_cliente
              FROM tb_cronograma c
              LEFT JOIN tb_fundo f ON c.id_fundo = f.id_fundo 
              LEFT JOIN tb_servicio s ON c.id_servicio = s.id_servicio 
              LEFT JOIN tb_unidad_medida um ON um.id_unidad_medida = s.id_unidad_medida 
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
                    c.fecha_pago,
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
                    um.cod_sunat,
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

      if (strtotime($fecha_2) < strtotime($fecha_1)) {
        throw new Exception("La fecha de salida no puede ser menor que la fecha de ingreso.");
      }

      $sqlMaquinarias = "SELECT id_maquinaria FROM tb_cronograma_maquinaria WHERE id_cronograma = ?";
      $stmtMaquinarias = $conexion->prepare($sqlMaquinarias);
      $stmtMaquinarias->execute([$id_cronograma]);
      $maquinarias = $stmtMaquinarias->fetchAll(PDO::FETCH_COLUMN);

      if ($maquinarias) {
        foreach ($maquinarias as $id_maquinaria) {
          $validacion = $this->validarDisponibilidadMaquinaria($id_maquinaria, $fecha_1, $fecha_2, $id_cronograma);
          if ($validacion['error'] === "SI") {
            throw new Exception($validacion['mensaje']);
          }
        }
      }

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
  public function showreporte($estado, $cliente, $fundo, $maquinaria, $operador, $unidadNegocio)
  {

    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $conexion->exec("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

    $VD = "";

    try {

      $sql = "SELECT 
                  c.id_cronograma,
                  CONCAT(ts.serie, LPAD(c.codigo, 5, '0')) AS codigo,
                f.nombre AS nombre_fundo,
                CONCAT(p.nombres, ' ', p.apellidos) AS nombre_cliente,
                s.name_servicio AS nombre_servicio,
                CONCAT(c.cantidad, ' ', um.cod_sunat) AS cant_medida,
                GROUP_CONCAT(DISTINCT CONCAT(op.nombres, ' ', op.apellidos) SEPARATOR ', ') AS nombre_operador,
                GROUP_CONCAT(DISTINCT m.descripcion SEPARATOR ', ') AS nombre_maquinaria,
                c.fecha_ingreso,
                mo.signo,
                c.fecha_salida,
                c.estado_trabajo,
                c.monto_total AS total,
                IFNULL((
                    SELECT SUM(cm.pago_petroleo) 
                    FROM tb_cronograma_maquinaria cm 
                    WHERE cm.id_cronograma = c.id_cronograma
                ), 0) + IFNULL((
                    SELECT SUM(co.total_pago) 
                    FROM tb_cronograma_operadores co 
                    WHERE co.id_cronograma = c.id_cronograma
                ), 0) AS gastos,
                c.monto_total - (
                    IFNULL((
                        SELECT SUM(cm.pago_petroleo) 
                        FROM tb_cronograma_maquinaria cm 
                        WHERE cm.id_cronograma = c.id_cronograma
                    ), 0) + IFNULL((
                        SELECT SUM(co.total_pago) 
                        FROM tb_cronograma_operadores co 
                        WHERE co.id_cronograma = c.id_cronograma
                    ), 0)
                ) AS ganancia
              FROM tb_cronograma c 
              LEFT JOIN tb_fundo f ON c.id_fundo = f.id_fundo
              LEFT JOIN tb_servicio s ON c.id_servicio = s.id_servicio 
              LEFT JOIN tb_moneda mo ON mo.id_moneda = s.id_moneda 
              LEFT JOIN tb_unidad_medida um ON um.id_unidad_medida = s.id_unidad_medida 
              LEFT JOIN tb_tipo_servicio ts ON s.id_tipo_servicio = ts.id_tipo_servicio 
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

      if ($cliente != "all") {
        $sql .= "AND c.id_cliente = :cliente";
        $parametros[":cliente"] = $cliente;
      }

      if ($fundo != "all") {
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
      if ($unidadNegocio != "all") {
        $sql .= " AND s.id_tipo_servicio = :unidadNegocio";
        $parametros[":unidadNegocio"] = $unidadNegocio;
      }

      $sql .= " GROUP BY 
                  c.id_cronograma, 
                  f.nombre, 
                  s.name_servicio, 
                  p.nombres, 
                  p.apellidos,
                  c.cantidad, 
                  um.cod_sunat,
                  c.fecha_ingreso,
                  c.fecha_salida,
                  c.estado_trabajo,
                  c.monto_total,
                  c.codigo,
                  mo.signo 
      
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


  public function actualizarEstadoCronograma($id_cronograma, $nuevo_estado)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    try {

      //$this->actualizarCantidadRestante($id_cronograma);


      $sql = "SELECT cantidad_restante FROM tb_cronograma WHERE id_cronograma = :id";
      $stmt = $conexion->prepare($sql);
      $stmt->bindParam(':id', $id_cronograma, PDO::PARAM_INT);
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        return "Error: No se encontró el cronograma.";
      }
      $cantidad_restante = floatval($data["cantidad_restante"]);

      if ($nuevo_estado === "TERMINADO" && $cantidad_restante > 0) {
        return "Error: No se puede cambiar a TERMINADO porque aún hay cantidad disponible.";
      }

      $sql = "UPDATE tb_cronograma SET estado_trabajo = :estado WHERE id_cronograma = :id";
      $stmt = $conexion->prepare($sql);
      $stmt->bindParam(':estado', $nuevo_estado, PDO::PARAM_STR);
      $stmt->bindParam(':id', $id_cronograma, PDO::PARAM_INT);
      $stmt->execute();

      return "OK";
    } catch (PDOException $e) {
      return "Error: " . $e->getMessage();
    }
  }

  public function updateFechasHoras($id_cronograma, $fecha_ingreso, $hora_ingreso, $fecha_salida, $hora_salida, $fecha_pago, $hora_pago, $cantidad, $monto_unitario, $descuento, $adelanto, $monto_total, $saldo_por_pagar)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {
      $conexion->beginTransaction();

      // Validar el ID
      if (empty($id_cronograma) || !is_numeric($id_cronograma)) {
        throw new Exception("ID de cronograma inválido.");
      }

      $datetime_ingreso = $fecha_ingreso . " " . $hora_ingreso;
      $datetime_salida = $fecha_salida . " " . $hora_salida;
      $fecha_pago_calculada = date('Y-m-d H:i:s', strtotime($fecha_salida . ' +10 days'));
      $datetime_pago = empty($fecha_pago) ? $fecha_pago_calculada : $fecha_pago . " " . $hora_pago;

      if (strtotime($fecha_salida) < strtotime($fecha_ingreso)) {
        throw new Exception("La fecha de salida no puede ser menor que la fecha de ingreso.");
      }
      $sqlMaquinarias = "SELECT id_maquinaria FROM tb_cronograma_maquinaria WHERE id_cronograma = ?";
      $stmtMaquinarias = $conexion->prepare($sqlMaquinarias);
      $stmtMaquinarias->execute([$id_cronograma]);
      $maquinarias = $stmtMaquinarias->fetchAll(PDO::FETCH_COLUMN);

      if ($maquinarias) {
        foreach ($maquinarias as $id_maquinaria) {
          $validacion = $this->validarDisponibilidadMaquinaria($id_maquinaria, $datetime_ingreso, $datetime_salida, $id_cronograma);
          if ($validacion['error'] === "SI") {
            throw new Exception($validacion['mensaje']);
          }
        }
      }

      if ($cantidad <= 0) {
        throw new Exception("La cantidad debe ser mayor a cero.");
      }
      if ($monto_unitario < 0) {
        throw new Exception("El monto unitario no puede ser negativo.");
      }
      if ($descuento < 0 || $adelanto < 0) {
        throw new Exception("El descuento y el adelanto no pueden ser negativos.");
      }
      if ($monto_total < 0 || $saldo_por_pagar < 0) {
        throw new Exception("El monto total y el saldo por pagar no pueden ser negativos.");
      }

      $sql = "SELECT (c.cantidad - COALESCE(SUM(o.horas_trabajadas), 0)) AS cantidad_restante
                FROM tb_cronograma c
                LEFT JOIN tb_cronograma_operadores o ON c.id_cronograma = o.id_cronograma
                WHERE c.id_cronograma = ?
                GROUP BY c.id_cronograma, c.cantidad";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_cronograma]);
      $cantidad_restante = $stmt->fetchColumn();

      if ($cantidad_restante === false) {
        $cantidad_restante = $cantidad;
      }

      $sql = "UPDATE tb_cronograma SET fecha_ingreso = ?, 
                                        fecha_salida = ?, 
                                        fecha_pago = ?, 
                                        cantidad = ?, 
                                        monto_unitario = ?, 
                                        descuento = ?, 
                                        adelanto = ?, 
                                        monto_total = ?, 
                                        saldo_por_pagar = ? WHERE id_cronograma = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$datetime_ingreso, $datetime_salida, $datetime_pago, $cantidad, $monto_unitario, $descuento, $adelanto, $monto_total, $saldo_por_pagar, $id_cronograma]);

      $sqlUpdateCantidadRestante = "UPDATE tb_cronograma SET cantidad_restante = (cantidad - COALESCE((SELECT SUM(horas_trabajadas) FROM tb_cronograma_operadores WHERE id_cronograma = ?), 0)) WHERE id_cronograma = ?";
      $stmtUpdate = $conexion->prepare($sqlUpdateCantidadRestante);
      $stmtUpdate->execute([$id_cronograma, $id_cronograma]);

      if ($adelanto >= 0) {
        $sqlCheck = "SELECT id_pago_cliente FROM tb_pagos_clientes 
                     WHERE id_cronograma = ? AND metodo_pago = 1 
                     ORDER BY fecha_pago ASC LIMIT 1";
        $stmtCheck = $conexion->prepare($sqlCheck);
        $stmtCheck->execute([$id_cronograma]);
        $id_pago_cliente = $stmtCheck->fetchColumn();

        if ($id_pago_cliente) {
          $sqlUpdateAdelanto = "UPDATE tb_pagos_clientes SET monto = ?, fecha_pago = NOW() WHERE id_pago_cliente = ?";
          $stmtUpdateAdelanto = $conexion->prepare($sqlUpdateAdelanto);
          $stmtUpdateAdelanto->execute([$adelanto, $id_pago_cliente]);
        } else {
          $sqlInsertAdelanto = "INSERT INTO tb_pagos_clientes (id_cronograma, fecha_pago, metodo_pago, monto) 
                                  VALUES (?, NOW(), 1, ?)";
          $stmtInsertAdelanto = $conexion->prepare($sqlInsertAdelanto);
          $stmtInsertAdelanto->execute([$id_cronograma, $adelanto]);
        }
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


  public function addOperadorMaquinaria(
    $id_cronograma,
    $id_trabajador,
    $horas_trabajadas,
    $pago_por_hora,
    $total_pago,
    $id_maquinaria,
    $petroleo_entrada,
    $petroleo_salida,
    $consumo_petroleo,
    $precio_petroleo,
    $pago_petroleo
  ) {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = "";

    try {
      $conexion->beginTransaction();

      $sqlCheckOperador = "SELECT COUNT(*) as count FROM tb_cronograma_operadores 
                             WHERE id_cronograma = ? AND id_trabajador = ?";
      $stmtCheckOperador = $conexion->prepare($sqlCheckOperador);
      $stmtCheckOperador->execute([$id_cronograma, $id_trabajador]);
      $existeOperador = $stmtCheckOperador->fetch(PDO::FETCH_ASSOC)['count'] > 0;

      if ($existeOperador) {
        throw new Exception("El operador ya está registrado para este cronograma.");
      }

      $sqlCheckMaquinaria = "SELECT COUNT(*) as count FROM tb_cronograma_maquinaria 
                               WHERE id_cronograma = ? AND id_maquinaria = ?";
      $stmtCheckMaquinaria = $conexion->prepare($sqlCheckMaquinaria);
      $stmtCheckMaquinaria->execute([$id_cronograma, $id_maquinaria]);


      $sql1 = "INSERT INTO tb_cronograma_operadores (id_cronograma, id_trabajador, horas_trabajadas, pago_por_hora, total_pago) 
                 VALUES (?, ?, ?, ?, ?)";
      $total_pago = $horas_trabajadas * $pago_por_hora;
      $stmt1 = $conexion->prepare($sql1);
      $stmt1->execute([$id_cronograma, $id_trabajador, $horas_trabajadas, $pago_por_hora, $total_pago]);

      $consumo_petroleo = $petroleo_entrada - $petroleo_salida;
      $pago_petroleo = $consumo_petroleo * $precio_petroleo;

      $sqlCantidadRestante = "SELECT (c.cantidad - COALESCE(SUM(o.horas_trabajadas), 0)) AS cantidad_restante
                                FROM tb_cronograma c
                                LEFT JOIN tb_cronograma_operadores o ON c.id_cronograma = o.id_cronograma
                                WHERE c.id_cronograma = ?
                                GROUP BY c.id_cronograma, c.cantidad";
      $stmtCantidadRestante = $conexion->prepare($sqlCantidadRestante);
      $stmtCantidadRestante->execute([$id_cronograma]);
      $cantidad_restante = $stmtCantidadRestante->fetchColumn();

      if ($cantidad_restante === false) {
        $cantidad_restante = 0;
      }

      $sqlUpdateCantidad = "UPDATE tb_cronograma SET cantidad_restante = ? WHERE id_cronograma = ?";
      $stmtUpdateCantidad = $conexion->prepare($sqlUpdateCantidad);
      $stmtUpdateCantidad->execute([$cantidad_restante, $id_cronograma]);

      $sql2 = "INSERT INTO tb_cronograma_maquinaria (id_cronograma, id_maquinaria, petroleo_entrada, petroleo_salida, consumo_petroleo, precio_petroleo, pago_petroleo) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt2 = $conexion->prepare($sql2);
      $stmt2->execute([$id_cronograma, $id_maquinaria, $petroleo_entrada, $petroleo_salida, $consumo_petroleo, $precio_petroleo, $pago_petroleo]);

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


  public function getOperadoresMaquinariasByCronograma($id_cronograma)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();

    try {

      $sql = "SELECT s.id_unidad_medida, s.pago_operador
                FROM tb_cronograma c
                INNER JOIN tb_servicio s ON c.id_servicio = s.id_servicio
                WHERE c.id_cronograma = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_cronograma]);
      $unidad_medida_y_pago = $stmt->fetch(PDO::FETCH_ASSOC);

      $unidad_medida = $unidad_medida_y_pago['id_unidad_medida'] ?? null;
      $pago_operador = $unidad_medida_y_pago['pago_operador'] ?? 0;


      $sqlOperadores = "SELECT 
                            o.id_cronograma_operador, 
                            CONCAT(p.apellidos, ' ', p.nombres) AS nombre_operador,
                            o.horas_trabajadas, 
                            o.pago_por_hora, 
                            (o.horas_trabajadas * o.pago_por_hora) AS total_pago
                          FROM tb_cronograma_operadores o
                          INNER JOIN tb_trabajador t ON o.id_trabajador = t.id_trabajador
                          INNER JOIN tb_persona p ON t.id_persona = p.id_persona
                          WHERE o.id_cronograma = :id_cronograma";

      $stmtOperadores = $conexion->prepare($sqlOperadores);
      $stmtOperadores->bindParam(":id_cronograma", $id_cronograma, PDO::PARAM_INT);
      $stmtOperadores->execute();
      $operadores = $stmtOperadores->fetchAll(PDO::FETCH_ASSOC);

      $sqlMaquinarias = "SELECT 
                            m.id_cronograma_maquinaria, 
                            maq.descripcion AS nombre_maquinaria, 
                            m.petroleo_entrada, 
                            m.petroleo_salida, 
                            (m.petroleo_entrada - m.petroleo_salida) AS consumo_petroleo, 
                            m.precio_petroleo, 
                            ((m.petroleo_entrada - m.petroleo_salida) * m.precio_petroleo) AS pago_petroleo
                          FROM tb_cronograma_maquinaria m
                          INNER JOIN tb_maquinaria maq ON m.id_maquinaria = maq.id_maquinaria
                          WHERE m.id_cronograma = :id_cronograma";

      $stmtMaquinarias = $conexion->prepare($sqlMaquinarias);
      $stmtMaquinarias->bindParam(":id_cronograma", $id_cronograma, PDO::PARAM_INT);
      $stmtMaquinarias->execute();
      $maquinarias = $stmtMaquinarias->fetchAll(PDO::FETCH_ASSOC);

      $sqlCantidad = "SELECT cantidad FROM tb_cronograma WHERE id_cronograma = :id_cronograma";
      $stmtCantidad = $conexion->prepare($sqlCantidad);
      $stmtCantidad->bindParam(":id_cronograma", $id_cronograma, PDO::PARAM_INT);
      $stmtCantidad->execute();
      $cantidad = $stmtCantidad->fetchColumn();

      $data = [
        "unidad_medida" => $unidad_medida,
        "pago_operador" => $pago_operador,
        "operadores" => $operadores,
        "maquinarias" => $maquinarias,
        "cantidad" => $cantidad !== false ? $cantidad : 0
      ];

      if (!empty($data['operadores']) || !empty($data['maquinarias'])) {
        return ["error" => "NO", "data" => $data];
      } else {
        return ["error" => "SI", "message" => "No se encontraron datos para este cronograma."];
      }
    } catch (Exception $e) {
      return ["error" => "SI", "message" => $e->getMessage()];
    }
  }


  public function updateOperadorMaquinaria(
    $id_cronograma_operador,
    $id_trabajador,
    $horas_trabajadas,
    $pago_por_hora,
    $total_pago,
    $id_cronograma_maquinaria,
    $id_maquinaria,
    $petroleo_entrada,
    $petroleo_salida,
    $precio_petroleo
  ) {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = "";

    try {
      $conexion->beginTransaction();

      $sqlGetCronograma = "SELECT id_cronograma FROM tb_cronograma_operadores WHERE id_cronograma_operador = ?";
      $stmtGetCronograma = $conexion->prepare($sqlGetCronograma);
      $stmtGetCronograma->execute([$id_cronograma_operador]);
      $id_cronograma = $stmtGetCronograma->fetchColumn();

      $sqlOperador = "UPDATE tb_cronograma_operadores 
                        SET id_trabajador = ?, horas_trabajadas = ?, pago_por_hora = ?, total_pago = ? 
                        WHERE id_cronograma_operador = ?";
      $stmtOperador = $conexion->prepare($sqlOperador);
      $stmtOperador->execute([$id_trabajador, $horas_trabajadas, $pago_por_hora, $total_pago, $id_cronograma_operador]);

      if ($stmtOperador->rowCount() === 0) {
        $VD = "No se realizaron cambios en el operador.";
      }

      $consumo_petroleo = $petroleo_entrada - $petroleo_salida;
      $pago_petroleo = $consumo_petroleo * $precio_petroleo;

      $sqlCantidadRestante = "SELECT (c.cantidad - COALESCE(SUM(o.horas_trabajadas), 0)) AS cantidad_restante
                                FROM tb_cronograma c
                                LEFT JOIN tb_cronograma_operadores o ON c.id_cronograma = o.id_cronograma
                                WHERE c.id_cronograma = ?
                                GROUP BY c.id_cronograma, c.cantidad";
      $stmtCantidadRestante = $conexion->prepare($sqlCantidadRestante);
      $stmtCantidadRestante->execute([$id_cronograma]);
      $cantidad_restante = $stmtCantidadRestante->fetchColumn();

      if ($cantidad_restante === false) {
        $cantidad_restante = 0;
      }

      $sqlUpdateCantidad = "UPDATE tb_cronograma SET cantidad_restante = ? WHERE id_cronograma = ?";
      $stmtUpdateCantidad = $conexion->prepare($sqlUpdateCantidad);
      $stmtUpdateCantidad->execute([$cantidad_restante, $id_cronograma]);

      if (!empty($id_cronograma_maquinaria) && is_numeric($id_cronograma_maquinaria)) {
        // Si ya existe, actualizar la maquinaria
        $sqlMaquinaria = "UPDATE tb_cronograma_maquinaria 
                          SET id_maquinaria = ?, petroleo_entrada = ?, petroleo_salida = ?, 
                              consumo_petroleo = ?, precio_petroleo = ?, pago_petroleo = ? 
                          WHERE id_cronograma_maquinaria = ?";
        $stmtMaquinaria = $conexion->prepare($sqlMaquinaria);
        $stmtMaquinaria->execute([$id_maquinaria, $petroleo_entrada, $petroleo_salida, $consumo_petroleo, $precio_petroleo, $pago_petroleo, $id_cronograma_maquinaria]);
    } else {
        // Si no existe, crear un nuevo registro en la tabla
        $sqlMaquinaria = "INSERT INTO tb_cronograma_maquinaria (id_cronograma, id_maquinaria, petroleo_entrada, petroleo_salida, consumo_petroleo, precio_petroleo, pago_petroleo) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtMaquinaria = $conexion->prepare($sqlMaquinaria);
        $stmtMaquinaria->execute([$id_cronograma, $id_maquinaria, $petroleo_entrada, $petroleo_salida, $consumo_petroleo, $precio_petroleo, $pago_petroleo]);
    
        $id_cronograma_maquinaria = $conexion->lastInsertId(); // Guardar el nuevo ID
    }
    
    if ($stmtMaquinaria->rowCount() === 0) {
        $VD .= " No se realizaron cambios en la maquinaria.";
    }

      if ($stmtOperador->rowCount() === 0 && $stmtMaquinaria->rowCount() === 0) {
        throw new Exception("No se realizaron cambios en el operador ni en la maquinaria.");
      }
      $VD = "OK";
      $conexion->commit();
    } catch (PDOException $e) {
      $conexion->rollBack();
      $VD = "Error en la base de datos: " . $e->getMessage();
    } catch (Exception $exception) {
      $conexion->rollBack();
      $VD = $exception->getMessage();
    } finally {
      $conexionClass->Close();
    }

    return $VD;
  }


  public function deleteOperadorMaquinaria($id_cronograma_operador, $id_cronograma_maquinaria)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = "";

    try {
      $conexion->beginTransaction();

      $stmt1 = $conexion->prepare("DELETE FROM tb_cronograma_operadores WHERE id_cronograma_operador = ?");
      $stmt1->execute([$id_cronograma_operador]);
      if ($stmt1->rowCount() == 0) {
        throw new Exception("Ocurrió un error al eliminar el registro.");
      }

      $stmt2 = $conexion->prepare("DELETE FROM tb_cronograma_maquinaria WHERE id_cronograma_maquinaria = ?");
      $stmt2->execute([$id_cronograma_maquinaria]);
      if ($stmt2->rowCount() == 0) {
        throw new Exception("Ocurrió un error al eliminar el registro.");
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

  public function getOperadorYMaquinariaById($id_cronograma_operador, $id_cronograma_maquinaria)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    try {
      $response = [
        "operador" => null,
        "maquinaria" => null,
      ];
      $sqlOperador = "SELECT * FROM tb_cronograma_operadores WHERE id_cronograma_operador = ?";
      $stmtOperador = $conexion->prepare($sqlOperador);
      $stmtOperador->execute([$id_cronograma_operador]);
      $operador = $stmtOperador->fetch(PDO::FETCH_ASSOC);

      $response["operador"] = $operador ?: [
        "id_cronograma_operador" => null,
        "id_trabajador" => null,
        "horas_trabajadas" => 0,
        "pago_por_hora" => 0,
        "total_pago" => 0,
      ];

      $sqlMaquinaria = "SELECT * FROM tb_cronograma_maquinaria WHERE id_cronograma_maquinaria = ?";
      $stmtMaquinaria = $conexion->prepare($sqlMaquinaria);
      $stmtMaquinaria->execute([$id_cronograma_maquinaria]);
      $maquinaria = $stmtMaquinaria->fetch(PDO::FETCH_ASSOC);

      $response["maquinaria"] = $maquinaria ?: [
        "id_cronograma_maquinaria" => null,
        "id_maquinaria" => null,
        "petroleo_entrada" => 0,
        "petroleo_salida" => 0,
        "consumo_petroleo" => 0,
        "precio_petroleo" => 0,
        "pago_petroleo" => 0,
      ];

      return $response;
    } catch (PDOException $e) {
      $response = [
        "error" => "SI",
        "message" => $e->getMessage()
      ];
    } finally {
      $conexionClass->Close();
    }

    return $response;
  }


  public function getResumenComprasServicios($id_cronograma)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $response = [];

    try {
      $sqlCronograma = "
      SELECT 
          c.*,
          CONCAT(ts.serie, LPAD(c.codigo, 5, '0')) AS codigo, 
          CONCAT(d.name_documento, ': ', p.num_documento) AS documento_identidad,
          s.name_servicio AS nombre_servicio,
          f.nombre AS nombre_fundo, 
          CONCAT(p.nombres, ' ', p.apellidos) AS nombre_cliente, 
          (c.saldo_por_pagar - COALESCE(SUM(pc.monto), 0) + c.adelanto) AS saldo_por_pagar
      FROM tb_cronograma c
      INNER JOIN tb_servicio s ON c.id_servicio = s.id_servicio
      INNER JOIN tb_tipo_servicio ts ON s.id_tipo_servicio = ts.id_tipo_servicio 
      INNER JOIN tb_fundo f ON c.id_fundo = f.id_fundo
      INNER JOIN tb_cliente cl ON c.id_cliente = cl.id_cliente 
      INNER JOIN tb_persona p ON cl.id_persona = p.id_persona 
      INNER JOIN tb_documento_identidad d ON d.id_documento = p.id_documento 
      LEFT JOIN tb_pagos_clientes pc ON c.id_cronograma = pc.id_cronograma 
      WHERE c.id_cronograma = :id_cronograma 
      GROUP BY 
      c.id_cronograma, c.codigo, c.fecha_ingreso, c.fecha_salida, 
    c.fecha_pago, c.cantidad, c.monto_unitario, c.descuento, 
    c.adelanto, c.monto_total, c.estado_pago, c.estado_trabajo, 
    c.saldo_por_pagar, ts.serie, d.name_documento, p.num_documento, 
    s.name_servicio, f.nombre, p.nombres, p.apellidos 
  ";
      $stmtCronograma = $conexion->prepare($sqlCronograma);
      $stmtCronograma->bindParam(":id_cronograma", $id_cronograma, PDO::PARAM_INT);
      $stmtCronograma->execute();
      $cronograma = $stmtCronograma->fetch(PDO::FETCH_ASSOC);

      if (!$cronograma) {
        throw new Exception("No se encontró información del cronograma.");
      }

      $sqlOperadores = "
  SELECT 
      o.id_cronograma_operador,
      CONCAT(p.nombres, ' ', p.apellidos) AS nombre_operador,
      o.horas_trabajadas,
      o.pago_por_hora,
      o.total_pago
  FROM tb_cronograma_operadores o
  INNER JOIN tb_trabajador t ON o.id_trabajador = t.id_trabajador
  INNER JOIN tb_persona p ON t.id_persona = p.id_persona
  WHERE o.id_cronograma = :id_cronograma
";
      $stmtOperadores = $conexion->prepare($sqlOperadores);
      $stmtOperadores->bindParam(":id_cronograma", $id_cronograma, PDO::PARAM_INT);
      $stmtOperadores->execute();
      $operadores = $stmtOperadores->fetchAll(PDO::FETCH_ASSOC);

      $sqlMaquinarias = "
SELECT 
    m.id_cronograma_maquinaria,
    maq.descripcion AS nombre_maquinaria,
    m.petroleo_entrada,
    m.petroleo_salida,
    m.consumo_petroleo,
    m.precio_petroleo,
    m.pago_petroleo
FROM tb_cronograma_maquinaria m
INNER JOIN tb_maquinaria maq ON m.id_maquinaria = maq.id_maquinaria
WHERE m.id_cronograma = :id_cronograma
";
      $stmtMaquinarias = $conexion->prepare($sqlMaquinarias);
      $stmtMaquinarias->bindParam(":id_cronograma", $id_cronograma, PDO::PARAM_INT);
      $stmtMaquinarias->execute();
      $maquinarias = $stmtMaquinarias->fetchAll(PDO::FETCH_ASSOC);

      $totalPagoOperadores = array_sum(array_column($operadores, 'total_pago'));
      $totalPagoMaquinarias = array_sum(array_column($maquinarias, 'pago_petroleo'));


      $response = [
        "error" => "NO",
        "cronograma" => $cronograma,
        "operadores" => $operadores,
        "maquinarias" => $maquinarias,
        "totales" => [
          "total_pago_operadores" => $totalPagoOperadores,
          "total_pago_maquinarias" => $totalPagoMaquinarias
        ]
      ];
    } catch (PDOException $e) {
      $response = [
        "error" => "SI",
        "message" => $e->getMessage()
      ];
    } finally {
      $conexionClass->Close();
    }

    return $response;
  }

  public function getUnidadMedidaByServicio($id_cronograma)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {
      $sql = "SELECT s.id_unidad_medida, s.pago_operador
              FROM tb_cronograma c 
              INNER JOIN tb_servicio s ON c.id_servicio = s.id_servicio 
              WHERE c.id_cronograma = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_cronograma]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result) {
        $VD = ["error" => "NO", "data" => $result];
        error_log("Resultado exitoso: " . json_encode($result));
      } else {
        error_log("No se encontró unidad de medida para ID de cronograma: " . $id_cronograma);
        $VD = ["error" => "SI", "message" => "No se encontró la unidad de medida para este servicio."];
      }
    } catch (PDOException $e) {
      error_log("Error en la consulta: " . $e->getMessage());
      $VD = ["error" => "SI", "message" => $e->getMessage()];
    } finally {
      $conexionClass->Close();
    }

    return $VD;
  }

  public function validarDisponibilidadMaquinaria($id_maquinaria, $fecha_ingreso, $fecha_salida, $id_cronograma = null)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = null;

    try {
      $sql = "SELECT 
                    cm.id_maquinaria
                FROM 
                    tb_cronograma_maquinaria cm
                JOIN 
                    tb_cronograma c ON cm.id_cronograma = c.id_cronograma
                WHERE 
                    cm.id_maquinaria = :id_maquinaria 
                    AND c.estado_trabajo != 'ANULADO' 
                    AND (
                        (:fecha_ingreso BETWEEN c.fecha_ingreso AND c.fecha_salida)
                        OR 
                        (:fecha_salida BETWEEN c.fecha_ingreso AND c.fecha_salida)
                        OR 
                        (c.fecha_ingreso BETWEEN :fecha_ingreso AND :fecha_salida)
                    )";

      if (!empty($id_cronograma)) {
        $sql .= " AND c.id_cronograma != :id_cronograma";
      }

      $stmt = $conexion->prepare($sql);
      $stmt->bindParam(':id_maquinaria', $id_maquinaria, PDO::PARAM_INT);
      $stmt->bindParam(':fecha_ingreso', $fecha_ingreso, PDO::PARAM_STR);
      $stmt->bindParam(':fecha_salida', $fecha_salida, PDO::PARAM_STR);

      if (!empty($id_cronograma)) {
        $stmt->bindParam(':id_cronograma', $id_cronograma, PDO::PARAM_INT);
      }

      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return [
          "error" => "SI",
          "mensaje" => "La maquinaria se encontrará ocupada en estas fechas"
        ];
      }

      return [
        "error" => "NO",
        "mensaje" => "La maquinaria está disponible."
      ];
    } catch (PDOException $e) {
      return ["error" => "SI", "mensaje" => "Error en la consulta: " . $e->getMessage()];
    } finally {
      $conexionClass->Close();
    }
  }


  public function getCountPagos($id_cronograma)
  {

    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = "";

    try {

      $parametros = null;
      $sql = "SELECT COUNT(*) as cantidad 
			FROM tb_pagos_clientes WHERE id_cronograma = ?";

      $parametros[] = $id_cronograma;

      $stmt = $conexion->prepare($sql);
      $stmt->execute($parametros);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($result) == 0) {
        throw new Exception("No se encontraron datos");
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

  public function getPagos($id_cronograma)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = "";

    try {

      $sql = "SELECT p.id_cronograma, c.monto_total, p.id_pago_cliente, p.fecha_pago, f.name_forma_pago, p.monto 
                FROM tb_cronograma c
                LEFT JOIN tb_pagos_clientes p ON c.id_cronograma = p.id_cronograma
                LEFT JOIN tb_forma_pago f ON p.metodo_pago = f.id_forma_pago
                WHERE c.id_cronograma = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_cronograma]);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      error_log("Datos obtenidos: " . print_r($result, true));

      if (empty($result)) {
        $stmt = $conexion->prepare("SELECT monto_total FROM tb_cronograma WHERE id_cronograma = ?");
        $stmt->execute([$id_cronograma]);
        $monto_total = $stmt->fetchColumn();

        $result = [
          [
            "id_cronograma" => $id_cronograma,
            "monto_total" => $monto_total,
            "id_pago_cliente" => null,
            "fecha_pago" => null,
            "name_forma_pago" => null,
            "monto" => 0
          ]
        ];
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


  public function addPagos($id_cronograma, $metodo_pago, $fecha_pago, $monto)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = "";

    try {

      $conexion->beginTransaction();

      $sql = "INSERT INTO tb_pagos_clientes (id_cronograma, metodo_pago, fecha_pago, monto) VALUES (?, ?, ?, ?)";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_cronograma, $metodo_pago, $fecha_pago, $monto]);

      if ($stmt->rowCount() == 0) {
        throw new Exception("Ocurrió un error al registrar pago.");
      }

      $sql = "SELECT SUM(monto) FROM tb_pagos_clientes WHERE id_cronograma = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_cronograma]);
      $total_pagado = $stmt->fetchColumn();

      $sql = "SELECT monto_total FROM tb_cronograma WHERE id_cronograma = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_cronograma]);
      $monto_total = $stmt->fetchColumn();

      $nuevo_estado = ($total_pagado >= $monto_total) ? "CANCELADO" : "PENDIENTE";
      $sql = "UPDATE tb_cronograma SET estado_pago = ? WHERE id_cronograma = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$nuevo_estado, $id_cronograma]);

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

  public function deletepago($id_pago_cliente)
  {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();
    $VD = "";
    try {

      $conexion->beginTransaction();

      $sql = "SELECT id_cronograma FROM tb_pagos_clientes WHERE id_pago_cliente = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_pago_cliente]);
      $id_cronograma = $stmt->fetchColumn();

      $stmt = $conexion->prepare("DELETE FROM tb_pagos_clientes WHERE id_pago_cliente = ?");
      $stmt->execute([$id_pago_cliente]);
      if ($stmt->rowCount() == 0) {
        throw new Exception("Ocurrió un error al eliminar el registro.");
      }

      $sql = "SELECT COALESCE(SUM(monto), 0) FROM tb_pagos_clientes WHERE id_cronograma = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_cronograma]);
      $total_pagado = $stmt->fetchColumn();

      $sql = "SELECT monto_total FROM tb_cronograma WHERE id_cronograma = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$id_cronograma]);
      $monto_total = $stmt->fetchColumn();

      $nuevo_estado_pago = ($total_pagado >= $monto_total) ? "CANCELADO" : "PENDIENTE";

      $sql = "UPDATE tb_cronograma SET estado_pago = ? WHERE id_cronograma = ?";
      $stmt = $conexion->prepare($sql);
      $stmt->execute([$nuevo_estado_pago, $id_cronograma]);

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
