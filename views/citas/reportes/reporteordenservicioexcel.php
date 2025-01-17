<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
}

require_once 'resources/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

try {

    $fecha_inicio = isset($_GET["fecha_inicio"]) ? $_GET["fecha_inicio"] : date("Y-m-d");
    $fecha_fin = isset($_GET["fecha_fin"]) ? $_GET["fecha_fin"] : date("Y-m-d");
    $cliente = isset($_GET["cliente"]) ? $_GET["cliente"] : "all";
    $fundo = isset($_GET["fundo"]) ? $_GET["fundo"] : "all";
    $maquinaria = isset($_GET["maquinaria"]) ? $_GET["maquinaria"] : "all";
    $operador = isset($_GET["operador"]) ? $_GET["operador"] : "all";
    $unidadNegocio = isset($_GET["unidadNegocio"]) ? $_GET["unidadNegocio"] : "all";

    // Fecha actual del reporte
    $fecha_reporte = date('Y-m-d H:i:s');

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("citas"));
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_descargar'] == false) {
            throw new Exception("No tienes permisos para descargar este reporte.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    require_once 'core/models/ClassCronograma.php';
    $Resultado = $OBJ_CRONOGRAMA->showreporte("all", $cliente, $fundo, $maquinaria, $operador, $unidadNegocio, $fecha_inicio, $fecha_fin);
    if ($Resultado["error"] === "SI") {
        throw new Exception($Resultado["message"]);
    }

    $arrayresultado = $Resultado["data"];

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->mergeCells('A1:H1');
    $sheet->setCellValue('A1', 'Fecha del Reporte: ' . $fecha_reporte);
    $sheet->getStyle('A1')->getFont()->setSize(11);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

    $sheet->mergeCells('A2:L2');
    $sheet->setCellValue('A2', 'SysCos - Reporte de Órdenes de Servicio');
    $sheet->getStyle('A2')->getFont()->setSize(16)->setBold(true);
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $startRow = 4;
    $headers = [
        'CÓDIGO','TOTAL', 'GASTOS', 'GANANCIA', 'CLIENTE', 'FUNDO', 'SERVICIO', 
        'OPERADOR', 'MAQUINARIA', 'FECHA INGRESO', 
        'FECHA SALIDA', 'ESTADO'
    ];
    $sheet->fromArray($headers, null, 'A' . $startRow);

    $headerStyle = [
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFCCCCCC']],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A' . $startRow . ':L' . $startRow)->applyFromArray($headerStyle);

    $rowNum = $startRow + 1;
    foreach ($arrayresultado as $key) {
        $operadores = str_replace(", ", "\n", $key['nombre_operador']);
        $maquinarias = str_replace(", ", "\n", $key['nombre_maquinaria']);

        $sheet->setCellValue('A' . $rowNum, $key['codigo']);
        $sheet->setCellValue('B' . $rowNum, $key['total']);
        $sheet->setCellValue('C' . $rowNum, $key['gastos']);
        $sheet->setCellValue('D' . $rowNum, $key['ganancia']);
        $sheet->setCellValue('E' . $rowNum, $key['nombre_cliente']);
        $sheet->setCellValue('F' . $rowNum, $key['nombre_fundo']);
        $sheet->setCellValue('G' . $rowNum, $key['nombre_servicio']);
        $sheet->setCellValue('H' . $rowNum, $operadores);
        $sheet->setCellValue('I' . $rowNum, $maquinarias);
        $sheet->setCellValue('J' . $rowNum, $key['fecha_ingreso']);
        $sheet->setCellValue('K' . $rowNum, $key['fecha_salida']);
        $sheet->setCellValue('L' . $rowNum, $key['estado_trabajo']);

        $sheet->getStyle('H' . $rowNum)->getAlignment()->setWrapText(true);
        $sheet->getStyle('I' . $rowNum)->getAlignment()->setWrapText(true);

        $sheet->getStyle('A' . $rowNum . ':L' . $rowNum)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        $rowNum++;
    }

    foreach (range('A', 'L') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $filename = 'reporte_orden_servicio.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
