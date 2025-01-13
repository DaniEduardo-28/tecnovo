<?php
error_log("Entrando a eliminarCronograma.php con ID: " . $_POST['id_cronograma']);


// Obtener el ID del cronograma desde la petición POST
$id_cronograma = isset($_POST["id_cronograma"]) ? $_POST["id_cronograma"] : "";

try {
    // Validar que el ID sea numérico y mayor a 0
    if (empty($id_cronograma) || !is_numeric($id_cronograma) || $id_cronograma <= 0) {
        throw new Exception("ID de cronograma no especificado o no válido.");
    }

    // Incluir el modelo ClassCronograma
    require_once "core/models/ClassCronograma.php";

    // Log para depuración
    error_log("Intentando eliminar cronograma con ID: " . $id_cronograma);

    // Llamar a la función eliminarCronograma del modelo
    $Resultado = $OBJ_CRONOGRAMA->eliminarCronograma($id_cronograma);

    // Verificar el resultado de la eliminación
    if ($Resultado !== "OK") {
        throw new Exception("Error al eliminar el cronograma: $Resultado");
    }

    // Respuesta exitosa
    $data = array(
        "error" => "NO",
        "message" => "Registro eliminado correctamente.",
        "data" => null
    );
    echo json_encode($data);

} catch (Exception $e) {
    // Respuesta de error con el mensaje capturado
    $data = array(
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null
    );
    echo json_encode($data);

    // Log del error para depuración
    error_log("Error en eliminarCronograma.php: " . $e->getMessage());

    exit();
}
