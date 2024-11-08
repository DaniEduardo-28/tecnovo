<?php

$id_venta = isset($_POST["id_venta"]) ? $_POST["id_venta"] : 0;

try {
    // Validación de permisos
    if (!isset($_SESSION['id_grupo']) || empty(printCodeOption("ordenventa"))) {
        throw new Exception("Error en la sesión o en el código de opción.");
    }

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordenventa"));

    if ($access_options[0]['error'] == "NO") {
        if (!$access_options[0]['flag_eliminar']) {
            throw new Exception("No tienes permiso para eliminar este registro.");
        }
    } else {
        throw new Exception("Error al validar los permisos.");
    }

    // Validación de la entrada id_venta
    if (empty($id_venta)) {
        throw new Exception("No se recibió el campo id orden.");
    }

    require_once "core/models/ClassOrdenVenta.php";
    $VD = $OBJ_ORDEN_VENTA->delete($id_venta);

    // Validación de la respuesta de la clase
    if ($VD != "OK") {
        throw new Exception($VD);
    }

    // Respuesta exitosa
    responderJson("NO", "Registro eliminado correctamente.", null);

} catch (Exception $e) {
    responderJson("SI", $e->getMessage(), null);
}

/**
 * Función auxiliar para construir respuestas JSON.
 *
 * @param string $error Indicador de error ("SI" o "NO").
 * @param string $message Mensaje a incluir en la respuesta.
 * @param mixed $data Datos adicionales (null si no hay datos).
 */
function responderJson($error, $message, $data) {
    echo json_encode([
        "error" => $error,
        "message" => $message,
        "data" => $data
    ]);
    exit();
}

?>
