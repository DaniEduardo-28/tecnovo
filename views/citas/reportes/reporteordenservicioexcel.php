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

    $sheet->mergeCells('A1:M1');
    $sheet->setCellValue('A1', 'Fecha del Reporte: ' . $fecha_reporte);
    $sheet->getStyle('A1')->getFont()->setSize(11);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

    $sheet->mergeCells('A2:M2');
    $sheet->setCellValue('A2', 'SysCos - Reporte de Órdenes de Servicio');
    $sheet->getStyle('A2')->getFont()->setSize(16)->setBold(true);
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $startRow = 4;
    $headers = [
        'NUM', 'CÓDIGO', 'CLIENTE', 'FUNDO', 'SERVICIO', 
        'OPERADOR', 'MAQUINARIA', 'FECHA INGRESO', 
        'FECHA SALIDA', 'ESTADO', 'TOTAL', 'GASTOS', 'GANANCIA'
    ];
    $sheet->fromArray($headers, null, 'A' . $startRow);

    $headerStyle = [
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFCCCCCC']],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A' . $startRow . ':M' . $startRow)->applyFromArray($headerStyle);

    $rowNum = $startRow + 1;
    $x = 1;
    foreach ($arrayresultado as $key) {
        $sheet->fromArray([
            $x,
            $key['codigo'],
            $key['nombre_cliente'],
            $key['nombre_fundo'],
            $key['nombre_servicio'],
            $key['nombre_operador'],
            $key['nombre_maquinaria'],
            $key['fecha_ingreso'],
            $key['fecha_salida'],
            $key['estado_trabajo'],
            $key['total'],
            $key['gastos'],
            $key['ganancia']
        ], null, 'A' . $rowNum);
        $rowNum++;
        $x++;
    }

    foreach (range('A', 'M') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $sheet->getStyle('A' . $startRow . ':M' . ($rowNum - 1))->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ]);

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
