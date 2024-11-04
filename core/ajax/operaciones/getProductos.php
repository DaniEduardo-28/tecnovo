<?php
require_once "core/models/ClassOrdenGasto.php";

try {
    $OBJ_ORDEN_GASTO = new ClassOrdenGasto();
    $productos = $OBJ_ORDEN_GASTO->getProductos(); // Asegúrate de tener esta función en el modelo

    $data = [
        "error" => "NO",
        "data" => array_map(function($producto) {
            return [
                "codigo" => $producto['id_gasto'],
                "descripcion" => $producto['name_gasto']
            ];
        }, $productos)
    ];
    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(["error" => "SI", "message" => $e->getMessage()]);
}
?>
