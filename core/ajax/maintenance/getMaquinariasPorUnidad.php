<?php
if ($_GET['accion'] === 'getMaquinariasPorUnidad') {
    require_once "core/models/ClassMaquinaria.php";

    $id_tipo_servicio = $_POST['id_tipo_servicio']; // ID de la Unidad de Negocio
    $OBJ_MAQUINARIA = new ClassMaquinaria();

    // Obtener maquinarias relacionadas
    $maquinarias = $OBJ_MAQUINARIA->getMaquinariasPorUnidad($id_tipo_servicio);

    echo json_encode([
        "error" => $maquinarias ? "NO" : "SI",
        "data" => $maquinarias ?: []
    ]);
}

?>