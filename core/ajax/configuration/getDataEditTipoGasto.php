<?php

try {
    $id_tipo_gasto = isset($_POST["id_tipo_gasto"]) ? $_POST["id_tipo_gasto"] : "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("tipogasto"));

    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_editar'] == false) {
            throw new Exception("No tienes permisos para editar este registro.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    if (empty($id_tipo_gasto)) {
        throw new Exception("No se recibió el parámetro id_tipo_gasto.");
    }

    require_once "core/models/ClassTipoGasto.php";
    $Resultado = $OBJ_TIPO_GASTO->getDataEditTipoGasto($id_tipo_gasto);

    if ($Resultado["error"] == "NO") {
        foreach ($Resultado["data"] as $key) {
            $retorno_array[] = array(
                "id_tipo_gasto" => $key['id_tipo_gasto'],
                "desc_gasto" => $key['desc_gasto'],
                "estado" => $key['estado'],
                "id_tipo_servicio" => isset($key['id_tipo_servicio']) ? $key['id_tipo_servicio'] : null,
                "name_tipo" => isset($key['name_tipo']) ? $key['name_tipo'] : "Ninguno"
            );
        }

        $data = array(
            "error" => "NO",
            "message" => "Success",
            "data" => $retorno_array
        );
        echo json_encode($data);

    } else {
        throw new Exception($Resultado["message"]);
    }

} catch (Exception $e) {
    $data = array(
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null
    );
    echo json_encode($data);
    exit();
}

?>
