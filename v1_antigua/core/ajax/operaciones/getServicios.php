<?php
require_once "core/models/ClassOrdenGasto.php";

try {
    $OBJ_ORDEN_GASTO = new ClassOrdenGasto();
    $servicios = $OBJ_ORDEN_GASTO->getServicios(); // Asegúrate de tener esta función en el modelo

    $data = [
        "error" => "NO",
        "data" => array_map(function($servicio) {
            return [
                "codigo" => $servicio['id_servicio'],
                "descripcion" => $servicio['name_servicio']
            ];
        }, $servicios)
    ];
    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(["error" => "SI", "message" => $e->getMessage()]);
}
?>
