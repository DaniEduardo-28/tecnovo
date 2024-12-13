<?php

require_once "core/models/ClassCronograma.php";

$OBJ_CRONOGRAMA = new ClassCronograma();

try {
    $id_cronograma = isset($_POST['id_cronograma']) ? $_POST['id_cronograma'] : null;

    if (empty($id_cronograma)) {
        throw new Exception("No se recibió el ID del cronograma.");
    }

    $resultado = $OBJ_CRONOGRAMA->getCronogramaById($id_cronograma);

    if ($resultado['error'] === "SI") {
        throw new Exception($resultado['message']);
    }

    echo json_encode([
        "error" => "NO",
        "message" => "Cronograma encontrado.",
        "data" => $resultado['data']
    ]);
} catch (Exception $e) {
    echo json_encode([
        "error" => "SI",
        "message" => $e->getMessage()
    ]);
}
