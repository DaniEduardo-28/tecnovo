<?php

$id_cronograma_operador = $_POST['id_cronograma_operador'] ?? null;
$id_trabajador = $_POST['nombre_operador'] ?? null;
$horas_trabajadas = $_POST['horas_trabajadas'] ?? null;
$pago_por_hora = $_POST['pago_por_hora'] ?? null;

$id_cronograma_maquinaria = $_POST['id_cronograma_maquinaria'] ?? null;
$id_maquinaria = $_POST['nombre_maquinaria'] ?? null;
$petroleo_entrada = $_POST['petroleo_entrada'] ?? null;
$petroleo_salida = $_POST['petroleo_salida'] ?? null;
$precio_petroleo = $_POST['precio_petroleo'] ?? null;

try {
    // Actualizar datos del operador
    $operadorData = [
        'id_trabajador' => $id_trabajador,
        'horas_trabajadas' => $horas_trabajadas,
        'pago_por_hora' => $pago_por_hora,
        'total_pago' => $horas_trabajadas * $pago_por_hora
    ];

    $resultadoOperador = $OBJ_CRONOGRAMA->updateOperador($id_cronograma_operador, $operadorData);

    if ($resultadoOperador !== "OK") {
        throw new Exception("Error al actualizar el operador: " . $resultadoOperador);
    }

    // Actualizar datos de la maquinaria
    $consumo_petroleo = $petroleo_entrada - $petroleo_salida;
    $maquinariaData = [
        'id_maquinaria' => $id_maquinaria,
        'petroleo_entrada' => $petroleo_entrada,
        'petroleo_salida' => $petroleo_salida,
        'precio_petroleo' => $precio_petroleo,
        'consumo_petroleo' => $consumo_petroleo,
        'pago_petroleo' => $consumo_petroleo * $precio_petroleo
    ];

    $resultadoMaquinaria = $OBJ_CRONOGRAMA->updateMaquinaria($id_cronograma_maquinaria, $maquinariaData);

    if ($resultadoMaquinaria !== "OK") {
        throw new Exception("Error al actualizar la maquinaria: " . $resultadoMaquinaria);
    }

    // Respuesta exitosa
    $data = [
        "error" => "NO",
        "message" => "Operador y Maquinaria actualizados correctamente.",
        "data" => null
    ];
    echo json_encode($data);

} catch (Exception $e) {
    // Respuesta de error
    $data = [
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null
    ];
    echo json_encode($data);
    exit();
}

