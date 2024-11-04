<?php
try {
    // Obtiene el ID de la orden de gasto desde la solicitud POST
    $id_orden_gasto = isset($_POST["id_orden_gasto"]) ? $_POST["id_orden_gasto"] : "";

    // Verifica los permisos del usuario para editar el registro
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordengasto"));

    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_editar'] == false) {
            throw new Exception("No tienes permisos para editar este registro.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    // Valida que el ID de la orden de gasto no esté vacío
    if ($id_orden_gasto == "") {
        throw new Exception("No se recibió el parámetro id orden.");
    }

    // Incluye la clase de modelo y crea una instancia para obtener los datos
    require_once "core/models/ClassOrdenGasto.php";
    $Resultado = $OBJ_ORDEN_GASTO->getDataEditOrdenGasto($id_orden_gasto);

    // Verifica si la consulta fue exitosa
    if ($Resultado["error"] == "NO") {
        $retorno_array = [];

        // Recorre los resultados y los agrega al array de retorno
        foreach ($Resultado["data"] as $key) {
            $retorno_array[] = array(
                "id_orden_gasto" => $key['id_orden_gasto'],
                "id_documento" => $key['id_documento'],
                "id_documento_venta" => $key['id_documento_venta'],
                "id_moneda" => $key['id_moneda'],
                "id_proveedor" => $key['id_proveedor'],
                "serie" => $key['serie'],
                "correlativo" => $key['correlativo'],
                "fecha_gasto" => date('Y-m-d', strtotime($key['fecha_gasto'])),
                "id_gasto" => $key['id_gasto'],
                "id_servicio" => $key['id_servicio'],
                "observaciones" => $key['observaciones'],
                "subtotal" => $key['subtotal'],
                "total" => $key['total']
            );
        }

        // Respuesta de éxito en formato JSON
        $data["error"] = "NO";
        $data["message"] = "Success";
        $data["data"] = $retorno_array;
        echo json_encode($data);

    } else {
        // Lanza una excepción si ocurre un error en la consulta
        throw new Exception($Resultado["message"]);
    }

} catch (Exception $e) {
    // Manejo de errores con mensaje en formato JSON
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
}
?>
