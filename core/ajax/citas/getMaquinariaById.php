<?php

$id_cronograma_maquinaria = $_POST['id_cronograma_maquinaria'] ?? 0;

try {
    if (empty($id_cronograma_maquinaria)) {
        throw new Exception("El ID de la maquinaria es obligatorio.");
    }

    require_once "core/models/ClassCronograma.php";
    $maquinaria = $OBJ_CRONOGRAMA->getMaquinariaById($id_cronograma_maquinaria);

    if (!$maquinaria) {
        throw new Exception("No se encontró la maquinaria.");
    }

    $data = [
        "error" => "NO",
        "message" => "Maquinaria encontrada.",
        "data" => $maquinaria
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
