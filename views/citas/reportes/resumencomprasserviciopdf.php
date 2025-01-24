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
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetY(15);
    $pdf->SetX(45);
    $pdf->Cell(100, 6, utf8_decode(strtoupper($empresa[0]['razon_social'])), 0, 1, 'L', 0);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetX(45);
    $pdf->Cell(100, 3, utf8_decode('DIRECCIÓN: ' . $empresa[0]['direccion']), 0, 1, 'L', 0);

    $pdf->SetX(45);
    $pdf->Cell(100, 6, utf8_decode(strtoupper($empresa[0]['name_documento_empresa'] . ' ' . $empresa[0]['num_documento'])), 0, 0, 'L', 0);

    $fecha_reporte = date('Y/m/d H:i:s');
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetY(10);
    $pdf->SetX(-60);
    $pdf->Cell(50, 5, "Fecha de Reporte: $fecha_reporte", 0, 0, 'R');

    $pdf->Ln(30);
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(0, 8, utf8_decode("ORDEN DE SERVICIO"), 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(0, 8, utf8_decode("N° " . $datos_cronograma['codigo']), 0, 1, 'C');

    $pdf->Ln(7);
    //$pdf->Cell(0, 0, '', 'T');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(5, 79, 5);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(0, 6, utf8_decode("DATOS GENERALES"), 0, 1, 'L', true);
    // Datos principales
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(40, 8, utf8_decode("Cliente:  "), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(100, 8, utf8_decode($datos_cronograma['nombre_cliente'] . '  -  ' . $datos_cronograma['documento_identidad']), 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(40, 8, utf8_decode("Fundo:  "), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(100, 8, utf8_decode($datos_cronograma['nombre_fundo']), 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(40, 8, utf8_decode("Servicio:  "), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(100, 8, utf8_decode($datos_cronograma['nombre_servicio']), 0, 1, 'L');
    $pdf->Ln(4);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(5, 79, 5);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(0, 6, utf8_decode("DATOS DEL SERVICIO"), 0, 1, 'L', true);
    // COSTOS DEL SERVICIO

    $fecha_ingreso = date('Y-m-d | H:i', strtotime($datos_cronograma['fecha_ingreso']));
    $fecha_salida = date('Y-m-d | H:i', strtotime($datos_cronograma['fecha_salida']));
    $fecha_pago = date('Y-m-d | H:i', strtotime($datos_cronograma['fecha_pago']));
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(4);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 8, utf8_decode("Fecha de Ingreso:"), 0, 0, 'L');
    $pdf->Cell(60, 8, utf8_decode($fecha_ingreso), 0, 0, 'L');
    $pdf->Cell(40, 8, utf8_decode("Fecha de Salida:"), 0, 0, 'L');
    $pdf->Cell(60, 8, utf8_decode($fecha_salida), 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 8, utf8_decode("Fecha de Pago:"), 0, 0, 'L');
    $pdf->Cell(60, 8, utf8_decode($fecha_pago), 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 8, utf8_decode("Hectáreas:"), 0, 0, 'L');
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
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(5, 79, 5);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(0, 6, utf8_decode("OPERADORES Y MAQUINARIAS"), 0, 1, 'L', true);
    // COSTOS DEL SERVICIO
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);

    // Títulos de las columnas
    $pdf->Cell(95, 10, utf8_decode('OPERADORES'), 1, 0, 'C');
    $pdf->Cell(95, 10, utf8_decode('MAQUINARIAS'), 1, 1, 'C');

    // Contenido de la tabla
    $pdf->SetFont('Arial', '', 8);
    $maxRows = max(count($operadores), count($maquinarias));
    for ($i = 0; $i < $maxRows; $i++) {
        $operador = isset($operadores[$i]) ? utf8_decode($operadores[$i]['nombre_operador']) : '';
        $maquinaria = isset($maquinarias[$i]) ? utf8_decode($maquinarias[$i]['nombre_maquinaria']) : '';

        $pdf->Cell(95, 8, $operador, 1, 0, 'L');
        $pdf->Cell(95, 8, $maquinaria, 1, 1, 'L');
    }
    $pdf->Output();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
