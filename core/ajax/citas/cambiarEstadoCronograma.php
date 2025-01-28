<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "core/models/ClassCronograma.php";

header('Content-Type: application/json; charset=utf-8');

$OBJ_CRONOGRAMA = new ClassCronograma();

try {
    // Obtener los datos enviados
    $data = json_decode(file_get_contents("php://input"), true);
    $id_cronograma = isset($data['id_cronograma']) ? $data['id_cronograma'] : null;
    $nuevo_estado = isset($data['estado']) ? $data['estado'] : null;
    $cantidad_restante_actualizada = isset($data['cantidad_restante']) ? $data['cantidad_restante'] : null; // Nuevo parámetro

    // Verificar que el estado sea válido
    $estados_validos = ['EN PROCESO', 'TERMINADO', 'ANULADO', 'REGISTRADO', 'APROBADO'];
    if (!in_array($nuevo_estado, $estados_validos)) {
        throw new Exception("Estado inválido.");
    }

    // Actualizar el estado en la base de datos
    $resultado = $OBJ_CRONOGRAMA->actualizarEstadoCronograma($id_cronograma, $nuevo_estado, $cantidad_restante_actualizada);

    if ($resultado !== "OK") {
        throw new Exception($resultado);
    }

    echo json_encode(["error" => "NO", "message" => "Estado actualizado con éxito."], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode(["error" => "SI", "message" => $e->getMessage()]);
}
