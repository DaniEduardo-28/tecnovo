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
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("vistareporteauditoria"));
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_descargar'] == false) {
            throw new Exception("No tienes permisos para descargar este reporte.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    require_once 'core/models/ClassAuditoria.php';
    // Obtener datos de auditoría
    $Resultado = $OBJ_AUDITORIA->showreporte("all", $fecha_inicio, $fecha_fin);
    if ($Resultado["error"] === "SI") {
        throw new Exception($Resultado["message"]);
    }

    $arrayresultado = $Resultado["data"];

    // Nombre del archivo Excel
    $filename = 'reporte_auditoria.xls';

    // Establecer encabezados para la descarga
    header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

        // Crear una cadena para almacenar los datos del archivo Excel
        $excel_data = '';

    // Encabezados del archivo Excel
    $excel_data = "Num\tNombre Usuario\tTipo Usuario\tNombre Tabla\tTipo Transacción\tFecha\n";

    // Datos
    $x = 1;
    foreach ($arrayresultado as $key) {
        $excel_data .= $x . "\t" .
            mb_convert_encoding($key['nombres'], 'UTF-8', 'auto') . "\t" .
            mb_convert_encoding($key['name_grupo'], 'UTF-8', 'auto') . "\t" .
            mb_convert_encoding($key['nombre_tabla'], 'UTF-8', 'auto') . "\t" .
            mb_convert_encoding($key['tipo_transaccion'], 'UTF-8', 'auto') . "\t" .
            mb_convert_encoding($key['fecha'], 'UTF-8', 'auto') . "\n";
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
