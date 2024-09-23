<?php

  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
  }

	include 'plantilla.php';

  try {

    $id_doc_cliente = isset($_GET["id_doc_cliente"])	? $_GET["id_doc_cliente"]	: "";
    $id_doc_venta = isset($_GET["id_doc_venta"])	? $_GET["id_doc_venta"]	: "";
    $valor = isset($_GET["valor"])	? $_GET["valor"]	: "";
    $estado = isset($_GET["estado"])	? $_GET["estado"]	: "all";
    $fecha_inicio = isset($_GET["fecha_inicio"])	? $_GET["fecha_inicio"]	: date("Y-m-d");
    $fecha_fin = isset($_GET["fecha_fin"])	? $_GET["fecha_fin"]	: date("Y-m-d");
    $id_fundo = isset($_SESSION['id_fundo']) ? $_SESSION['id_fundo'] : 0;
    $id_trabajador = isset($_SESSION['id_trabajador']) ? $_SESSION['id_trabajador'] : "0";

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


    $pdf = new PDF('L','mm','A4');
  	$pdf->AliasNbPages();
  	$pdf->AddPage();

  	$pdf->SetFillColor(234,232,232);
  	$pdf->Image($empresa[0]['src_logo'], 10, 5, -600 );
  	$pdf->SetY(13);
  	$pdf->SetX(35);
    $pdf->SetFont('Arial','',13);
  	$pdf->Cell(100,8,$empresa[0]['razon_social'],0,0,'L',0);
  	$pdf->Ln(10);
  	$pdf->SetFont('Arial','U',11);
  	$pdf->Cell(280,1,'REPORTE DE ORDENES DE VENTA',0,0,'C',0);

  	$pdf->Ln(10);
    $pdf->SetX(5);
  	$pdf->SetFont('Arial','B',8);
  	$pdf->Cell(10,5,'#',1,0,'C',0);
  	$pdf->Cell(35,5,'DOCUMENTO',1,0,'C',0);
    $pdf->Cell(25,5,'COMPROB.',1,0,'C',0);
  	$pdf->Cell(20,5,'FECHA',1,0,'C',0);
  	$pdf->Cell(30,5,'DOCUM.',1,0,'C',0);
  	$pdf->Cell(60,5,'CLIENTE',1,0,'C',0);
  	$pdf->Cell(15,5,'MON.',1,0,'C',0);
  	$pdf->Cell(19,5,'SUB TOTAL',1,0,'C',0);
  	$pdf->Cell(18,5,'IGV',1,0,'C',0);
  	$pdf->Cell(18,5,'DESC.',1,0,'C',0);
  	$pdf->Cell(20,5,'TOTAL',1,0,'C',0);
    $pdf->Cell(15,5,'ESTADO',1,0,'C',0);
  	$pdf->Ln(5);

  	$pdf->SetFont('Arial','',8);
  	$x=1;

  	foreach ($arrayordenventa as $key) {
      $pdf->SetX(5);
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
  		$pdf->Cell(10,5,$x,1,0,'C',0);
  		$pdf->Cell(35,5,$key['name_documento_venta'],1,0,'C',0);
  		$pdf->Cell(25,5,$key['serie'] .'-' . substr("0000000" . $key['correlativo'],-8),1,0,'C',0);
      $pdf->Cell(20,5,date("d/m/Y", strtotime($key['fecha'])),1,0,'C',0);
  		$pdf->Cell(30,5,"[" . $key['codigo_documento_cliente'] . "] - " . $key['numero_documento_cliente'],1,0,'C',0);
  		$pdf->Cell(60,5,utf8_decode($key['cliente']) ,1,0,'L',0);
  		$pdf->Cell(15,5,$key['abreviatura_moneda'],1,0,'C',0);
  		$pdf->Cell(19,5,$key['signo_moneda'] . $key['sub_total'],1,0,'R',0);
  		$pdf->Cell(18,5,$key['signo_moneda'] . $key['igv'],1,0,'R',0);
  		$pdf->Cell(18,5,$key['signo_moneda'] . $key['descuento_total'],1,0,'R',0);
  		$pdf->Cell(20,5,$key['signo_moneda'] . $key['total'],1,0,'R',0);
      $pdf->Cell(15,5,utf8_decode($estado) ,1,0,'C',0);
  		$pdf->Ln(5);
  		$x++;
  	}

  	$pdf->Output();

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
