<?php

if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
}

require_once "core/models/ClassCronograma.php";
require_once "core/models/ClassEmpresa.php";
require_once "plantilla.php";

$id_cronograma = $_GET['id_cronograma'] ?? 0;

try {
    if (!$id_cronograma) {
        throw new Exception("ID del cronograma no proporcionado.");
    }
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("citas"));

    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_descargar'] == false) {
            throw new Exception("No tienes permisos para descargar este reporte.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    $ResultadoEmpresa = $OBJ_EMPRESA->getEmpresa();
    if ($ResultadoEmpresa["error"] == "SI") {
        throw new Exception($ResultadoEmpresa["message"]);
    }
    $empresa = $ResultadoEmpresa["data"];

    $OBJ_CRONOGRAMA = new ClassCronograma();
    $resultado = $OBJ_CRONOGRAMA->getResumenComprasServicios($id_cronograma);

    if ($resultado['error'] === "NO") {
        $datos_cronograma = $resultado['cronograma'];
        $operadores = $resultado['operadores'];
        $maquinarias = $resultado['maquinarias'];
        $totales = $resultado['totales'];
    } else {
        throw new Exception($resultado['message']);
    }
    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->Image($empresa[0]['src_logo'], 10, 10, 30);
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetY(15);
    $pdf->SetX(45);
    $pdf->Cell(100, 8, utf8_decode($empresa[0]['razon_social']), 0, 1, 'L', 0);

    $fecha_reporte = date('Y-m-d H:i:s');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetY(10);
    $pdf->SetX(-60);
    $pdf->Cell(50, 5, "Fecha: $fecha_reporte", 0, 0, 'R');

    $pdf->Ln(25);
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, utf8_decode("COMPRAS Y GASTOS DEL SERVICIO N° {$datos_cronograma['codigo']}"), 0, 1, 'C');

    // Datos principales
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(40, 8, utf8_decode("Fecha de Ingreso:"), 0, 0, 'L');
    $pdf->Cell(60, 8, utf8_decode($datos_cronograma['fecha_ingreso']), 0, 0, 'L');
    $pdf->Cell(40, 8, utf8_decode("Fecha de Salida:"), 0, 0, 'L');
    $pdf->Cell(60, 8, utf8_decode($datos_cronograma['fecha_salida']), 0, 1, 'L');

    $pdf->Cell(40, 8, utf8_decode("Cantidad de Hectáreas:"), 0, 0, 'L');
    $pdf->Cell(60, 8, utf8_decode($datos_cronograma['cantidad'] . " Hc"), 0, 0, 'L');
    $pdf->Cell(40, 8, utf8_decode("Monto Unitario:"), 0, 0, 'L');
    $pdf->Cell(60, 8, utf8_decode("S/." . $datos_cronograma['monto_unitario']), 0, 1, 'L');

    $pdf->Cell(40, 8, utf8_decode("Descuento:"), 0, 0, 'L');
    $pdf->Cell(60, 8, utf8_decode("S/." . $datos_cronograma['descuento']), 0, 0, 'L');
    $pdf->Cell(40, 8, utf8_decode("Adelanto:"), 0, 0, 'L');
    $pdf->Cell(60, 8, utf8_decode("S/." . $datos_cronograma['adelanto']), 0, 1, 'L');

    $pdf->Cell(40, 8, utf8_decode("Monto Total:"), 0, 0, 'L');
    $pdf->Cell(60, 8, utf8_decode("S/." . $datos_cronograma['monto_total']), 0, 0, 'L');
    $pdf->Cell(40, 8, utf8_decode("Saldo por Pagar:"), 0, 0, 'L');
    $pdf->Cell(60, 8, utf8_decode("S/." . $datos_cronograma['saldo_por_pagar']), 0, 1, 'L');

    $pdf->Cell(40, 8, utf8_decode("Estado Pago:"), 0, 0, 'L');
    $pdf->Cell(60, 8, utf8_decode($datos_cronograma['estado_pago']), 0, 0, 'L');
    $pdf->Cell(40, 8, utf8_decode("Estado Trabajo:"), 0, 0, 'L');
    $pdf->Cell(60, 8, utf8_decode($datos_cronograma['estado_trabajo']), 0, 1, 'L');

    $pdf->Ln(5);

    $pdf->Cell(40, 8, utf8_decode("Nombre Servicio:"), 0, 0, 'L');
    $pdf->Cell(80, 8, utf8_decode($datos_cronograma['nombre_servicio']), 0, 1, 'L');
    $pdf->Cell(40, 8, utf8_decode("Nombre Fundo:"), 0, 0, 'L');
    $pdf->Cell(80, 8, utf8_decode($datos_cronograma['nombre_fundo']), 0, 1, 'L');
    $pdf->Cell(40, 8, utf8_decode("Nombre Cliente:"), 0, 0, 'L');
    $pdf->Cell(80, 8, utf8_decode($datos_cronograma['nombre_cliente']), 0, 1, 'L');


    // Datos de operadores
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, utf8_decode('Operadores'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    foreach ($operadores as $operador) {
        $pdf->Cell(80, 8, utf8_decode($operador['nombre_operador'] . ":"), 0, 0, 'L');
        $pdf->Cell(20, 8, utf8_decode("S/." . $operador['total_pago']), 0, 1, 'R');
    }
    $pdf->Cell(80, 8, utf8_decode('Total Pago Operadores:'), 0, 0, 'L');
    $pdf->Cell(20, 8, utf8_decode("S/." . $totales['total_pago_operadores']), 0, 1, 'R');

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, utf8_decode('Maquinarias'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    foreach ($maquinarias as $maquinaria) {
        $pdf->Cell(80, 8, utf8_decode($maquinaria['nombre_maquinaria'] . ":"), 0, 0, 'L');
        $pdf->Cell(20, 8, utf8_decode("S/." . $maquinaria['pago_petroleo']), 0, 1, 'R');
    }
    $pdf->Cell(80, 8, utf8_decode('Total Pago Maquinarias:'), 0, 0, 'L');
    $pdf->Cell(20, 8, utf8_decode("S/." . $totales['total_pago_maquinarias']), 0, 1, 'R');

    $pdf->Output();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
