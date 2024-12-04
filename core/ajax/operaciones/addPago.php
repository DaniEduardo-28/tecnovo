<?php

try {
    $id_ingreso = $_POST['id_ingreso'];
    $id_forma_pago = $_POST['id_forma_pago'];
    $fecha_pago = $_POST['fecha_pago'];
    $monto_pagado = $_POST['monto_pagado'];

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ingreso"));

    require_once "core/models/ClassIngreso.php";
    $resultado = $OBJ_INGRESO->addPago($id_ingreso, $id_forma_pago, $fecha_pago, $monto_pagado);

    if ($resultado === "OK") {
        echo json_encode([
            "error" => "NO",
            "message" => "Pago registrado correctamente.",
        ]);
    } else {
        throw new Exception($resultado);
    }
} catch (Exception $e) {
    echo json_encode([
        "error" => "SI",
        "message" => $e->getMessage(),
    ]);
}
?>
