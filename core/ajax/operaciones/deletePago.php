<?php

// Verificar si se recibió el id_ingreso
$id_pago = isset($_POST["id_pago"]) ? $_POST["id_pago"] : "";

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

    // Importar la clase y llamar a la función de eliminación
    require_once "core/models/ClassIngreso.php";
    $VD = $OBJ_INGRESO->deletepago($id_pago);

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