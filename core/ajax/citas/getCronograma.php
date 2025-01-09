<?php

require_once "core/models/ClassCronograma.php";

header('Content-Type: application/json');

$OBJ_CRONOGRAMA = new ClassCronograma();

$id_cronograma = isset($_POST['id_cronograma']) ? $_POST['id_cronograma'] : null;

    if (empty($id_cronograma)) {
        echo json_encode([
            "error" => "SI",
            "message" => "No se recibió´el ID del cronograma."
        ]);
        exit;
    }

    $resultado = $OBJ_CRONOGRAMA->getCronogramaById($id_cronograma);

    if ($resultado['error'] === "SI") {
        echo json_encode([
            "error" => "SI",
            "message" => $resultado['message']
        ]);
    } else {
    echo json_encode([
        "error" => "NO",
        "message" => "Cronograma encontrado.",
        "data" => $resultado['data']
    ]);
}
