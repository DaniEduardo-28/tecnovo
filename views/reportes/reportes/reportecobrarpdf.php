<?php

  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
  }

	include 'plantilla.php';

  try {    
    $fecha_inicio = isset($_GET["fecha_inicio"])	? $_GET["fecha_inicio"]	: date("Y-m-d");
    $fecha_fin = isset($_GET["fecha_fin"])	? $_GET["fecha_fin"]	: date("Y-m-d");
    $valor = isset($_GET["valor"])	? $_GET["valor"]	: "";


    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("vistareportepagar"));

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

    require_once "core/models/ClassGastoServicio.php";
    $Resultado = $OBJ_GASTO_SERVICIO->showReporteCobrar($valor,$fecha_inicio,$fecha_fin,"");
    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }
    $arrayresultado = $Resultado["data"];


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
  	$pdf->Cell(280,1,'CLIENTES POR COBRAR',0,0,'C',0);

  	$pdf->Ln(10);
    $pdf->SetX(5);
  	$pdf->SetFont('Arial','B',8);
  	$pdf->Cell(10,5,'#',1,0,'C',0);
  	$pdf->Cell(35,5,'CODIGO DE ORDEN',1,0,'C',0);
    $pdf->Cell(40,5,'FECHA INICIO',1,0,'C',0);
  	$pdf->Cell(100,5,'NOMBRE DEL CLIENTE',1,0,'L',0);
    $pdf->Cell(30,5,'MONTO TOTAL',1,0,'L',0);
    $pdf->Cell(30,5,'MONTO PAGADO',1,0,'L',0);
    $pdf->Cell(30,5,'MONTO PENDIENTE',1,0,'L',0);
  	$pdf->Ln(5);

  	$pdf->SetFont('Arial','',8);
  	$x=1;

  	foreach ($arrayresultado as $key) {
      $pdf->SetX(5);
  		$pdf->Cell(10,5,$x,1,0,'C',0);
  		$pdf->Cell(35,5,utf8_decode($key['codigo']),1,0,'C',0);
      $pdf->Cell(40,5,$key['fecha'],1,0,'C',0);
      $pdf->Cell(100,5,$key['nombre_cliente'],1,0,'L',0);
      $pdf->Cell(30,5,$key['total'],1,0,'L',0);
      $pdf->Cell(30,5,$key['pagado'],1,0,'L',0);
      $pdf->Cell(30,5,$key['pendiente'],1,0,'L',0);
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
