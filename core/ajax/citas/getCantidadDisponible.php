<?php

require_once "core/models/ClassCronograma.php";

header('Content-Type: application/json');

$OBJ_CRONOGRAMA = new ClassCronograma();

$id_cronograma = isset($_POST['id_cronograma']) ? $_POST['id_cronograma'] : null;
$cantidad_restante_actualizada = isset($_POST['cantidad_restante']) ? $_POST['cantidad_restante'] : null;

if (empty($id_cronograma)) {
    echo json_encode([
        "error" => "SI",
        "message" => "No se recibió el ID del cronograma."
    ]);
    exit;
}

if (!is_null($cantidad_restante_actualizada)) {
    $actualizar = $OBJ_CRONOGRAMA->actualizarCantidadRestante($id_cronograma, $cantidad_restante_actualizada);
    
    if ($actualizar !== "OK") {
        echo json_encode([
            "error" => "SI",
            "message" => "Error al actualizar la cantidad restante: " . $actualizar
        ]);
        exit;
    }
}

try {
    $conexionClass = new Conexion();
    $conexion = $conexionClass->Open();

    $sql = "SELECT cantidad_restante FROM tb_cronograma WHERE id_cronograma = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $id_cronograma, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo json_encode([
            "error" => "SI",
            "message" => "No se encontró el cronograma."
        ]);
        exit;
    }

    $cantidad_restante = floatval($data["cantidad_restante"]);

    echo json_encode([
        "error" => "NO",
        "message" => "Cantidad disponible obtenida.",
        "cantidad" => $cantidad_restante
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "error" => "SI",
        "message" => "Error en la consulta: " . $e->getMessage()
    ]);
}
