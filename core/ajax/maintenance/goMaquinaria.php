<?php

$id_maquinaria = isset($_POST["id_maquinaria"]) ? $_POST["id_maquinaria"] : "";
$estado = isset($_POST["estado"]) ? 1 : 0;
$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
$observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : "";
$id_trabajador = isset($_POST["id_trabajador"]) && $_POST["id_trabajador"] != "" ? $_POST["id_trabajador"] : null; // Permitir NULL si no se selecciona operador
$accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

try {
    // Verificar permisos de acuerdo a la acción
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("maquinaria"));

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


    if (empty(trim($descripcion))) {
        throw new Exception("Campo Obligatorio: Nombre de Maquinaria.");
    }

    // Importar la clase de maquinaria y realizar la operación correspondiente
    require_once "core/models/ClassMaquinaria.php";
    $VD = "";

    switch ($accion) {
        case 'add':
            error_log("Creando nuevo registro"); // Log temporal para agregar
            $VD = $OBJ_MAQUINARIA->insert($id_maquinaria, $descripcion, $observaciones, $estado, $id_trabajador); // Cambiado argumento
            break;
        case 'edit':
            // Validar que se esté recibiendo un id_maquinaria válido para editar
            if (empty(trim($id_maquinaria))) {
                throw new Exception("ID de maquinaria no recibido para la edición.");
            }
            error_log("Actualizando registro con ID: $id_maquinaria"); // Log temporal para editar
            $VD = $OBJ_MAQUINARIA->update($id_maquinaria, $descripcion, $observaciones, $estado, $id_trabajador); // Cambiado argumento
            break;
        default:
            throw new Exception("Operación no válida.");
            break;
    }

    // Manejo de respuesta en caso de éxito o error en la operación
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
    // Estructura de respuesta en caso de error
    $data = array(
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null
    );
    echo json_encode($data);
}

?>
