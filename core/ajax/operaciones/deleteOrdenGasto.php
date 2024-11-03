<?php

require_once "core/models/ClassOrdenGasto.php";

$id_orden_gasto = isset($_POST["id_orden_gasto"]) ? $_POST["id_orden_gasto"] : "";

try {
    // Verificación de permisos de eliminación
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordengasto"));
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_eliminar'] == false) {
            throw new Exception("No tienes permiso para eliminar esta orden de gasto.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    // Validación del parámetro `id_orden_gasto`
    if (empty($id_orden_gasto)) {
        throw new Exception("No se recibió el campo id_orden_gasto.");
    }

    // Llamada al modelo para eliminar la orden de gasto
    $VD = $OBJ_ORDEN_GASTO->delete($id_orden_gasto);

    if ($VD != "OK") {
        throw new Exception($VD);
    }

    // Respuesta de éxito en formato JSON
    $data["error"] = "NO";
    $data["message"] = "Registro eliminado correctamente.";
    $data["data"] = null;
    echo json_encode($data);

} catch (Exception $e) {
    // Respuesta de error en formato JSON
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
}

?>
