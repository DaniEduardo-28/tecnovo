<?php
error_log("Datos recibidos:");
foreach ($_POST as $key => $value) {
    error_log("$key: $value");
}

$id_cronograma = $_POST['id_cronograma'] ?? null;
$id_trabajador = $_POST['nombre_operador'] ?? null;
$horas_trabajadas = isset($_POST['horas_trabajadas']) ? (float)$_POST['horas_trabajadas'] : 0;
$pago_por_hora = isset($_POST['pago_por_hora']) ? (float)$_POST['pago_por_hora'] : 0;
$total_pago = isset($_POST['total_pago']) ? (float)$_POST['total_pago'] : ($horas_trabajadas * $pago_por_hora);

$id_maquinaria = $_POST['nombre_maquinaria'] ?? null;
$petroleo_entrada = isset($_POST['petroleo_entrada']) && is_numeric($_POST['petroleo_entrada']) ? (float)$_POST['petroleo_entrada'] : 0;
$petroleo_salida = isset($_POST['petroleo_salida']) && is_numeric($_POST['petroleo_salida']) ? (float)$_POST['petroleo_salida'] : 0;
$precio_petroleo = isset($_POST['precio_petroleo']) && is_numeric($_POST['precio_petroleo']) ? (float)$_POST['precio_petroleo'] : 0;

$consumo_petroleo = $petroleo_entrada - $petroleo_salida;
$pago_petroleo = $consumo_petroleo * $precio_petroleo;


error_log("ID Cronograma recibido: " . $id_cronograma);

try {
    // Validar campos obligatorios
    if (empty($id_cronograma) || empty($id_trabajador) || empty($id_maquinaria)) {
        throw new Exception("El ID del cronograma, el operador y la maquinaria son obligatorios.");
    }
    
    require_once "core/models/ClassCronograma.php";
    $VD = $OBJ_CRONOGRAMA->addOperadorMaquinaria(
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
    );
    if ($VD != "OK") {
        throw new Exception($VD);
    }

    $data["error"] = "NO";
    $data["message"] = "Operador y maquinaria agregados correctamente.";
    $data["data"] = null;
    echo json_encode($data);

} catch (\Exception $e) {
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
}
