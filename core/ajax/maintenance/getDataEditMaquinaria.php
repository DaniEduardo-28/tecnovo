<?php

try {
    // Verificar si el parámetro id_maquinaria fue proporcionado
    $id_maquinaria = isset($_POST["id_maquinaria"]) ? $_POST["id_maquinaria"] : "";

    // Verificar permisos de edición
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("maquinaria"));

    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_editar'] == false) {
            throw new Exception("No tienes permisos para editar este registro.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    // Validar que el ID de maquinaria no esté vacío
    if (empty($id_maquinaria)) {
        throw new Exception("No se recibió el parámetro id_maquinaria.");
    }

    // Importar la clase y obtener los datos del registro a editar
    require_once "core/models/ClassMaquinaria.php";
    $Resultado = $OBJ_MAQUINARIA->getDataEditMaquinaria($id_maquinaria);

    if ($Resultado["error"] == "NO") {
        // Formatear los datos para enviarlos al frontend en un arreglo JSON
        foreach ($Resultado["data"] as $key) {
            $retorno_array[] = array(
                "id_maquinaria" => $key['id_maquinaria'],
                "descripcion" => $key['descripcion'],
                "observaciones" => $key['observaciones'],
                "estado" => $key['estado'],
                // Manejo de NULL para id_trabajador y nombre_operador
                "id_trabajador" => isset($key['id_trabajador']) ? $key['id_trabajador'] : null,
                "nombre_operador" => isset($key['nombre_operador']) ? $key['nombre_operador'] : "Sin operador asignado"
            );
        }

        // Estructura de respuesta en JSON para el éxito
        $data = array(
            "error" => "NO",
            "message" => "Success",
            "data" => $retorno_array
        );
        echo json_encode($data);

    } else {
        // Si hay un error en la obtención de datos
        throw new Exception($Resultado["message"]);
    }

} catch (Exception $e) {
    // Estructura de respuesta en caso de error
    $data = array(
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null
    );
    echo json_encode($data);
    exit();
}

?>
