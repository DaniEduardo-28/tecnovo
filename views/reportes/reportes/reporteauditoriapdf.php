<?php

if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
}
header('Content-Type: text/html; charset=utf-8');

require_once 'plantilla.php'; // Asegúrate de que contiene la clase PDF extendida de FPDF

try {
    // Obtener parámetros de filtro
    $fecha_inicio = isset($_GET["fecha_inicio"]) ? $_GET["fecha_inicio"] : date("Y-m-d");
    $fecha_fin = isset($_GET["fecha_fin"]) ? $_GET["fecha_fin"] : date("Y-m-d");
    $filterUser = isset($_GET["filterUser"]) ? $_GET["filterUser"] : "";
    $filterTable = isset($_GET["filterTable"]) ? $_GET["filterTable"] : "";

    // Verificar permisos
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("vistareporteauditoria"));
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_descargar'] == false) {
            throw new Exception("No tienes permisos para descargar este reporte.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassAuditoria.php";
    // Obtener datos de auditoría
    $Resultado = $OBJ_AUDITORIA->showreporte("all", $fecha_inicio, $fecha_fin);

    if ($Resultado["error"] == "SI") {
        throw new Exception($Resultado["message"]);
    }

    $arrayresultado = $Resultado["data"];

    // Crear el PDF
    $pdf = new PDF('L', 'mm', 'A4'); // Horizontal (Landscape), Unidad en mm, Tamaño A4
    $pdf->AliasNbPages();
    $pdf->AddPage();

    // Configuración inicial del PDF
$pdf = new PDF('L', 'mm', 'A4'); // Formato horizontal (L), milímetros, tamaño A4
$pdf->AliasNbPages();
$pdf->AddPage();

// Configuración de encabezados y título
$pdf->SetY(20);
$pdf->SetFont('Arial', '', 13);
$pdf->Cell(0, 8, 'ESMAR', 0, 1, 'C'); // Encabezado centrado
$pdf->SetFont('Arial', 'U', 11);
$pdf->Cell(0, 8, 'REPORTE DE AUDITORIA', 0, 1, 'C'); // Título centrado

// Calcular posición inicial de la tabla
$pdf->Ln(10); // Espacio entre el título y la tabla
$startX = ($pdf->GetPageWidth() - 270) / 2; // 270 es el ancho total aproximado de la tabla
$pdf->SetX($startX);

// Dibujar encabezados de la tabla
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(10, 5, '#', 1, 0, 'C');
$pdf->Cell(50, 5, 'Nombre Usuario', 1, 0, 'C');
$pdf->Cell(40, 5, 'Tipo Usuario', 1, 0, 'C');
$pdf->Cell(50, 5, 'Nombre Tabla', 1, 0, 'C');
$pdf->Cell(50, 5, 'Tipo Transacción', 1, 0, 'C');
$pdf->Cell(40, 5, 'Fecha', 1, 1, 'C');

// Dibujar filas de la tabla
$pdf->SetFont('Arial', '', 9);
foreach ($arrayresultado as $key => $row) {
    $pdf->SetX($startX); // Asegurar que cada fila comienza en la misma posición
    $pdf->Cell(10, 5, $key + 1, 1, 0, 'C');
    $pdf->Cell(50, 5, utf8_decode($row['nombres']), 1, 0, 'C');
    $pdf->Cell(40, 5, utf8_decode($row['name_grupo']), 1, 0, 'C');
    $pdf->Cell(50, 5, utf8_decode($row['nombre_tabla']), 1, 0, 'C');
    $pdf->Cell(50, 5, utf8_decode($row['tipo_transaccion']), 1, 0, 'C');
    $pdf->Cell(40, 5, utf8_decode($row['fecha']), 1, 1, 'C');
}


    // Salida del PDF
    $pdf->Output();

} catch (\Exception $e) {
    // Generar un mensaje de error en PDF
    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetY(10);
    $pdf->SetX(2);
    $pdf->Cell(12, 3, utf8_decode($e->getMessage()), 0, 0, 'L', 0);
    $pdf->Output();
}

?>
