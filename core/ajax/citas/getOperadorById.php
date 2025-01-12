<?php

$id_cronograma_operador = $_POST['id_cronograma_operador'] ?? 0;

try {
    if (empty($id_cronograma_operador)) {
        throw new Exception("El ID del operador es obligatorio.");
    }

    require_once "core/models/ClassCronograma.php";
    $operador = $OBJ_CRONOGRAMA->getOperadorById($id_cronograma_operador);

    if (!$operador) {
        throw new Exception("No se encontró el operador.");
    }

    $data = [
        "error" => "NO",
        "message" => "Operador encontrado.",
        "data" => $operador
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
