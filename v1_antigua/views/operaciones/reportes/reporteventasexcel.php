<?php

  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
  }

	include 'plantilla.php';
  require_once 'resources/PHPExcel/Classes/PHPExcel.php';

  try {

    $id_doc_cliente = isset($_GET["id_doc_cliente"])	? $_GET["id_doc_cliente"]	: "";
    $id_doc_venta = isset($_GET["id_doc_venta"])	? $_GET["id_doc_venta"]	: "";
    $valor = isset($_GET["valor"])	? $_GET["valor"]	: "";
    $estado = isset($_GET["estado"])	? $_GET["estado"]	: "all";
    $fecha_inicio = isset($_GET["fecha_inicio"])	? $_GET["fecha_inicio"]	: date("Y-m-d");
    $fecha_fin = isset($_GET["fecha_fin"])	? $_GET["fecha_fin"]	: date("Y-m-d");
    $id_fundo = isset($_SESSION['id_fundo']) ? $_SESSION['id_fundo'] : 0;
    $id_trabajador = isset($_SESSION['id_trabajador']) ? $v['id_trabajador'] : "0";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordenventa"));

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

    require_once "core/models/ClassOrdenVenta.php";
    $Resultado = $OBJ_ORDEN_VENTA->showReporte($id_fundo,$id_trabajador,$id_doc_venta,$id_doc_cliente,$estado,$valor,$fecha_inicio,$fecha_fin);
    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }
    $arrayordenventa = $Resultado["data"];


  	$objPHPExcel = new PHPExcel();
  	$objPHPExcel->getProperties()
          ->setCreator("TECNOVO PERU SAC")
          ->setLastModifiedBy("TECNOVO PERU SAC")
          ->setTitle("VENTAS " . date("d/m/Y", strtotime($fecha_inicio)) . " - " . date("d/m/Y", strtotime($fecha_fin)))
          ->setSubject("Reporte de Ventas")
          ->setDescription("Documento generado con PHPExcel")
          ->setKeywords("excel phpexcel php")
          ->setCategory("VENTAS " . date("d/m/Y", strtotime($fecha_inicio)) . " - " . date("d/m/Y", strtotime($fecha_fin)));

    $objPHPExcel->setActiveSheetIndex(0);
  	$objPHPExcel->getActiveSheet()->setTitle('Hoja 1');

  	//TAMAÑOS DE EMNCABEZADOS
  	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(60);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
  	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);

  	// ENCABEZADO
  	$objPHPExcel->getActiveSheet()->setCellValue('A1', '#');
  	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'DOCUMENTO');
  	$objPHPExcel->getActiveSheet()->setCellValue('C1', 'COMPROBANTE');
  	$objPHPExcel->getActiveSheet()->setCellValue('D1', 'FECHA');
  	$objPHPExcel->getActiveSheet()->setCellValue('E1', 'DOCUMENTO');
  	$objPHPExcel->getActiveSheet()->setCellValue('F1', 'CLIENTE');
  	$objPHPExcel->getActiveSheet()->setCellValue('G1', 'MONEDA');
  	$objPHPExcel->getActiveSheet()->setCellValue('H1', 'SUB TOTAL');
  	$objPHPExcel->getActiveSheet()->setCellValue('I1', 'IGV');
  	$objPHPExcel->getActiveSheet()->setCellValue('J1', 'DESCUENTO');
  	$objPHPExcel->getActiveSheet()->setCellValue('K1', 'TOTAL');
    $objPHPExcel->getActiveSheet()->setCellValue('L1', 'ESTADO');

  	//recorremos el array de datos
  	$x=2;

  	foreach ($arrayordenventa as $key) {

      $estado = $key['estado'];
      switch ($estado) {
        case '1':
          $estado = "Registrado";
          break;
        case '2':
          $estado = "Pagado";
          break;
        case '3':
          $estado = "Anulado";
          break;
      }

  		$objPHPExcel->getActiveSheet()->setCellValue('A'.$x, $x-1);
  		$objPHPExcel->getActiveSheet()->setCellValue('B'.$x, $key['name_documento_venta']);
      $objPHPExcel->getActiveSheet()->setCellValue('C'.$x, $key['serie'] .'-' . substr("0000000" . $key['correlativo'],-8));
      $objPHPExcel->getActiveSheet()->setCellValue('D'.$x, date("d/m/Y", strtotime($key['fecha'])));
  		$objPHPExcel->getActiveSheet()->setCellValue('E'.$x, "[" . $key['codigo_documento_cliente'] . "] - " . $key['numero_documento_cliente']);
  		$objPHPExcel->getActiveSheet()->setCellValue('F'.$x, $key['cliente']);
  		$objPHPExcel->getActiveSheet()->setCellValue('G'.$x, $key['abreviatura_moneda']);
  		$objPHPExcel->getActiveSheet()->setCellValue('H'.$x, $key['signo_moneda'] . " " . $key['sub_total']);
  		$objPHPExcel->getActiveSheet()->setCellValue('I'.$x, $key['signo_moneda'] . " " . $key['igv']);
  		$objPHPExcel->getActiveSheet()->setCellValue('J'.$x, $key['signo_moneda'] . " " . $key['descuento_total']);
  		$objPHPExcel->getActiveSheet()->setCellValue('K'.$x, $key['signo_moneda'] . " " . $key['total']);
      $objPHPExcel->getActiveSheet()->setCellValue('L'.$x, $estado);
  		$x++;
  	}

  	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
  	header('Content-Disposition: attachment;filename="' . $empresa[0]['razon_social'] . ' ' . date("d/m/Y",strtotime($fecha_inicio)) . ' - ' . date("d/m/Y",strtotime($fecha_fin)) .  '.xlsx"');
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
