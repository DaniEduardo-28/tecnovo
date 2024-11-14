<?php

$id_venta = isset($_POST["id_venta"]) ? $_POST["id_venta"] : 0;

try {
    // Validación de permisos
    if (!isset($_SESSION['id_grupo']) || empty(printCodeOption("ordenventa"))) {
        throw new Exception("Error en la sesión o en el código de opción.");
    }

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordenventa"));

    if ($access_options[0]['error'] == "NO") {
        if (!$access_options[0]['flag_anular']) {
            throw new Exception("No tienes permiso para anular este registro.");
        }
    } else {
        throw new Exception("Error al validar los permisos.");
    }

    // Validación de la entrada id_venta
    if (empty($id_venta)) {
        throw new Exception("No se recibió el campo id orden venta.");
    }

    require_once "core/models/ClassOrdenVenta.php";
    $VD = $OBJ_ORDEN_VENTA->anular($id_venta);

    // Validación de la respuesta de la clase
    if ($VD != "OK") {
        throw new Exception($VD);
    }

    // Respuesta exitosa
    responderJson("NO", "Registro anulado correctamente.", null);

} catch (Exception $e) {
    responderJson("SI", $e->getMessage(), null);
}

/**
 * Realiza una solicitud cURL para enviar un documento.
 *
 * @param string $ruta URL de la API.
 * @param string $token Token de autenticación.
 * @param string $data_json Datos en formato JSON.
 * @return mixed Respuesta del servidor o mensaje de error.
 */
function eviarDocumento($ruta, $token, $data_json) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ruta);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Token token="'. $token . '"',
        'Accept: application/json',
        'Content-Type: application/json',
    ));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return json_encode(["error" => "SI", "message" => $error_msg]);
    }

    curl_close($ch);
    return $respuesta;
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
