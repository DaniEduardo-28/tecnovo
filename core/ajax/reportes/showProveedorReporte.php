<?php

require_once "core/models/ClassProveedor.php";

try {
    $estado = isset($_POST["estado"]) ? $_POST["estado"] : "all";
    $valor_busqueda = isset($_POST["valor_busqueda"]) ? trim($_POST["valor_busqueda"]) : "";
    $tipo_busqueda = isset($_POST["tipo_busqueda"]) ? intval($_POST["tipo_busqueda"]) : 1;

    $Resultado = $OBJ_PROVEEDOR->showreporte($estado, $valor_busqueda, $tipo_busqueda);

    if ($Resultado["error"] == "NO") {
        $data["error"] = "NO";
        $data["message"] = "Success";
        $data["data"] = $Resultado["data"];
    } else {
        throw new Exception($Resultado["message"]);
    }
} catch (Exception $e) {
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
}

echo json_encode($data);
exit();


 ?>
