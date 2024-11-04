<?php
try {
    // Obtiene los valores para la paginación y filtros
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"]) : 10;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"]) >= 0 ? intval($_POST["offset"]) : 0;
    $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";
    $fecha_inicio = isset($_POST["fecha_inicio"]) ? $_POST["fecha_inicio"] : "";
    $fecha_fin = isset($_POST["fecha_fin"]) ? $_POST["fecha_fin"] : "";
    $tipo_busqueda = isset($_POST["tipo_busqueda"]) ? $_POST["tipo_busqueda"] : "";
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";

    // Verificación de permisos de usuario
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordengasto"));
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_buscar'] == false) {
            throw new Exception("No tienes permisos para realizar búsquedas.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    // Incluir el modelo y obtener el conteo de resultados
    require_once "core/models/ClassOrdenGasto.php";
    $DataCantidad = $OBJ_ORDEN_GASTO->getCount($valor, $fecha_inicio, $fecha_fin, $tipo_busqueda);

    if ($DataCantidad["error"] == "NO") {
        $cantidad = $DataCantidad["data"][0]["cantidad"];
        $Resultado = $OBJ_ORDEN_GASTO->show($valor, $fecha_inicio, $fecha_fin, $tipo_busqueda, $offset, $limit);

        $retorno_array = [];
        $count = 1;
        
        foreach ($Resultado["data"] as $key) {
            $options = '';

            // Botón de ver
            if ($access_options[0]['flag_ver']) {
                $options .= '<a href="javascript:verRegistro(' . $key['id_orden_gasto'] . ')" class="btn btn-icon btn-outline-primary btn-round mr-0 mb-1 mb-sm-0"><i class="ti ti-eye"></i></a>';
            }

            // Opciones adicionales si no es reporte
            if ($tipo != 'reporte') {
                if ($key['estado'] == "0") {
                    // Botón de editar
                    if ($access_options[0]['flag_editar']) {
                        $options .= '&nbsp;<a href="javascript:getDataEdit(' . $key['id_orden_gasto'] . ')" class="btn btn-icon btn-outline-warning btn-round mr-0 mb-1 mb-sm-0"><i class="ti ti-pencil"></i></a>';
                    }
                    // Botón de eliminar
                    if ($access_options[0]['flag_anular']) {
                        $options .= '&nbsp;<a href="javascript:deleteRegistro(' . $key['id_orden_gasto'] . ')" class="btn btn-icon btn-outline-danger btn-round mr-0 mb-1 mb-sm-0"><i class="ti ti-na"></i></a>';
                    }
                }
            }

            // Botón de impresión
            if ($access_options[0]['flag_ver']) {
                $options .= '<a href="?view=printordengasto&id_orden_gasto=' . $key['id_orden_gasto'] . '" class="btn btn-icon btn-outline-info btn-round mr-0 mb-1 mb-sm-0" target="_blank"><i class="ti ti-printer"></i></a>';
            }

            // Preparar cada registro para la salida
            $retorno_array[] = [
                "num" => $count + $offset,
                "id_orden_gasto" => $key['id_orden_gasto'],
                "nombre_proveedor" => $key['nombre_proveedor'],
                "name_usuario" => $key['nombres_trabajador'],
                "fecha_gasto" => date('d/m/Y H:i', strtotime($key['fecha_gasto'])),
                "num_registros" => '&nbsp;&nbsp;&nbsp;' . $key['num_registros'],
                "total" => $key['signo_moneda'] . ' ' . $key['total'],
                "options" => $options
            ];
            $count++;
        }

        // Respuesta de éxito en formato JSON
        $data["error"] = "NO";
        $data["message"] = "Success";
        $data["cantidad"] = $cantidad;
        $data["data"] = $retorno_array;
        echo json_encode($data);

    } else {
        throw new Exception($DataCantidad["message"]);
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
