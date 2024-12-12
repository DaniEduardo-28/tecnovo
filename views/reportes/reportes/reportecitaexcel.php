<?php
// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
}

require_once 'plantilla.php';
require_once 'resources/PHPExcel/Classes/PHPExcel.php';

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

    require_once 'core/models/ClassCita.php';
    $Resultado = $OBJ_CITA->showreporte("all", $fecha_inicio, $fecha_fin, null, null);
    if ($Resultado["error"] === "SI") {
        throw new Exception($Resultado["message"]);
    }

    $arrayresultado = $Resultado["data"];



    // Nombre del archivo Excel
    $filename = 'reporte_cita.xls';

    // Establecer encabezados para la descarga
    header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Encabezados del archivo Excel
    $excel_data = "Num\tFecha Cita\tEstado\tNombre de Servicio\tNombre de Trabajador\tMaquinaria\n";

    // Datos
    $x = 1;
    foreach ($arrayresultado as $key) {
        $excel_data .= $x . "\t" .
            mb_convert_encoding($key['fecha_cita'], 'UTF-8', 'auto') . "\t" .
            mb_convert_encoding($key['estado'], 'UTF-8', 'auto') . "\t" .
            mb_convert_encoding($key['name_servicio'], 'UTF-8', 'auto') . "\t" .
            mb_convert_encoding($key['nombre_trabajador'], 'UTF-8', 'auto') . "\t" .
            mb_convert_encoding($key['name_maquinaria'], 'UTF-8', 'auto') . "\n";
        $x++;
    }

    // Imprimir los datos del archivo Excel
    echo $excel_data;

} catch (\Exception $e) {
    // En caso de error, genera un mensaje en PDF
    require_once 'plantilla.php';
    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->setY(10);
    $pdf->setX(2);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(12, 3, (utf8_decode($e->getMessage())), 0, 0, 'L', 0);
    $pdf->Output();
}
?>
