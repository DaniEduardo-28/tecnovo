<?php

require_once "core/models/ClassCronograma.php";

$id_sucursal = $_SESSION['id_sucursal'] ?? 0;
$OBJ_CRONOGRAMA = new ClassCronograma();

try {
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("citas"));
    if ($access_options[0]['error'] == "NO" && !$access_options[0]['flag_buscar']) {
        throw new Exception("No tienes permisos para realizar búsquedas.");
    }

    $filtros = [
        'fecha_inicio' => $_POST['fecha_inicio'] ?? null,
        'fecha_fin' => $_POST['fecha_fin'] ?? null,
        'fundo' => $_POST['fundo'] ?? null,
        'maquinaria' => $_POST['maquinaria'] ?? null,
        'operador' => $_POST['operador'] ?? null,
        'cliente' => $_POST['cliente'] ?? null,
    ];

    $Resultado = $OBJ_CRONOGRAMA->showCronograma($filtros);

    if ($Resultado["error"] == "SI") {
        throw new Exception($Resultado["message"]);
    }

    echo json_encode($Resultado['data']);
} catch (Exception $e) {
    echo json_encode(["error" => "SI", "message" => $e->getMessage()]);
}
