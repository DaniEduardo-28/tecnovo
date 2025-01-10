<?php

$id_cronograma_operador = isset($_POST["id_cronograma_operador"]) ? $_POST["id_cronograma_operador"] : 0;

try {


    require_once "core/models/ClassCronograma.php";
    $VD = $OBJ_CRONOGRAMA->deleteOperador($id_cronograma_operador);

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