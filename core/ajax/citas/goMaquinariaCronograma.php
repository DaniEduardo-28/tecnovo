<?php
error_log("Datos recibidos:");
foreach ($_POST as $key => $value) {
    error_log("$key: $value");
}

$id_cronograma = $_POST['id_cronograma'] ?? null;
$id_maquinaria = $_POST['nombre_maquinaria'] ?? null;
$petroleo_entrada = $_POST['petroleo_entrada'] ?? null;
$petroleo_salida = $_POST['petroleo_salida'] ?? null;
$precio_petroleo = $_POST['precio_petroleo'] ?? null;

error_log("ID Cronograma recibido: " . $id_cronograma);

try {
    // Validar campos obligatorios
    if (empty($id_cronograma) || empty($id_maquinaria)) {
        throw new Exception("El cronograma y la maquinaria son campos obligatorios.");
    }

    // Establecer valores predeterminados para los campos opcionales
    $petroleo_entrada = is_numeric($petroleo_entrada) ? $petroleo_entrada : null;
    $petroleo_salida = is_numeric($petroleo_salida) ? $petroleo_salida : null;
    $precio_petroleo = is_numeric($precio_petroleo) ? $precio_petroleo : null;

    // Calcular consumo y pago solo si los valores son válidos
    $consumo_petroleo = ($petroleo_entrada !== null && $petroleo_salida !== null) ? $petroleo_entrada - $petroleo_salida : null;
    $pago_petroleo = ($consumo_petroleo !== null && $precio_petroleo !== null) ? $consumo_petroleo * $precio_petroleo : null;

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
