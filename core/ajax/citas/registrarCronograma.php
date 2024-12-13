<?php

require_once "core/models/ClassCronograma.php";

$OBJ_CRONOGRAMA = new ClassCronograma();

try {
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("citas"));
    if ($access_options[0]['error'] == "NO" && !$access_options[0]['flag_agregar']) {
        throw new Exception("No tienes permisos para agregar.");
    }

    $datos = [
        'id_fundo' => $_POST['id_fundo'] ?? null,
        'fecha_ingreso' => $_POST['fecha_ingreso'] ?? null,
        'fecha_salida' => $_POST['fecha_salida'] ?? null,
        'estado_trabajo' => $_POST['estado_trabajo'] ?? 'EN PROCESO',
        'id_cliente' => $_POST['id_cliente'] ?? null,
        'adelanto' => $_POST['adelanto'] ?? 0,
        'precio_hectarea' => $_POST['precio_hectarea'] ?? 0,
        'total_hectareas' => $_POST['total_hectareas'] ?? 0,
        'descuento' => $_POST['descuento'] ?? 0,
        'monto_total' => $_POST['monto_total'] ?? 0,
        'saldo_por_pagar' => $_POST['saldo_por_pagar'] ?? 0,
        'precio_petroleo' => $_POST['precio_petroleo'] ?? 0,
        'consumo_petroleo' => $_POST['consumo_petroleo'] ?? 0,
        'pago_petroleo' => $_POST['pago_petroleo'] ?? 0,
        'maquinarias' => json_decode($_POST['maquinarias'], true),
    ];

    $Resultado = $OBJ_CRONOGRAMA->registrarCronograma($datos);

    if ($Resultado != "OK") {
        throw new Exception($Resultado);
    }

    echo json_encode(["error" => "NO", "message" => "Cronograma registrado con éxito."]);
} catch (Exception $e) {
    echo json_encode(["error" => "SI", "message" => $e->getMessage()]);
}