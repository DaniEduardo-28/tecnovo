<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require_once 'core/models/ClassIngreso.php'; // Asegúrate de usar el modelo correcto

try {
    // Validar sesión o permisos
    session_start(); // Si no se ha iniciado antes
    if (!isset($_SESSION['id_grupo'])) {
        throw new Exception("No has iniciado sesión.");
    }

    $id_ingreso = isset($_POST['id_ingreso']) ? intval($_POST['id_ingreso']) : null;

    if (!$id_ingreso || $id_ingreso <= 0) {
        throw new Exception("ID de ingreso inválido.");
    }

    // Validar permisos de usuario
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ingreso"));
    if ($access_options[0]['error'] === "NO" && $access_options[0]['flag_agregar'] === false) {
        throw new Exception("No tienes permisos para consultar pagos.");
    }

    // Obtener pagos
    $OBJ_INGRESO = new ClassIngreso(); // Instancia del modelo
    $result = $OBJ_INGRESO->getPagos($id_ingreso);

    if ($result['error'] === "SI") {
        throw new Exception($result['message']);
    }

    // Respuesta exitosa
    $response = [
        "error" => "NO",
        "message" => "Operación realizada correctamente.",
        "data" => $result['data'], // Datos obtenidos
    ];
    echo json_encode($response);
} catch (Exception $e) {
    // Respuesta en caso de error
    $response = [
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null,
    ];
    echo json_encode($response);
}
