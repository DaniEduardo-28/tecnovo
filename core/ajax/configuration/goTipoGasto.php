<?php

$id_tipo_gasto = isset($_POST["id_tipo_gasto"]) ? $_POST["id_tipo_gasto"] : "";
$estado = isset($_POST["estado"]) ? 1 : 0;
$desc_gasto = isset($_POST["desc_gasto"]) ? $_POST["desc_gasto"] : "";
$id_tipo_servicio = isset($_POST["id_tipo_servicio"]) && $_POST["id_tipo_servicio"] != "" ? $_POST["id_tipo_servicio"] : null; // Permitir NULL si no se selecciona operador
$accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

try {
    // Verificar permisos de acuerdo a la acción
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("tipogasto"));

    if ($access_options[0]['error'] == "NO") {
        switch ($accion) {
            case 'add':
                if ($access_options[0]['flag_agregar'] == false) {
                    throw new Exception("No tienes permiso para agregar.");
                }
                break;
            case 'edit':
                if ($access_options[0]['flag_editar'] == false) {
                    throw new Exception("No tienes permiso para editar.");
                }
                break;
            default:
                throw new Exception("Acción no recibida.");
                break;
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }


  require_once "core/models/ClassTipoGasto.php";
    $VD = "";

    switch ($accion) {
        case 'add':
            error_log("Creando nuevo registro"); 
            $VD = $OBJ_TIPO_GASTO->insert($id_tipo_gasto, $desc_gasto, $estado, $id_tipo_servicio); 
            break;
        case 'edit':
            if (empty(trim($id_tipo_gasto))) {
                throw new Exception("ID de tipo gasto no recibido para la edición.");
            }
            error_log("Actualizando registro con ID: $id_tipo_gasto"); 
            $VD = $OBJ_TIPO_GASTO->update($id_tipo_gasto, $desc_gasto, $estado, $id_tipo_servicio); 
            break;
        default:
            throw new Exception("Operación no válida.");
            break;
    }

    if ($VD != "OK") {
        throw new Exception($VD);
    }

    $data = array(
        "error" => "NO",
        "message" => "Operación realizada correctamente.",
        "data" => null
    );
    echo json_encode($data);

} catch (Exception $e) {

    $data = array(
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null
    );
    echo json_encode($data);
}

?>
