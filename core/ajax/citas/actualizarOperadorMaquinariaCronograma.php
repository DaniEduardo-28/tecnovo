<?php

$id_cronograma_operador = $_POST['id_cronograma_operador'] ?? null;
$id_trabajador = $_POST['nombre_operador'] ?? null;
$horas_trabajadas = $_POST['horas_trabajadas'] ?? 0;
$pago_por_hora = $_POST['pago_por_hora'] ?? 0;
$total_pago = $horas_trabajadas * $pago_por_hora;

$id_cronograma_maquinaria = $_POST['id_cronograma_maquinaria'] ?? null;
$id_maquinaria = $_POST['nombre_maquinaria'] ?? null;
$petroleo_entrada = $_POST['petroleo_entrada'] ?? 0;
$petroleo_salida = $_POST['petroleo_salida'] ?? 0;
$precio_petroleo = $_POST['precio_petroleo'] ?? 0;


// Si no existe `id_cronograma_maquinaria`, se asigna `0` para crear un nuevo registro
if (!$id_cronograma_maquinaria) {
    $id_cronograma_maquinaria = 0;
}

try {
    require_once "core/models/ClassCronograma.php";
    $resultado = $OBJ_CRONOGRAMA->updateOperadorMaquinaria(
        $id_cronograma_operador,
        $id_trabajador,
        $horas_trabajadas,
        $pago_por_hora,
        $total_pago,
        $id_cronograma_maquinaria,
        $id_maquinaria,
        $petroleo_entrada,
        $petroleo_salida,
        $precio_petroleo
    );
    if ($resultado !== "OK") {
        throw new Exception($resultado);
    }

    $data = [
        "error" => "NO",
        "message" => "Operador y maquinaria actualizados correctamente.",
        "data" => null
    ];
    echo json_encode($data);
} catch (Exception $e) {
    $data = [
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null
    ];
    echo json_encode($data);
    exit();
}
