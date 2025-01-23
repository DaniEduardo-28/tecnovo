<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateFechasHoras') {
    include_once "core/models/ClassCronograma.php";

    $id_cronograma = $_POST['id_cronograma'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $hora_ingreso = $_POST['hora_ingreso'];
    $fecha_salida = $_POST['fecha_salida'];
    $hora_salida = $_POST['hora_salida'];
    $fecha_pago = $_POST['fecha_pago'];
    $hora_pago = $_POST['hora_pago'];

    $response = $OBJ_CRONOGRAMA->updateFechasHoras($id_cronograma, $fecha_ingreso, $hora_ingreso, $fecha_salida, $hora_salida, $fecha_pago, $hora_pago);

    if ($response === "OK") {
        echo json_encode(["success" => true, "message" => "Fechas actualizadas correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => $response]);
    }
    exit();
}
