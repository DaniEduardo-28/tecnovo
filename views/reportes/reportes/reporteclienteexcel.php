<?php
// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
}

require_once 'resources/vendor/autoload.php'; // Cargar PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

try {
    // Obtener parámetros para el filtro
    $fecha_inicio = isset($_GET["fecha_inicio"]) ? $_GET["fecha_inicio"] : date("Y-m-d");
    $fecha_fin = isset($_GET["fecha_fin"]) ? $_GET["fecha_fin"] : date("Y-m-d");

    // Verificar permisos
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("vistareportecliente"));
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_descargar'] == false) {
            throw new Exception("No tienes permisos para descargar este reporte.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    // Obtener datos del reporte
    require_once 'core/models/ClassCliente.php';
    $Resultado = $OBJ_CLIENTE->showreporte("all", null, null);
    if ($Resultado["error"] === "SI") {
        throw new Exception($Resultado["message"]);
    }

    $arrayresultado = $Resultado["data"];

    // Crear un nuevo objeto Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Título principal "Syscos"
    $sheet->mergeCells('A1:K1');
    $sheet->setCellValue('A1', 'Syscos');
    $sheet->getStyle('A1')->getFont()->setSize(20)->setBold(true);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Espacio de separación
    $startRow = 5;

    // Encabezados de la tabla
    $headers = [
        'NUM', 'DOCUMENTO', 'NOMBRE CLIENTE', 'APODO', 'FECHA NACIMIENTO',
        'DIRECCION', 'TELEFONO', 'CORREO', 'SEXO', 'ESTADO', 'FUNDOS PERTENECIENTES'
    ];
    $sheet->fromArray($headers, null, 'A' . $startRow);

    // Estilo de encabezados
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
            strip_tags($key['cant_fundos']) // Eliminar etiquetas HTML
        ], null, 'A' . $rowNum);
        $rowNum++;
        $x++;
    }

    // Ajustar automáticamente el ancho de las columnas
    foreach (range('A', 'K') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Aplicar bordes a todas las celdas con datos
    $sheet->getStyle('A' . $startRow . ':K' . ($rowNum - 1))->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ]);

    // Nombre del archivo Excel
    $filename = 'reporte_cliente.xlsx';

    // Configuración de salida para descargar el archivo
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
