<?php

$id_cronograma_maquinaria = $_POST['id_cronograma_maquinaria'] ?? null;
$id_maquinaria = $_POST['nombre_maquinaria'] ?? null;
$petroleo_entrada = $_POST['petroleo_entrada'] ?? null;
$petroleo_salida = $_POST['petroleo_salida'] ?? null;
$precio_petroleo = $_POST['precio_petroleo'] ?? null;

try {
    // Validar campos obligatorios
    if (empty($id_cronograma_maquinaria) || empty($id_maquinaria) || $petroleo_entrada === null || $petroleo_salida === null || $precio_petroleo === null) {
        throw new Exception("Todos los campos son obligatorios.");
    }

    // Calcular consumo y pago de petróleo
    $consumo_petroleo = $petroleo_entrada - $petroleo_salida;
    $pago_petroleo = $consumo_petroleo * $precio_petroleo;

    require_once "core/models/ClassCronograma.php";
    $VD = $OBJ_CRONOGRAMA->updateMaquinaria($id_cronograma_maquinaria, $id_maquinaria, $petroleo_entrada, $petroleo_salida, $consumo_petroleo, $precio_petroleo, $pago_petroleo);

    if ($VD != "OK") {
        throw new Exception($VD);
    }

    $data = array(
        "error" => "NO",
        "message" => "Maquinaria actualizada correctamente.",
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
