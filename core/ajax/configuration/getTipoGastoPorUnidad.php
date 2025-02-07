<?php
if ($_GET['accion'] === 'getTipoGastoPorUnidad') {
    require_once "core/models/ClassTipoGasto.php";

    $id_tipo_servicio = $_POST['id_tipo_servicio']; 
    $OBJ_TIPO_GASTO = new ClassTipoGasto();

    $tipogasto = $OBJ_TIPO_GASTO->getTipoGastoPorUnidad($id_tipo_servicio);

    echo json_encode([
        "error" => $tipogasto ? "NO" : "SI",
        "data" => $tipogasto ?: []
    ]);
}

?>