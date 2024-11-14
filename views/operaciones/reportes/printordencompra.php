<?php

  include 'plantilla.php';

  $pdf = new PDF('P','mm','A4');
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFillColor(234,232,232);
  $pdf->SetFont('Arial','B',10);

  require("core/models/ClassOrdenCompra.php");
  require("core/models/ClassEmpresa.php");
  require("core/models/ClassMoneda.php");

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordencompra"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_ver']==false) {
        throw new Exception("No tienes permiso a ver la orden.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    $id_orden_compra = isset($_GET["id_orden_compra"]) ? $_GET["id_orden_compra"] : 0;

    if ($id_orden_compra==0) {
      throw new Exception("No se recibió el id orden compra");
    }

    $resulEmpresa = $OBJ_EMPRESA->getEmpresa();
    $resulOrden = $OBJ_ORDEN_COMPRA->getDataPrintOrdenCompra($id_orden_compra);

    if ($resulEmpresa['error']=="SI") {
      throw new Exception($resulEmpresa['message']);
    }

    if ($resulOrden['error']=="SI") {
      throw new Exception($resulOrden['message']);
    }

    $dataEmpresa = $resulEmpresa['data'];
    $dataOrden = $resulOrden['data'];

    $resulMoneda = $OBJ_MONEDA->getMonedaForId($dataOrden[0]['id_moneda']);

    if ($resulMoneda['error']=="SI") {
      throw new Exception($resulMoneda['message']);
    }

    $dataMoneda = $resulMoneda['data'];

    $signo_moneda = $dataMoneda[0]['signo'];

    $dataMoneda = $resulMoneda['data'];

    $pdf->Image($dataEmpresa[0]['src_logo'], 160, 20, 35 );

    $pdf->Ln(35);

    $pdf->SetY(10);
    $pdf->SetX(10);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(190,6,utf8_decode(strtoupper($dataEmpresa[0]['razon_social'])),0,0,'C',0);
    $pdf->Ln(6);
    $pdf->Cell(190,6,utf8_decode(strtoupper($dataEmpresa[0]['name_documento_empresa'] . ' ' . $dataEmpresa[0]['num_documento'])),0,0,'C',0);
    $pdf->Ln(10);
    $pdf->SetFont('Arial','U',11);
    $pdf->SetY(25);
    $pdf->SetX(10);
    $pdf->Cell(190,1,utf8_decode('ORDEN DE COMPRA N° ' . right(('0000000'.$dataOrden[0]['id_orden_compra']),8)),0,0,'C',0);
    $pdf->Ln(12);
    $pdf->SetFont('Arial','',9);
    $pdf->SetY(32);
    $pdf->SetX(10);
    $pdf->Cell(190,1,utf8_decode("FECHA ORDEN : " . date('d/m/Y',strtotime($dataOrden[0]['fecha_orden']))),0,0,'L',0);
    $pdf->Ln(6);
    $pdf->SetY(38);
    $pdf->SetX(10);
    $pdf->Cell(190,1,utf8_decode("FECHA ENTREGA : " . date('d/m/Y',strtotime($dataOrden[0]['fecha_entrega']))),0,0,'L',0);
    $pdf->Ln(6);
    $pdf->SetY(44);
    $pdf->SetX(10);
    $pdf->Cell(190,1,utf8_decode("PROVEEDOR : " . $dataOrden[0]['nombre_proveedor']),0,0,'L',0);
    $pdf->Ln(6);
    $pdf->Cell(190,1,utf8_decode("ENVIAR A : " . $dataEmpresa[0]['direccion']),0,0,'L',0);
    $pdf->Ln(6);
    $pdf->Cell(190,1,utf8_decode("TELÉFONO CONTACTO : " . $dataEmpresa[0]['fono01']),0,0,'L',0);

    $pdf->Ln(4);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(190,5,'____________________________________________________________________________________________________________',0,0,'C',0);

    $pdf->Ln(8);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(5,5,'',0,0,'C',0);
    $pdf->Cell(10,5,'#',1,0,'C',0);
    $pdf->Cell(100,5,'PRODUCTO',1,0,'C',0);
    $pdf->Cell(20,5,'PRECIO',1,0,'C',0);
    $pdf->Cell(20,5,'CANTIDAD',1,0,'C',0);
    $pdf->Cell(25,5,'TOTAL',1,0,'C',0);


    $pdf->Ln(5);
    $count=1;
    $pdf->SetFont('Arial','',8);
    $total = 0;

    foreach ($dataOrden as $key) {

      $pdf->Cell(5,5,'',0,0,'C',0);
      $pdf->Cell(10,5,$count,1,0,'C',0);
      $pdf->Cell(100,5,utf8_decode($key['name_producto']),1,0,'L',0);
      $pdf->Cell(20,5,utf8_decode($signo_moneda . " " . $key['precio_unitario']),1,0,'R',0);
      $pdf->Cell(20,5,utf8_decode($key['cantidad_solicitada']),1,0,'C',0);
      $pdf->Cell(25,5,utf8_decode($signo_moneda . " " . $key['total']),1,0,'R',0);
      $pdf->Ln(5);
      $count++;
      $total += $key['total'];

    }

    $pdf->SetFont('Arial','B',9);
    $pdf->Ln(3);
    $pdf->Cell(155,5,'MONTO TOTAL DE ORDEN ',0,0,'R',0);
    $pdf->Cell(25,5,$signo_moneda . " " . $total,0,0,'R',0);

    $pdf->Ln(6);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(190,5,'____________________________________________________________________________________________________________',0,0,'C',0);


    $pdf->Ln(6);
    $pdf->SetX(10);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,"NOTAS",0,0,'L',0);
    $pdf->SetFont('Arial','',9);

    $count = 1;
    foreach ($dataOrden as $key) {

      if ($key['notas']!=="") {

        $pdf->Ln(6);
        $pdf->Cell(190,5,utf8_decode($count . '. ' . $key['name_producto'] . ' - ' . $key['notas']),0,0,'L',0);
        $count++;

      }

    }

    $pdf->Ln(9);
    $pdf->SetX(10);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,"OBSERVACIONES",0,0,'L',0);

    $pdf->SetFont('Arial','',8);
    $pdf->Ln(8);
    $pdf->Cell(5,5,"",0,0,'R',0);
    $pdf->MultiCell(175, 5, utf8_decode($dataOrden[0]['observaciones']), 0, 'J');


    $pdf->Ln(30);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(180,5,'____________________________________________',0,0,'C',0);
    $pdf->Ln(6);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(180,5,strtoupper($dataEmpresa[0]['apellidos_representante'] . ' ' . $dataEmpresa[0]['nombres_representante']),0,0,'C',0);
    $pdf->Ln(5);
    $pdf->Cell(180,5,strtoupper($dataEmpresa[0]['name_documento_representante'] . ' ' . $dataEmpresa[0]['num_documento_representante']),0,0,'C',0);
    $pdf->Ln(5);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(180,5,'Representante Legal',0,0,'C',0);

    if ($dataOrden[0]['estado']=="Anulado") {
      $pdf->Image("resources/global/images/anulado.png", 70, 80, -100 );
    }

    $pdf->Output();

  } catch (\Exception $e) {

    $pdf->Cell(180,5,$e->getMessage(),0,0,'C',0);
    $pdf->Output();

  }

?>
