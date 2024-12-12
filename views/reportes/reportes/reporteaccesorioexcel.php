<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
  }

  include 'plantilla.php';
  require_once 'resources/PHPExcel/Classes/PHPExcel.php';

  try {

    $valor = isset($_GET["valor"])	? $_GET["valor"]	: "";
    $id_categoria = isset($_GET["id_categoria"])	? $_GET["id_categoria"]	: "";
    $id_sucursal = isset($_SESSION["id_sucursal"])	? $_SESSION["id_sucursal"]	: 0;

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("vistareporteaccesorios"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_descargar']==false) {
        throw new Exception("No tienes permisos para descargar este reporte.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassEmpresa.php";
    $ResultadoEmpresa = $OBJ_EMPRESA->getEmpresa();
    if ($ResultadoEmpresa["error"]=="SI") {
      throw new Exception($ResultadoEmpresa["message"]);
    }
    $empresa = $ResultadoEmpresa["data"];

    require_once "core/models/ClassAccesorio.php";
    $Resultado = $OBJ_ACCESORIO->showReporte("all",$id_categoria,$valor,$id_sucursal);
    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }
    $arrayaccesorios = $Resultado["data"];

    

    // Nombre del archivo Excel
    $filename = 'reporte_productos.xls';

    // Establecer encabezados para la descarga
    header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');


    // Encabezados del archivo Excel
    $excel_data = "NUM\tCATEGORÍA\tPRODUCTO\tSTOCK\tS. MINIMO\tP. COMPRA\n";

    // Datos
    $x = 1;
    foreach ($arrayaccesorios as $key) {
        $excel_data .= $x . "\t" .
            mb_convert_encoding($key['name_categoria'], 'UTF-8', 'auto') . "\t" .
            mb_convert_encoding($key['name_accesorio'], 'UTF-8', 'auto') . "\t" .
            mb_convert_encoding($key['stock'] . " " . $key['name_unidad'], 'UTF-8', 'auto') . "\t" .
            mb_convert_encoding($key['stock_minimo'] . " " . $key['name_unidad'], 'UTF-8', 'auto') . "\t" .
            mb_convert_encoding(utf8_decode($key['signo_moneda']) . " " . $key['precio_compra'], 'UTF-8', 'auto') . "\n";
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
