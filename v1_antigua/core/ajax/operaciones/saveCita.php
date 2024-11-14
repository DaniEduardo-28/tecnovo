<?php
require_once "../core/models/ClassOrdenVenta.php";

$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$direccion = $_POST['direccion'];
$fundo = $_POST['fundo'];
$precio = $_POST['precio'];
$cantidad_hc = $_POST['cantidad_hc'];
$fecha_inicio = $_POST['fecha_inicio'];
$hora_inicio = $_POST['hora_inicio'];
$fecha_termino = $_POST['fecha_termino'];
$hora_fin = $_POST['hora_fin'];
$observaciones = $_POST['observaciones'];

try {
    $cronograma = new ClassOrdenVenta();
    $resultado = $cronograma->guardarCita([
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'direccion' => $direccion,
        'fundo' => $fundo,
        'precio' => $precio,
        'cantidad_hc' => $cantidad_hc,
        'fecha_inicio' => $fecha_inicio,
        'hora_inicio' => $hora_inicio,
        'fecha_termino' => $fecha_termino,
        'hora_fin' => $hora_fin,
        'observaciones' => $observaciones
    ]);

    if ($resultado) {
        echo json_encode(["error" => "NO", "message" => "Cita guardada correctamente."]);
    } else {
        throw new Exception("No se pudo guardar la cita.");
    }
} catch (Exception $e) {
    echo json_encode(["error" => "SI", "message" => $e->getMessage()]);
}
?>
