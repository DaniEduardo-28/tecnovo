<?php

// Verificar si se recibió el id_maquinaria
$id_maquinaria = isset($_POST["id_maquinaria"]) ? $_POST["id_maquinaria"] : "";

try {
    // Verificar permisos de eliminación
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("maquinaria"));
    
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_eliminar'] == false) {
            throw new Exception("No tienes permiso para eliminar.");
        }
    } else {
        throw new Exception("Error al validar los permisos.");
    }

    // Validar que el ID de maquinaria no esté vacío
    if (empty($id_maquinaria)) {
        throw new Exception("No se recibió el campo id_maquinaria.");
    }

    // Importar la clase y llamar a la función de eliminación
    require_once "core/models/ClassMaquinaria.php";
    $VD = $OBJ_MAQUINARIA->delete($id_maquinaria);

    // Verificar el resultado de la operación
    if ($VD != "OK") {
        throw new Exception($VD);
    }

    // Respuesta en caso de éxito
    $data = array(
        "error" => "NO",
        "message" => "Registro eliminado correctamente.",
        "data" => null
    );
    echo json_encode($data);

} catch (Exception $e) {
    // Respuesta en caso de error
    $data = array(
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null
    );
    echo json_encode($data);
    exit();
}

?>
