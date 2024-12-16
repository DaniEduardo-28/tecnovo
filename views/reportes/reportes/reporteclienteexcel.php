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


    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("vistareportecliente"));
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_descargar'] == false) {
            throw new Exception("No tienes permisos para descargar este reporte.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

 
    require_once 'core/models/ClassCliente.php';
    $Resultado = $OBJ_CLIENTE->showreporte("all", null, null);
    if ($Resultado["error"] === "SI") {
        throw new Exception($Resultado["message"]);
    }

    $arrayresultado = $Resultado["data"];

   
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Título principal "Syscos"
    $sheet->mergeCells('A1:K1');
    $sheet->setCellValue('A1', 'Syscos');
    $sheet->getStyle('A1')->getFont()->setSize(20)->setBold(true);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


    $startRow = 5;

 
    $headers = [
        'NUM', 'DOCUMENTO', 'NOMBRE CLIENTE', 'APODO', 'FECHA NACIMIENTO',
        'DIRECCIÓN', 'TELÉFONO', 'CORREO', 'SEXO', 'ESTADO', 'FUNDOS PERTENECIENTES'
    ];
    $sheet->fromArray($headers, null, 'A' . $startRow);


    $headerStyle = [
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFCCCCCC']],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A' . $startRow . ':K' . $startRow)->applyFromArray($headerStyle);

    // Llenado de datos
    $rowNum = $startRow + 1;
    $x = 1;
    foreach ($arrayresultado as $key) {
        $sheet->fromArray([
            $x,
            $key['numero_documento'],
            $key['nombre_cliente'],
            $key['apodo'],
            $key['fecha_nacimiento'],
            $key['direccion'],
            $key['telefono'],
            $key['correo'],
            $key['sexo'],
            $key['estado'],
            strip_tags($key['cant_fundos'])
        ], null, 'A' . $rowNum);
        $rowNum++;
        $x++;
    }


        $centeredStyle = [
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('E' . ($startRow + 1) . ':E' . ($rowNum - 1))->applyFromArray($centeredStyle);
        $sheet->getStyle('G' . ($startRow + 1) . ':G' . ($rowNum - 1))->applyFromArray($centeredStyle);



    foreach (range('A', 'K') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }


    $sheet->getStyle('A' . $startRow . ':K' . ($rowNum - 1))->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ]);


    $filename = 'reporte_cliente.xlsx';


    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();

} catch (\Exception $e) {
    // En caso de error
    echo "Error: " . $e->getMessage();
    exit();
}
?>
