<?php

  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
  }

  include 'plantilla.php';
  require_once 'resources/PHPExcel/Classes/PHPExcel.php';

  try {

    $valor = isset($_GET["valor"])	? $_GET["valor"]	: "";
    $id_tipo_medicamento = isset($_GET["id_tipo_medicamento"])	? $_GET["id_tipo_medicamento"]	: "";
    $id_sucursal = isset($_SESSION["id_sucursal"])	? $_SESSION["id_sucursal"]	: 0;

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("vistareportemedicamentos"));

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

    require_once "core/models/ClassMedicamento.php";
    $Resultado = $OBJ_MEDICAMENTO->showReporte("all",$id_tipo_medicamento,$valor,$id_sucursal);
    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }
    $arraymedicamento = $Resultado["data"];


    $objPHPExcel = new PHPExcel();
  	$objPHPExcel->getProperties()
          ->setCreator("TECNOVO PERU SAC")
          ->setLastModifiedBy("TECNOVO PERU SAC")
          ->setTitle("Reporte de Productos")
          ->setSubject("Reporte de Productos")
          ->setDescription("Documento generado con PHPExcel")
          ->setKeywords("excel phpexcel php")
          ->setCategory("Reporte de Productos");

    $objPHPExcel->setActiveSheetIndex(0);
  	$objPHPExcel->getActiveSheet()->setTitle('Hoja 1');

  	//TAMAÑOS DE EMNCABEZADOS
  	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);

    // ENCABEZADO
    $objPHPExcel->getActiveSheet()->setCellValue('A1', '#');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'TIPO');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'MEDICAMENTO');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'STOCK');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'STOCK MIN');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'P. COMPRA');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'P. VENTA');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'ESTADO');

  	$x=2;

  	foreach ($arraymedicamento as $key) {
      $objPHPExcel->getActiveSheet()->setCellValue('A'.$x, $x-1);
      $objPHPExcel->getActiveSheet()->setCellValue('B'.$x, $key['name_tipo']);
      $objPHPExcel->getActiveSheet()->setCellValue('C'.$x, $key['name_medicamento']);
      $objPHPExcel->getActiveSheet()->setCellValue('D'.$x, $key['stock'] . " " . $key['name_unidad']);
      $objPHPExcel->getActiveSheet()->setCellValue('E'.$x, $key['stock_minimo'] . " " . $key['name_unidad']);
      $objPHPExcel->getActiveSheet()->setCellValue('F'.$x, $key['signo_moneda'] . " " . $key['precio_compra']);
      $objPHPExcel->getActiveSheet()->setCellValue('G'.$x, $key['signo_moneda'] . " " . $key['precio_venta']);
      $objPHPExcel->getActiveSheet()->setCellValue('H'.$x, $key['estado']);
  		$x++;
  	}

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Disposition: attachment;filename="' . $empresa[0]['razon_social'] . " - " . $_SESSION['nombre_sucursal'] . " - " . ' Reporte de Productos' .  '.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');

  } catch (\Exception $e) {

    $pdf = new PDF('L','mm','A4');
  	$pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->setY(10);
    $pdf->setX(2);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(12,3,(utf8_decode($e->getMessage())),0,0,'L',0);
    $pdf->Output();

  }

?>
