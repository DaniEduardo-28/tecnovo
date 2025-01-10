<?php

$id_cronograma = $_POST['id_cronograma'] ?? null;
$id_trabajador = $_POST['id_trabajador'] ?? null;
$horas_trabajadas = $_POST['horas_trabajadas'] ?? null;
$pago_por_hora = $_POST['pago_por_hora'] ?? null;

try {

    // Validar datos obligatorios
    if (!$id_cronograma || !$id_trabajador || !$horas_trabajadas || !$pago_por_hora) {
        throw new Exception("Todos los campos son obligatorios.");
    }

    require_once "core/models/ClassCronograma.php";
    $VD = $OBJ_CRONOGRAMA->addOperador($id_cronograma, $id_trabajador, $horas_trabajadas, $pago_por_hora);

    if ($VD != "OK") {
        throw new Exception($VD);
    }

    $data["error"] = "NO";
    $data["message"] = "Operador agregado correctamente.";
    $data["data"] = null;
    echo json_encode($data);

} catch (\Exception $e) {
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
}
