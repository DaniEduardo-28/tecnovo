<?php
try {
    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"]) : 10;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"]) >= 0 ? intval($_POST["offset"]) : 0;
    $fecha_inicio = isset($_POST["fecha_inicio"]) ? $_POST["fecha_inicio"] : date("Y-m-d");
    $fecha_fin = isset($_POST["fecha_fin"]) ? $_POST["fecha_fin"] : date("Y-m-d");
    $filterUser = isset($_POST["filterUser"]) ? $_POST["filterUser"] : "";
    $filterTable = isset($_POST["filterTable"]) ? $_POST["filterTable"] : "";
    $chkfechas = isset($_POST["chkfechas"]) ? $_POST["chkfechas"] : 0;


    require_once "core/models/ClassAuditoria.php";
    $Resultado = $OBJ_AUDITORIA->showreporte("all", $fecha_inicio, $fecha_fin, $chkfechas);

// Obtener usuarios y tablas únicas
$usuarios = array_values(array_unique(array_column($Resultado["data"], 'nombres')));
$tablas = array_values(array_unique(array_column($Resultado["data"], 'nombre_tabla'))); // Extraer nombres únicos de tablas

if ($filterUser) {
    $Resultado["data"] = array_filter($Resultado["data"], function ($item) use ($filterUser) {
        return isset($item['nombres']) && $item['nombres'] === $filterUser;
    });
}
if ($filterTable) {
    $Resultado["data"] = array_filter($Resultado["data"], function ($item) use ($filterTable) {
        return isset($item['nombre_tabla']) && $item['nombre_tabla'] === $filterTable;
    });
}
sort($usuarios);
sort($tablas);


    if ($Resultado["error"] == "NO") {
        $retorno_array = [];
        $count = 1;

        foreach ($Resultado["data"] as $key) {
            $retorno_array[] = array(
                "num" => "$count",
                "id_auditoria" => $key['id_auditoria'],
                "nombres" => $key['nombres'],
                "name_grupo" => $key['name_grupo'],
                "nombre_tabla" => $key['nombre_tabla'],
                "tipo_transaccion" => $key['tipo_transaccion'],
                "fecha" => $key['fecha']
            );
            $count++;
        }

        $data["error"] = "NO";
        $data["message"] = "Success";
        $data["data"] = $retorno_array;
        $data["usuarios"] = $usuarios; // Lista completa de usuarios
        $data["tablas"] = $tablas;     // Lista completa de tablas
        echo json_encode($data);
    } else {
        throw new Exception($Resultado["message"]);
    }

    


} catch (\Exception $e) {
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
}


?>