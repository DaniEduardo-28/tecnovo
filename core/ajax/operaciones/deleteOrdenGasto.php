<?php
// Obtiene el ID de la orden de gasto desde la solicitud POST
$id_orden_gasto = isset($_POST["id_orden_gasto"]) ? $_POST["id_orden_gasto"] : "";

try {
    // Verifica los permisos del usuario para realizar la anulación
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordengasto"));

    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_anular'] == false) {
            throw new Exception("No tienes permiso para anular este registro.");
        }
    } else {
        throw new Exception("Error al validar los permisos.");
    }

    // Valida que se haya proporcionado el ID de la orden de gasto
    if (empty($id_orden_gasto)) {
        throw new Exception("No se recibió el campo id orden.");
    }

    // Incluye la clase de modelo y crea una instancia para gestionar la eliminación
    require_once "core/models/ClassOrdenGasto.php";

    // Llama al método delete para anular la orden de gasto
    $VD = $OBJ_ORDEN_GASTO->delete($id_orden_gasto);

    // Verifica si la anulación fue exitosa
    // Verifica si la anulación fue exitosa
    if ($VD['error'] != "NO") {
        throw new Exception($VD['message']); // Lanza una excepción si ocurre un error en el método delete
    }


    // Respuesta de éxito en formato JSON
    $data["error"] = "NO";
    $data["message"] = "Registro anulado correctamente.";
    $data["data"] = null;
    echo json_encode($data);
} catch (Exception $e) {
    // Manejo de errores con mensaje en formato JSON
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
}
