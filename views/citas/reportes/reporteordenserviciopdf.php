<?php

if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
}

include 'plantilla.php';

try {
    $fecha_inicio = isset($_GET["fecha_inicio"]) ? $_GET["fecha_inicio"] : date("Y-m-d");
    $fecha_fin = isset($_GET["fecha_fin"]) ? $_GET["fecha_fin"] : date("Y-m-d");
    $cliente = isset($_GET["cliente"]) ? $_GET["cliente"] : "all";
    $fundo = isset($_GET["fundo"]) ? $_GET["fundo"] : "all";
    $maquinaria = isset($_GET["maquinaria"]) ? $_GET["maquinaria"] : "all";
    $operador = isset($_GET["operador"]) ? $_GET["operador"] : "all";
    $unidadNegocio = isset($_GET["unidadNegocio"]) ? $_GET["unidadNegocio"] : "all";

    require_once "core/models/ClassCronograma.php";
    require_once "core/models/ClassEmpresa.php";

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
    $Resultado = $OBJ_CRONOGRAMA->showreporte("all", $cliente, $fundo, $maquinaria, $operador, $unidadNegocio);

    if ($Resultado["error"] == "SI") {
        throw new Exception($Resultado["message"]);
    }
    $arrayresultado = $Resultado["data"];

    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->Image($empresa[0]['src_logo'], 10, 10, 30); // Ajusta el tamaño y posición del logo
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetY(15);
    $pdf->SetX(45);
    $pdf->Cell(100, 8, utf8_decode($empresa[0]['razon_social']), 0, 1, 'L', 0);

    // Fecha del reporte
    $fecha_reporte = date('Y-m-d H:i:s');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetY(10);
    $pdf->SetX(-60);
    $pdf->Cell(50, 5, "Fecha: $fecha_reporte", 0, 0, 'R');

    // Título principal
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, utf8_decode('REPORTE DE ORDEN DE SERVICIO'), 0, 1, 'C');

    // Encabezados de la tabla
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(234, 232, 232);
    $pdf->Cell(25, 8, 'CODIGO', 1, 0, 'C', true);
    $pdf->Cell(60, 8, 'OPERADOR', 1, 0, 'C', true);
    $pdf->Cell(35, 8, 'MAQUINARIA', 1, 0, 'C', true);
    $pdf->Cell(20, 8, 'TOTAL', 1, 0, 'C', true);
    $pdf->Cell(20, 8, 'GASTOS', 1, 0, 'C', true);
    $pdf->Cell(20, 8, 'GANANCIA', 1, 0, 'C', true);
    $pdf->Cell(33, 8, 'FECHA INGRESO', 1, 0, 'C', true);
    $pdf->Cell(33, 8, 'FECHA SALIDA', 1, 0, 'C', true);
    $pdf->Cell(25, 8, 'ESTADO', 1, 1, 'C', true);

    // Datos de la tabla
    $pdf->SetFont('Arial', '', 8);
    foreach ($arrayresultado as $key) {
        $pdf->Cell(25, 8, utf8_decode($key['codigo']), 1, 0, 'C');
        $pdf->Cell(60, 8, utf8_decode($key['nombre_operador']), 1, 0, 'L');
        $pdf->Cell(35, 8, utf8_decode($key['nombre_maquinaria']), 1, 0, 'L');
        $pdf->Cell(20, 8, $key['total'], 1, 0, 'R');
        $pdf->Cell(20, 8, $key['gastos'], 1, 0, 'R');
        $pdf->Cell(20, 8, $key['ganancia'], 1, 0, 'R');
        $pdf->Cell(33, 8, utf8_decode($key['fecha_ingreso']), 1, 0, 'C');
        $pdf->Cell(33, 8, utf8_decode($key['fecha_salida']), 1, 0, 'C');
        $pdf->Cell(25, 8, utf8_decode($key['estado_trabajo']), 1, 1, 'C');
    }

    $pdf->Output();

} catch (\Exception $e) {

    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->setY(10);
    $pdf->setX(2);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(12, 3, (utf8_decode($e->getMessage())), 0, 0, 'L', 0);
    $pdf->Output();

}