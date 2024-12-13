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
    $id_sucursal = isset($_SESSION['id_sucursal']) ? $_SESSION['id_sucursal'] : 0;
    $tipo_busqueda = isset($_GET["id_doc_compra"])	? $_GET["id_doc_compra"]	: "";
    $id_trabajador = isset($_SESSION['id_trabajador']) ? $_SESSION['id_trabajador'] : "0";


    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("vistareporteproveedor"));

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

    require_once "core/models/ClassProveedor.php";
    $Resultado = $OBJ_PROVEEDOR->showReporte("all","","");
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
  	$pdf->Cell(280,1,'REPORTE DE PROVEEDORES',0,0,'C',0);

  	$pdf->Ln(10);
    $pdf->SetX(5);
  	$pdf->SetFont('Arial','B',8);
  	$pdf->Cell(10,5,'#',1,0,'C',0);
  	$pdf->Cell(40,5,'NUM. DOCUMENTO',1,0,'C',0);
    $pdf->Cell(95,5,'NOMBRE DEL PROVEEDOR',1,0,'C',0);
  	$pdf->Cell(40,5,'APODO',1,0,'C',0);
    $pdf->Cell(25,5,'TELEFONO',1,0,'C',0);
    $pdf->Cell(17,5,'ESTADO',1,0,'C',0);
  	$pdf->Ln(5);

  	$pdf->SetFont('Arial','',8);
  	$x=1;

  	foreach ($arrayresultado as $key) {
      $pdf->SetX(5);
  		$pdf->Cell(10,5,$x,1,0,'C',0);
  		$pdf->Cell(40,5,utf8_decode($key['numero_documento']),1,0,'C',0);
      $pdf->Cell(95,5,utf8_decode($key['nombre_proveedor']),1,0,'L',0);
      $pdf->Cell(40,5,$key['apodo'],1,0,'C',0);
      $pdf->Cell(25,5,$key['telefono'],1,0,'C',0);
      $pdf->Cell(17,5,$key['estado'],1,0,'C',0);
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
