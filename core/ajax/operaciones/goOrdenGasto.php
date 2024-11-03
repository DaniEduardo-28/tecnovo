<?php

require_once "core/models/ClassOrdenGasto.php";

$id_orden_gasto = isset($_POST["id_orden_gasto"]) ? $_POST["id_orden_gasto"] : "";
$id_orden = isset($_POST["id_orden"]) ? $_POST["id_orden"] : "";
$id_documento = isset($_POST["id_documento"]) ? $_POST["id_documento"] : "";
$id_documento_venta = isset($_POST["id_documento_venta"]) ? $_POST["id_documento_venta"] : "";
$id_moneda = isset($_POST["id_moneda"]) ? $_POST["id_moneda"] : "";
$id_proveedor = isset($_POST["id_proveedor"]) ? $_POST["id_proveedor"] : "";
$id_gasto = isset($_POST["id_gasto"]) ? $_POST["id_gasto"] : "";
$id_servicio = isset($_POST["id_servicio"]) ? $_POST["id_servicio"] : "";
$serie = isset($_POST["serie"]) ? $_POST["serie"] : "";
$correlativo = isset($_POST["correlativo"]) ? $_POST["correlativo"] : "";
$fecha_gasto = isset($_POST["fecha_gasto"]) ? $_POST["fecha_gasto"] : "";
$accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

try {
    // Validar permisos de acceso para el usuario actual
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordengasto"));
    if ($access_options[0]['error'] == "NO") {
        if ($accion == 'add' && !$access_options[0]['flag_agregar']) {
            throw new Exception("No tienes permisos para agregar.");
        }
        if ($accion == 'edit' && !$access_options[0]['flag_editar']) {
            throw new Exception("No tienes permisos para editar.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    // Validación de campos obligatorios
    if (empty(trim($id_documento))) {
        throw new Exception("Campo obligatorio: Documento.");
    }
    if (empty(trim($id_documento_venta))) {
        throw new Exception("Campo obligatorio: Documento de Venta.");
    }
    if (empty(trim($id_proveedor))) {
        throw new Exception("Campo obligatorio: Proveedor.");
    }
    if (empty(trim($serie))) {
        throw new Exception("Campo obligatorio: Serie.");
    }
    if (empty(trim($correlativo))) {
        throw new Exception("Campo obligatorio: Correlativo.");
    }
    if (empty(trim($fecha_gasto))) {
        throw new Exception("Campo obligatorio: Fecha de Gasto.");
    }

    $VD = "";
    switch ($accion) {
        case 'add':
            // Llamada al método `insert` en ClassOrdenGasto
            $data = [
                $id_orden, $id_documento, $id_documento_venta, $id_moneda,
                $id_proveedor, $id_gasto, $id_servicio, $serie, $correlativo, $fecha_gasto
            ];
            $VD = $OBJ_ORDEN_GASTO->insert($data);
            break;

        case 'edit':
            // Llamada al método `update` en ClassOrdenGasto (a implementar si es necesario)
            // Si decides implementar el método `update`, pasamos aquí los datos correspondientes
            throw new Exception("La edición no está implementada en este momento.");
            break;

        default:
            throw new Exception("Acción no válida.");
    }

    if ($VD != "OK") {
        throw new Exception($VD);
    }

    $data["error"] = "NO";
    $data["message"] = "Operación realizada correctamente.";
    $data["data"] = null;
    echo json_encode($data);

} catch (Exception $e) {
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
}

?>
