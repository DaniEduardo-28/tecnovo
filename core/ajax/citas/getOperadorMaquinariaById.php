<?php

$id_cronograma = $_POST['id_cronograma'] ?? 0;

try {
    if (empty($id_cronograma)) {
        throw new Exception("El ID del cronograma es obligatorio.");
    }

    require_once "core/models/ClassCronograma.php";

    $result = $OBJ_CRONOGRAMA->getOperadorYMaquinariaById($id_cronograma);

    if ($result['error'] === "SI") {
        throw new Exception($result['message']);
    }

    $data = [
        "error" => "NO",
        "message" => "Datos encontrados correctamente.",
        "data" => [
            "operador" => $result['operador'],
            "maquinaria" => $result['maquinaria']
        ]
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
