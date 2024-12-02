<?php
header('Content-Type: application/json');


try {

    $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";
    $id_trabajador = isset($_POST["id_trabajador"]) && $_POST["id_trabajador"] != "" ? $_POST["id_trabajador"] : null;

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
    $DataCantidad = $OBJ_MAQUINARIA->getCount("all", $id_trabajador, $valor);

    if ($DataCantidad["error"] == "NO") {
        $cantidad = isset($DataCantidad["data"][0]["cantidad"]) ? $DataCantidad["data"][0]["cantidad"] : 0;
        $Resultado = $OBJ_MAQUINARIA->show("all", $id_trabajador, $valor);

        $retorno_array = [];
        $count = 1;

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
                    "nombre_operador" => isset($key['nombre_operador']) && $key['nombre_operador'] != "" ? $key['nombre_operador'] : "Ninguno",
                    "estado" => $estado,
                    "options" => "$options"
                );
                $count++;
            }
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
        throw new Exception($DataCantidad["message"]);
    }

}catch (Exception $e) {
        // Envía la respuesta de error como JSON
        $data = array(
            "error" => "SI",
            "message" => $e->getMessage(),
            "data" => []
        );
        echo json_encode($data); // Enviar el error en formato JSON
        exit(); // Termina el script
    }
?>
