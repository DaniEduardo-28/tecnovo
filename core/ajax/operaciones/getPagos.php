<?php

try {
    $id_ingreso = isset($_POST['id_ingreso']) ? $_POST['id_ingreso'] : 0;

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ingreso"));


    require_once "core/models/ClassIngreso.php";
    $resultado = $OBJ_INGRESO->getPagos($id_ingreso);

    if ($result["error"] === "NO") {
        echo json_encode($result);
    } else {
        // Si no hay pagos, devolvemos un array vacío pero con éxito
        $data = [
            "error" => "NO",
            "message" => "Sin pagos registrados para este ingreso.",
            "data" => [] // Estructura vacía
        ];
        echo json_encode($data);
    }
} catch (Exception $e) {
    $data = [
        "error" => "SI",
        "message" => $e->getMessage()
    ];
    echo json_encode($data);
}
?>
