<?php

$id = isset($_POST["id"]) ? $_POST["id"] : 0; // ID del operador o maquinaria
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : ""; // "operador" o "maquinaria"

try {
    if (empty($id) || empty($tipo)) {
        throw new Exception("El ID y el tipo son obligatorios.");
    }

    require_once "core/models/ClassCronograma.php";
    $VD = $OBJ_CRONOGRAMA->deleteOperadorMaquinaria($id, $tipo);

    if ($VD != "OK") {
        throw new Exception($VD);
    }

    // Respuesta exitosa
    $data = [
        "error" => "NO",
        "message" => ucfirst($tipo) . " eliminado correctamente.",
        "data" => null
    ];
    echo json_encode($data);

} catch (Exception $e) {
    // Respuesta de error
    $data = [
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null
    ];
    echo json_encode($data);
    exit();
}
