<?php

$id_cronograma = $_POST['id_cronograma'] ?? null;
$id_trabajador = $_POST['nombre_operador'] ?? null;
$horas_trabajadas = isset($_POST['horas_trabajadas']) ? (float)$_POST['horas_trabajadas'] : 0;
$pago_por_hora = isset($_POST['pago_por_hora']) ? (float)$_POST['pago_por_hora'] : 0;
$total_pago = isset($_POST['total_pago']) ? (float)$_POST['total_pago'] : ($horas_trabajadas * $pago_por_hora);


try {

    if (empty($id_cronograma) || empty($id_trabajador)) {
        throw new Exception("El ID del cronograma y el trabajador son obligatorios.");
    }
    
    if ($horas_trabajadas < 0 || $pago_por_hora < 0) {
        throw new Exception("Las horas trabajadas y el pago por hora no pueden ser valores negativos.");
    }

    require_once "core/models/ClassCronograma.php";
    $VD = $OBJ_CRONOGRAMA->addOperador($id_cronograma, $id_trabajador, $horas_trabajadas, $pago_por_hora, $total_pago);

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
