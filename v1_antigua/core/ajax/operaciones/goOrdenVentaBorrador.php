<?php

$id_venta = $_POST["id_venta"] ?? null;
$accion = $_POST["accion"] ?? "";
$codigo_documento_venta = $_POST["codigo_documento_venta"] ?? null;
$serie = $_POST["serie"] ?? null;
$correlativo = $_POST["correlativo"] ?? null;
$codigo_documento_proveedor = $_POST["codigo_documento_proveedor"] ?? null;
$numero_documento_proveedor = $_POST["numero_documento_proveedor"] ?? null;
$nombres = $_POST["nombres"] ?? null;
$apellidos = $_POST["apellidos"] ?? null;
$direccion = $_POST["direccion"] ?? null;
$telefono = $_POST["telefono"] ?? null;
$correo = $_POST["correo"] ?? null;
$fecha = $_POST["fecha"] ?? null;
$codigo_moneda = $_POST["codigo_moneda"] ?? null;
$codigo_forma_pago = $_POST["codigo_forma_pago"] ?? null;
$total_descuento = $_POST["total_descuento"] ?? null;
$total_gravada = $_POST["total_gravada"] ?? null;
$total_igv = $_POST["total_igv"] ?? null;
$total_total = $_POST["total_total"] ?? null;
$array_detalle = $_POST["array_detalle"] ?? null;
$detalle_venta = json_decode($array_detalle);
$id_trabajador = $_SESSION["id_trabajador"] ?? 0;
$id_fundo = $_SESSION["id_fundo"] ?? 0;
$monto_recibido = $_POST["monto_recibido"] ?? 0;
$vuelto = $_POST["vuelto"] ?? 0;

try {
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordenventa"));

    if ($access_options[0]['error'] == "NO") {
        if (($accion == 'add' && !$access_options[0]['flag_agregar']) || 
            ($accion == 'edit' && !$access_options[0]['flag_editar'])) {
            throw new Exception("No tienes permisos para realizar esta acción.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    validateRequiredFields([
        "codigo_documento_venta" => $codigo_documento_venta,
        "codigo_documento_proveedor" => $codigo_documento_proveedor,
        "numero_documento_proveedor" => $numero_documento_proveedor,
        "nombres" => $nombres,
        "codigo_moneda" => $codigo_moneda,
        "codigo_forma_pago" => $codigo_forma_pago
    ]);

    if ($array_detalle === null || empty($detalle_venta->datos)) {
        throw new Exception("No se recibieron los detalles de la orden.");
    }

    require_once "core/models/ClassDocumentoIdentidad.php";
    $resultDoc1 = $OBJ_DOCUMENTO_IDENTIDAD->getDocumentoForId($codigo_documento_proveedor);

    if ($resultDoc1['error'] == "SI") {
        throw new Exception($resultDoc1['message']);
    }

    $dataResultDoc1 = $resultDoc1['data'];
    validateDocument($numero_documento_proveedor, $dataResultDoc1);

    if (strtoupper($dataResultDoc1[0]['name_documento']) == "RUC" && empty(trim($direccion))) {
        throw new Exception("Campo obligatorio: Dirección del proveedor para RUC.");
    }

    require_once "core/models/ClassOrdenVenta.php";
    require_once "core/models/ClassMoneda.php";
    $tipo_cambio = $OBJ_MONEDA->getTipoCambio($codigo_moneda);

    switch ($accion) {
        case 'add':
            $VD = $OBJ_ORDEN_VENTA->insert($id_venta, $codigo_documento_venta, $serie, $correlativo, $codigo_documento_proveedor, $numero_documento_proveedor, $nombres, $apellidos, $direccion, $telefono, $correo, $fecha, $codigo_moneda, $codigo_forma_pago, $total_descuento, $total_gravada, $total_igv, $total_total, $detalle_venta, $id_trabajador, $id_fundo, $monto_recibido, $vuelto, $tipo_cambio);
            break;
        case 'edit':
            $VD = $OBJ_ORDEN_VENTA->update($id_venta, $codigo_documento_venta, $serie, $correlativo, $codigo_documento_proveedor, $numero_documento_proveedor, $nombres, $apellidos, $direccion, $telefono, $correo, $fecha, $codigo_moneda, $codigo_forma_pago, $total_descuento, $total_gravada, $total_igv, $total_total, $detalle_venta, $id_trabajador, $id_fundo, $monto_recibido, $vuelto, $tipo_cambio);
            break;
        default:
            throw new Exception("Acción no válida.");
    }

    if ($VD['error'] == "SI") {
        throw new Exception($VD['message']);
    }

    responderJson("NO", $VD['message'], [
        "id_venta" => $VD['id_venta'],
        "serie" => $VD['serie'],
        "correlativo" => $VD['correlativo']
    ]);

} catch (Exception $e) {
    responderJson("SI", $e->getMessage(), null);
}

/**
 * Función para validar campos requeridos.
 */
function validateRequiredFields($fields) {
    foreach ($fields as $field => $value) {
        if (empty(trim($value))) {
            throw new Exception("Campo obligatorio: $field.");
        }
    }
}

/**
 * Función para validar el documento de identidad del proveedor.
 */
function validateDocument($documento, $data) {
    if ($data[0]['flag_exacto'] == "1" && strlen($documento) != $data[0]['size']) {
        throw new Exception("El número de documento de identidad debe tener exactamente {$data[0]['size']} dígitos.");
    } elseif ($data[0]['flag_exacto'] != "1" && strlen($documento) > $data[0]['size']) {
        throw new Exception("El documento de identidad debe tener un máximo de {$data[0]['size']} dígitos.");
    }

    if ($data[0]['flag_numerico'] == "1" && !ctype_digit($documento)) {
        throw new Exception("El documento de identidad debe contener solo números.");
    }
}

/**
 * Función auxiliar para construir respuestas JSON.
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
