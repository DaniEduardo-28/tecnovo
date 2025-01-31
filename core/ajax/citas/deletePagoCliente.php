<?php

$id_pago_cliente = isset($_POST["id_cronograma_pago"]) ? $_POST["id_cronograma_pago"] : 0;

try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("citas"));
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_eliminar'] == false) {
            throw new Exception("No tienes permiso para eliminar.");
        }
    } else {
        throw new Exception("Error al validar los permisos.");
    }

    require_once "core/models/ClassCronograma.php";
    $VD = $OBJ_CRONOGRAMA->deletepago($id_pago_cliente);

    if ($VD != "OK") {
        throw new Exception($VD);
    }

    $data = array(
        "error" => "NO",
        "message" => "Registro eliminado correctamente.",
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
    exit();
}

?>