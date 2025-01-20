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

    $OBJ_EMPRESA = new ClassEmpresa();
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
        $costo_general = $resultado['totales']['total_pago_operadores'] + $resultado['totales']['total_pago_maquinarias'];
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

    $pdf->Ln(15);
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, utf8_decode("INFORME DEL SERVICIO N° ") . $datos_cronograma['codigo'], 0, 1, 'C');

    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(50, 8, utf8_decode("Cliente:"), 0, 0, 'L');
    $pdf->Cell(100, 8, utf8_decode($datos_cronograma['nombre_cliente']), 0, 1, 'L');

    $pdf->Cell(50, 8, utf8_decode("Servicio:"), 0, 0, 'L');
    $pdf->Cell(100, 8, utf8_decode($datos_cronograma['nombre_servicio']), 0, 1, 'L');

    $pdf->Cell(50, 8, utf8_decode("Fundo:"), 0, 0, 'L');
    $pdf->Cell(100, 8, utf8_decode($datos_cronograma['nombre_fundo']), 0, 1, 'L');

    $pdf->Cell(50, 8, utf8_decode("Cantidad de Hectáreas:"), 0, 0, 'L');
    $pdf->Cell(100, 8, utf8_decode($datos_cronograma['cantidad'] . " Hc"), 0, 1, 'L');

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, utf8_decode('Trabajadores empleados'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    foreach ($operadores as $operador) {
        $pdf->Cell(100, 8, utf8_decode($operador['nombre_operador']), 0, 1, 'L');
    }

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, utf8_decode('Maquinarias Utilizadas'), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    foreach ($maquinarias as $maquinaria) {
        $pdf->Cell(100, 8, utf8_decode($maquinaria['nombre_maquinaria']), 0, 1, 'L');
    }

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(50, 8, utf8_decode("Costo General:"), 0, 0, 'L');
    $pdf->Cell(50, 8, utf8_decode("S/." . number_format($costo_general, 2)), 0, 1, 'L');

    $pdf->Output();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
