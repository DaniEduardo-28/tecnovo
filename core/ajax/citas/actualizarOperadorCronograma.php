<?php

$id_cronograma_operador = $_POST['id_cronograma_operador'] ?? null;
$id_trabajador = $_POST['nombre_operador'] ?? null;
$horas_trabajadas = $_POST['horas_trabajadas'] ?? null;
$pago_por_hora = $_POST['pago_por_hora'] ?? null;
$total_pago = $_POST['total_pago'] ?? null;

try {
    // Validar campos obligatorios
    if (empty($id_cronograma_operador) || empty($id_trabajador) || $horas_trabajadas === null || $pago_por_hora === null) {
        throw new Exception("Todos los campos son obligatorios.");
    }

    require_once "core/models/ClassCronograma.php";
    $VD = $OBJ_CRONOGRAMA->updateOperador($id_cronograma_operador, $id_trabajador, $horas_trabajadas, $pago_por_hora, $total_pago);

    if ($VD != "OK") {
        throw new Exception($VD);
    }

    $data = array(
        "error" => "NO",
        "message" => "Operador actualizado correctamente.",
        "data" => null
    );
    echo json_encode($data);

} catch (Exception $e) {
    $data = array(
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null
    );
    echo json_encode($data);
    exit();
}
