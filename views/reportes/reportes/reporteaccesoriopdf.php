<?php

  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
  }

	include 'plantilla.php';

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
  	$pdf->Cell(280,1,'REPORTE DE PRODUCTOS',0,0,'C',0);

  	$pdf->Ln(10);
    $pdf->SetX(5);
  	$pdf->SetFont('Arial','B',8);
  	$pdf->Cell(10,5,'#',1,0,'C',0);
    $pdf->Cell(45,5,utf8_decode('CATEGORÍA'),1,0,'C',0);
  	$pdf->Cell(120,5,utf8_decode('PRODUCTO'),1,0,'C',0);
  	$pdf->Cell(25,5,'STOCK',1,0,'C',0);
  	$pdf->Cell(20,5,'S. MIN.',1,0,'C',0);
    $pdf->Cell(25,5,'P. COMPRA',1,0,'C',0);
 /*  	$pdf->Cell(25,5,'P. VENTA',1,0,'C',0); */
    $pdf->Cell(17,5,'ESTADO',1,0,'C',0);
  	$pdf->Ln(5);

  	$pdf->SetFont('Arial','',8);
  	$x=1;

  	foreach ($arrayaccesorios as $key) {
      $pdf->SetX(5);
  		$pdf->Cell(10,5,$x,1,0,'C',0);
  		$pdf->Cell(45,5,utf8_decode($key['name_categoria']),1,0,'C',0);
      $pdf->Cell(120,5,utf8_decode($key['name_accesorio']),1,0,'L',0);
      $pdf->Cell(25,5,$key['stock'] . " " . $key['name_unidad'],1,0,'C',0);
      $pdf->Cell(20,5,$key['stock_minimo'] . " " . $key['name_unidad'],1,0,'C',0);
      $pdf->Cell(25,5,utf8_decode($key['signo_moneda']) . " " . $key['precio_compra'],1,0,'C',0);
/*       $pdf->Cell(25,5,utf8_decode($key['signo_moneda']) . " " . $key['precio_venta'],1,0,'R',0);
 */      $pdf->Cell(17,5,utf8_decode(strtoupper($key['estado'])),1,0,'C',0);
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
