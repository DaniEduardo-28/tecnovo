<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json'); // Asegúrate de que siempre devuelva JSON

require_once "core/models/ClassMaquinaria.php";

try {
    // Verificar permisos si es necesario (opcional)
    // Si estás manejando permisos, descomenta este bloque:
    
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("maquinaria"));
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_ver'] == false) {
            throw new Exception("No tienes permisos para ver las maquinarias.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }
   

    // Obtener las maquinarias activas
    $resultado = $OBJ_MAQUINARIA->getMaquinariasActivas();

    if ($resultado["error"] == "NO") {
        $retorno_array = [];

        foreach ($resultado["data"] as $maquinaria) {
            $retorno_array[] = [
                "id_maquinaria" => $maquinaria['id_maquinaria'],
                "descripcion" => htmlspecialchars($maquinaria['descripcion'], ENT_QUOTES, 'UTF-8')
            ];
        }

        $data["error"] = "NO";
        $data["message"] = "Success";
        $data["data"] = $retorno_array;

    } else {
        throw new Exception($resultado["message"]);
    }

} catch (Exception $e) {
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
}

echo json_encode($data);
?>
