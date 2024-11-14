<?php

try {
    // Obtener parámetros para la paginación y filtrado
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"]) : 6;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"]) >= 0 ? intval($_POST["offset"]) : 0;
    $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";
    $id_operador = isset($_POST["id_operador"]) ? $_POST["id_operador"] : "";

    // Verificación de permisos
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("maquinaria"));

    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_buscar'] == false) {
            throw new Exception("No tienes permisos para realizar búsquedas.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    // Importar la clase y obtener la cantidad de registros y los datos
    require_once "core/models/ClassMaquinaria.php";
    $DataCantidad = $OBJ_MAQUINARIA->getCount("all", $id_operador, $valor);

    // Verificar que $DataCantidad contiene datos
if ($DataCantidad["error"] == "NO" && isset($DataCantidad["data"][0]["cantidad"])) {
    $cantidad = $DataCantidad["data"][0]["cantidad"];
    
    // Verificar que $Resultado contiene datos antes de iterar
    $Resultado = $OBJ_MAQUINARIA->show("all", $id_operador, $valor, $offset, $limit);
    $retorno_array = [];
    $count = $offset + 1; // Ajuste para paginación

    if (isset($Resultado["data"]) && is_array($Resultado["data"])) {
        foreach ($Resultado["data"] as $key) {
            $estado = ($key['estado'] == "activo") 
                ? '<td><a href="javascript:void(0)" class="dot bg-success"></a><span>Activo</span></td>'
                : '<td><a href="javascript:void(0)" class="dot bg-danger"></a><span>Inactivo</span></td>';
            
            $options = '';
            if ($access_options[0]['flag_editar']) {
                $options .= '<a href="javascript:editData(' . $key['id_maquinaria'] . ')" class="btn btn-icon btn-outline-primary btn-round mr-2 mb-2 mb-sm-0"><i class="ti ti-pencil"></i></a>';
            }
            if ($access_options[0]['flag_eliminar']) {
                $options .= '<a href="javascript:deleteRegistro(' . $key['id_maquinaria'] . ", '" . str_replace('"', ' ', str_replace("'", ' ', $key['descripcion'])) . "'" . ')" class="btn btn-icon btn-outline-danger btn-round"><i class="ti ti-close"></i></a>';
            }

            $retorno_array[] = array(
                "num" => "$count",
                "id_maquinaria" => $key['id_maquinaria'],
                "descripcion" => $key['descripcion'],
                "observaciones" => $key['observaciones'],
                "nombre_operador" => $key['nombre_operador'],
                "estado" => $estado,
                "options" => "$options"
            );
            $count++;
        }
    } else {
        // Si no hay datos, inicializamos $retorno_array como vacío
        $retorno_array = [];
    }

    // Respuesta en caso de éxito
    $data = array(
        "error" => "NO",
        "message" => "Success",
        "cantidad" => $cantidad,
        "data" => $retorno_array
    );
    echo json_encode($data);

} else {
    throw new Exception(isset($DataCantidad["message"]) ? $DataCantidad["message"] : "Error al obtener la cantidad de registros.");
}


} catch (Exception $e) {
    // Respuesta en caso de error
    $data = array(
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null
    );
    echo json_encode($data);
    exit();
}

?>
