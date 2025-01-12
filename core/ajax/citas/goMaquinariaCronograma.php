<?php

$id_cronograma = $_POST['id_cronograma'] ?? null;
$id_maquinaria = $_POST['nombre_maquinaria'] ?? null;
$petroleo_entrada = $_POST['petroleo_entrada'] ?? null;
$petroleo_salida = $_POST['petroleo_salida'] ?? null;
$consumo_petroleo = $_POST['consumo_petroleo'] ?? null;
$precio_petroleo = $_POST['precio_petroleo'] ?? null;
$pago_petroleo = $_POST['pago_petroleo'] ?? null;

try {

    if (empty($id_cronograma) || empty($id_maquinaria) || $petroleo_entrada === null || $petroleo_salida === null || $consumo_petroleo === null || $precio_petroleo === null || $pago_petroleo === null) {
        throw new Exception("Todos los campos son obligatorios.");
    }
    
    

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
