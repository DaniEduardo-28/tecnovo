<?php

$id_cronograma = $_POST['id_cronograma'] ?? null;
$id_maquinaria = $_POST['nombre_maquinaria'] ?? null;
$petroleo_entrada = $_POST['petroleo_entrada'] ?? null;
$petroleo_salida = $_POST['petroleo_salida'] ?? null;
$precio_petroleo = $_POST['precio_petroleo'] ?? null;

error_log("ID Cronograma recibido: " . $id_cronograma);

try {
    // Validar campos obligatorios
    if (empty($id_cronograma) || empty($id_maquinaria) || $petroleo_entrada === null || $petroleo_salida === null || $precio_petroleo === null) {
        throw new Exception("Todos los campos son obligatorios.");
    }

    // Validar que los valores sean numéricos y mayores o iguales a cero
    if (!is_numeric($petroleo_entrada) || $petroleo_entrada < 0 || 
        !is_numeric($petroleo_salida) || $petroleo_salida < 0 || 
        !is_numeric($precio_petroleo) || $precio_petroleo < 0) {
        throw new Exception("Los valores de entrada, salida y precio deben ser números positivos.");
    }

    // Calcular consumo y pago
    $consumo_petroleo = $petroleo_entrada - $petroleo_salida;
    $pago_petroleo = $consumo_petroleo * $precio_petroleo;

    require_once "core/models/ClassCronograma.php";
    $VD = $OBJ_CRONOGRAMA->addMaquinaria($id_cronograma, $id_maquinaria, $petroleo_entrada, $petroleo_salida, $consumo_petroleo, $precio_petroleo, $pago_petroleo);

    if ($VD != "OK") {
        throw new Exception($VD);
    }

    $data["error"] = "NO";
    $data["message"] = "Maquinaria agregada correctamente.";
    $data["data"] = null;
    echo json_encode($data);

} catch (\Exception $e) {
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
}
?>