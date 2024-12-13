<?php

// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
}


	include 'plantilla.php';
  require_once 'resources/PHPExcel/Classes/PHPExcel.php';

  try {
    $id_doc_cliente = isset($_GET["id_doc_cliente"]) ? $_GET["id_doc_cliente"] : "";
    $id_doc_venta = isset($_GET["id_doc_venta"]) ? $_GET["id_doc_venta"] : "";
    $valor = isset($_GET["valor"]) ? $_GET["valor"] : "";
    $estado = isset($_GET["estado"]) ? $_GET["estado"] : "all";
    $fecha_inicio = isset($_GET["fecha_inicio"]) ? $_GET["fecha_inicio"] : date("Y-m-d");
    $fecha_fin = isset($_GET["fecha_fin"]) ? $_GET["fecha_fin"] : date("Y-m-d");
    $id_sucursal = isset($_SESSION['id_sucursal']) ? $_SESSION['id_sucursal'] : 0;
    $id_trabajador = isset($_SESSION['id_trabajador']) ? $_SESSION['id_trabajador'] : "0";

    // Validación de permisos
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordenventa"));

    if ($access_options[0]['error'] == "NO" && !$access_options[0]['flag_descargar']) {
        throw new Exception("No tienes permisos para descargar este reporte.");
    }

    require_once "core/models/ClassEmpresa.php";
    $ResultadoEmpresa = $OBJ_EMPRESA->getEmpresa();
    if ($ResultadoEmpresa["error"] == "SI") {
        throw new Exception($ResultadoEmpresa["message"]);
    }
    $empresa = $ResultadoEmpresa["data"];

    require_once "core/models/ClassOrdenVenta.php";
    $Resultado = $OBJ_ORDEN_VENTA->showReporte($id_sucursal, $id_trabajador, $id_doc_venta, $id_doc_cliente, $estado, $valor, $fecha_inicio, $fecha_fin);
    if ($Resultado["error"] == "SI") {
        throw new Exception($Resultado["message"]);
    }
    $arrayordenventa = $Resultado["data"];

        // Nombre del archivo Excel
        $filename = 'reporte_salida_productos.xls';


    // Establecer encabezados para la descarga
    header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');


        // Encabezados del archivo Excel
        $excel_data = "#\tDOCUMENTO\tCOMPROBANTE\tFECHA\tTIPO DOCUMENTO\tENCARGADO\n";

// Datos
$x = 1;
foreach ($arrayordenventa as $key) {
    $excel_data .= $x . "\t" .
        mb_convert_encoding($key['name_documento_venta'], 'UTF-8', 'auto') . "\t" .
        mb_convert_encoding($key['serie']."-". substr("000000". $key['correlativo'],-8), 'UTF-8', 'auto') . "\t" .
        mb_convert_encoding(date("d/m/Y", strtotime($key['fecha'])), 'UTF-8', 'auto') . "\t" .
        mb_convert_encoding($key['name_documento_cliente'].": ". $key['numero_documento_cliente'], 'UTF-8', 'auto') . "\t" .
        mb_convert_encoding(utf8_decode($key['cliente']), 'UTF-8', 'auto') . "\n";
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
