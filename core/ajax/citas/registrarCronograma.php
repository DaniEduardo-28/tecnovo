<?php

require_once "core/models/ClassCronograma.php";

$OBJ_CRONOGRAMA = new ClassCronograma();

try {

    $fecha_inicio = isset($_POST["fecha_ingreso"]) ? $_POST["fecha_ingreso"] : 0;
    $hora_inicio = isset($_POST["hora_ingreso"]) ? $_POST["hora_ingreso"] : 0;
    $fecha_fin = isset($_POST["fecha_salida"]) ? $_POST["fecha_salida"] : 0;
    $hora_fin = isset($_POST["hora_salida"]) ? $_POST["hora_salida"] : 0;
    $fecha_1 = date('Y-m-d H:i', strtotime("$fecha_inicio $hora_inicio"));
    $fecha_2 = date('Y-m-d H:i', strtotime("$fecha_fin $hora_fin"));

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("citas"));
    if ($access_options[0]['error'] == "NO" && !$access_options[0]['flag_agregar']) {
        throw new Exception("No tienes permisos para agregar.");
    }

    $Resultado = $OBJ_CRONOGRAMA->registrarCronograma(
        $_POST['id_servicio'],
        $fecha_1,
        $fecha_2,
        $_POST['id_fundo'],
        $_POST['total_hectareas'],
        $_POST['precio_hectarea'],
        $_POST['descuento'],
        $_POST['adelanto'],
        $_POST['monto_total'],
        $_POST['saldo_por_pagar'],
        $_POST['monto_total'] - $_POST['adelanto'] <= 0 ? 'PAGADO' : 'PENDIENTE',
        'PENDIENTE',
        $_POST['id_cliente'],
        $_POST['id_maquinaria'],
        $_POST['id_operador']
    );

    if ($Resultado != "OK") {
        throw new Exception($Resultado);
    }

    echo json_encode(["error" => "NO", "message" => "Cronograma registrado con éxito."]);
} catch (Exception $e) {
    echo json_encode(["error" => "SI", "message" => $e->getMessage()]);
}
