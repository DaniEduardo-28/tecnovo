<?php

require_once "core/models/ClassOrdenGasto.php";

try {
    // Parámetros para la paginación y búsqueda
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"]) : 6;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"]) >= 0 ? intval($_POST["offset"]) : 0;
    $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";
    $id_documento = isset($_POST["id_documento"]) ? $_POST["id_documento"] : "";

    // Verificación de permisos de búsqueda
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordengasto"));
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_buscar'] == false) {
            throw new Exception("No tienes permisos para realizar búsquedas.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    // Obtener el conteo total de registros
    $DataCantidad = $OBJ_ORDEN_GASTO->getCount("all", $id_documento, $valor);

    if ($DataCantidad["error"] == "NO") {
        $cantidad = $DataCantidad["data"][0]["cantidad"];

        // Obtener los registros de órdenes de gasto
        $Resultado = $OBJ_ORDEN_GASTO->show("all", $id_documento, $valor, $offset, $limit);

        if ($Resultado["error"] == "NO") {
            $retorno_array = [];
            foreach ($Resultado["data"] as $key) {
                $estado = ($key['estado'] == "activo") ? '<span class="badge badge-success-inverse px-2 py-1 mt-1">Activo</span>' : '<span class="badge badge-danger-inverse px-2 py-1 mt-1">Inactivo</span>';

                $options = "";
                if ($access_options[0]['flag_editar']) {
                    $options .= '<a href="javascript:getDataEdit(' . $key['id_orden_gasto'] . ')" class="btn btn-icon btn-outline-warning btn-round mr-0 mb-1 mb-sm-0"><i class="ti ti-pencil"></i></a>';
                }
                if ($access_options[0]['flag_eliminar']) {
                    $options .= '&nbsp;&nbsp;<a href="javascript:deleteRegistro(' . $key['id_orden_gasto'] . ", '" . str_replace('"', ' ', str_replace("'", ' ', $key['serie'])) . " - " . str_replace('"', ' ', str_replace("'", ' ', $key['correlativo'])) . "'" . ')" class="btn btn-icon btn-outline-danger btn-round mr-0 mb-1 mb-sm-0"><i class="ti ti-close"></i></a>';
                }

                // Añadir datos al array de retorno
                $retorno_array[] = array(
                    "num" => $offset + count($retorno_array) + 1,
                    "id_orden_gasto" => $key['id_orden_gasto'],
                    "id_documento" => $key['id_documento'],
                    "name_documento" => $key['name_documento'],
                    "serie" => $key['serie'],
                    "correlativo" => $key['correlativo'],
                    "nombre_proveedor" => $key['nombre_proveedor'],
                    "fecha_gasto" => $key['fecha_gasto'],
                    "estado" => $estado,
                    "options" => $options
                );
            }

            $data["error"] = "NO";
            $data["message"] = "Success";
            $data["cantidad"] = $cantidad;
            $data["data"] = $retorno_array;
            echo json_encode($data);

        } else {
            throw new Exception($Resultado["message"]);
        }

    } else {
        throw new Exception($DataCantidad["message"]);
    }

} catch (Exception $e) {
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
}

?>
