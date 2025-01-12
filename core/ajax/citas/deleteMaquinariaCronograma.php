<?php

$id_cronograma_maquinaria = isset($_POST["id_cronograma_maquinaria"]) ? $_POST["id_cronograma_maquinaria"] : 0;

try {


    require_once "core/models/ClassCronograma.php";
    $VD = $OBJ_CRONOGRAMA->deleteMaquinaria($id_cronograma_maquinaria);

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