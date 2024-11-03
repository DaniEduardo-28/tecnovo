<?php

require_once "core/models/ClassOrdenGasto.php";

$id_orden_gasto = isset($_POST["id_orden_gasto"]) ? $_POST["id_orden_gasto"] : "";

try {
    // Verificación de permisos de edición
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordengasto"));
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_editar'] == false) {
            throw new Exception("No tienes permisos para editar esta orden de gasto.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    // Validación del parámetro `id_orden_gasto`
    if (empty($id_orden_gasto)) {
        throw new Exception("No se recibió el parámetro id_orden_gasto.");
    }

    // Llamada al modelo para obtener los datos de la orden de gasto
    $Resultado = $OBJ_ORDEN_GASTO->getDataEditOrdenGasto($id_orden_gasto);

    if ($Resultado["error"] == "NO") {
        $retorno_array = [];
        foreach ($Resultado["data"] as $key) {
            $retorno_array[] = array(
                "id_orden_gasto" => $key['id_orden_gasto'],
                "id_documento" => $key['id_documento'],
                "id_documento_venta" => $key['id_documento_venta'],
                "id_moneda" => $key['id_moneda'],
                "id_proveedor" => $key['id_proveedor'],
                "id_gasto" => $key['id_gasto'],
                "id_servicio" => $key['id_servicio'],
                "serie" => $key['serie'],
                "correlativo" => $key['correlativo'],
                "fecha_gasto" => $key['fecha_gasto'],
                "estado" => $key['estado']
            );
        }

        $data["error"] = "NO";
        $data["message"] = "Success";
        $data["data"] = $retorno_array;
        echo json_encode($data);

    } else {
        throw new Exception($Resultado["message"]);
    }

} catch (Exception $e) {
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
}

?>
