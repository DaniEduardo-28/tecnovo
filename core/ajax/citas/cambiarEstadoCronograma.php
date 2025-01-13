<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "core/models/ClassCronograma.php";

header('Content-Type: application/json; charset=utf-8');

$OBJ_CRONOGRAMA = new ClassCronograma();

try {
    // Obtener los datos enviados
    $data = json_decode(file_get_contents("php://input"), true);
    $id_cronograma = $data['id_cronograma'];
    $nuevo_estado = $data['estado'];

    // Verificar que el estado sea válido
    $estados_validos = ['PENDIENTE', 'EN PROCESO', 'TERMINADO', 'ANULADO', 'REGISTRADO', 'APROBADO'];
    if (!in_array($nuevo_estado, $estados_validos)) {
        throw new Exception("Estado inválido.");
    }

    // Actualizar el estado en la base de datos
    $resultado = $OBJ_CRONOGRAMA->actualizarEstadoCronograma($id_cronograma, $nuevo_estado);

    if ($resultado != "OK") {
        throw new Exception($resultado);
    }

    echo json_encode(["error" => "NO", "message" => "Estado actualizado con éxito."], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode(["error" => "SI", "message" => $e->getMessage()]);
}
