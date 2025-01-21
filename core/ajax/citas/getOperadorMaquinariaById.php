<?php

$id_cronograma_operador = $_POST['id_cronograma_operador'] ?? 0;
$id_cronograma_maquinaria = $_POST['id_cronograma_maquinaria'] ?? 0;

try {
    if (!$id_cronograma_operador && !$id_cronograma_maquinaria) {
        throw new Exception("Se necesitan los IDs del operador y maquinaria.");
    }

    require_once "core/models/ClassCronograma.php";

    $result = $OBJ_CRONOGRAMA->getOperadorYMaquinariaById($id_cronograma_operador, $id_cronograma_maquinaria);

    if (!$result) {
        throw new Exception("No se encontró el registro.");
    }

    if (empty($result['operador']) && empty($result['maquinaria'])) {
        throw new Exception("No se encontraron datos para el operador ni la maquinaria.");
    }

    $data = [
        "error" => "NO",
        "message" => "Registro encontrado.",
        "data" => $result
    ];
    echo json_encode($data);
} catch (Exception $e) {
    $data = [
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null
    ];
    echo json_encode($data);
}

?>
