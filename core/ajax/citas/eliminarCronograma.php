<?php

require_once "core/models/ClassCronograma.php";

$OBJ_CRONOGRAMA = new ClassCronograma();

try {
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("citas"));
    if ($access_options[0]['error'] == "NO" && !$access_options[0]['flag_eliminar']) {
        throw new Exception("No tienes permisos para eliminar.");
    }

    $id_cronograma = $_POST['id_cronograma'] ?? null;

    if (empty($id_cronograma)) {
        throw new Exception("ID de cronograma no especificado.");
    }

    $Resultado = $OBJ_CRONOGRAMA->eliminarCronograma($id_cronograma);

    if ($Resultado != "OK") {
        throw new Exception($Resultado);
    }

    echo json_encode(["error" => "NO", "message" => "Cronograma eliminado correctamente."]);
} catch (Exception $e) {
    echo json_encode(["error" => "SI", "message" => $e->getMessage()]);
}