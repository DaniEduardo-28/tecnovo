<?php
try {
    // Captura y sanitiza los datos del formulario
    $id_documento = isset($_POST["id_documento"]) ? $_POST["id_documento"] : null;
    $id_documento_venta = isset($_POST["id_documento_venta"]) ? $_POST["id_documento_venta"] : null;
    $id_moneda = isset($_POST["id_moneda"]) ? $_POST["id_moneda"] : null;
    $id_proveedor = isset($_POST["id_proveedor"]) ? $_POST["id_proveedor"] : null;
    $id_gasto = isset($_POST["id_gasto"]) ? $_POST["id_gasto"] : null;
    $id_servicio = isset($_POST["id_servicio"]) ? $_POST["id_servicio"] : null;
    $serie = isset($_POST["serie"]) ? $_POST["serie"] : '';
    $correlativo = isset($_POST["correlativo"]) ? $_POST["correlativo"] : '';
    $fecha_gasto = isset($_POST["fecha_gasto"]) ? $_POST["fecha_gasto"] : null;

    // Validación de permisos
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordengasto"));
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_agregar'] == false) {
            throw new Exception("No tienes permisos para agregar una nueva orden de gasto.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    // Verificación de campos obligatorios
    if (empty($id_documento) || empty($id_documento_venta) || empty($id_moneda) || empty($id_proveedor) || empty($fecha_gasto)) {
        throw new Exception("Todos los campos obligatorios deben ser completados.");
    }

    // Datos para insertar en `tb_orden_gasto`
    $data = [
        "id_documento" => $id_documento,
        "id_documento_venta" => $id_documento_venta,
        "id_moneda" => $id_moneda,
        "id_proveedor" => $id_proveedor,
        "id_gasto" => $id_gasto,
        "id_servicio" => $id_servicio,
        "serie" => $serie,
        "correlativo" => $correlativo,
        "fecha_gasto" => $fecha_gasto
    ];

    // Incluir el modelo y crear la orden de gasto
    require_once "core/models/ClassOrdenGasto.php";
    $resultado = $OBJ_ORDEN_GASTO->insert($data);

    // Verificar el resultado de la inserción
    if ($resultado["error"] == "NO") {
        $response["error"] = "NO";
        $response["message"] = "Orden de gasto registrada exitosamente.";
        $response["data"] = $resultado;
        echo json_encode($response);
    } else {
        throw new Exception($resultado["message"]);
    }

} catch (Exception $e) {
    // Manejo de errores con mensaje en formato JSON
    $response["error"] = "SI";
    $response["message"] = $e->getMessage();
    $response["data"] = null;
    echo json_encode($response);
    exit();
}
?>
