<?php

if (!isset($_SESSION['id_trabajador'])) {
  header('location: ?view=logout');
  exit();
}

include 'plantilla.php';
include "core/functions/CifrasEnLetras.php";

try {

  $id_venta = isset($_GET["id_venta"])  ? $_GET["id_venta"]  : 0;
  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordenventa"));

  $flag_descargar = false;

  if ($access_options[0]['error'] == "NO") {
    if ($access_options[0]['flag_buscar'] == false) {
      throw new Exception("No tienes permisos para realizar busquedas.");
    }
    $flag_descargar = $access_options[0]['flag_descargar'];
  } else {
    throw new Exception("Error al verificar los permisos.");
  }

  require_once "core/models/ClassEmpresa.php";
  $ResultadoEmpresa = $OBJ_EMPRESA->getEmpresa();
  if ($ResultadoEmpresa["error"] == "SI") {
    throw new Exception($ResultadoEmpresa["message"]);
  }
  $empresa = $ResultadoEmpresa["data"];

  require_once "core/models/ClassOrdenVenta.php";
  $ResultadoOrdenVenta = $OBJ_ORDEN_VENTA->getDataVerOrdenVenta($id_venta);
  if ($ResultadoOrdenVenta["error"] == "SI") {
    throw new Exception($ResultadoOrdenVenta["message"]);
  }
  $arrayordenventa = $ResultadoOrdenVenta["data"];

  $pdf = $arrayordenventa[0]['pdf'];
  $estado = $arrayordenventa[0]['estado'];
  $flag_doc_interno = $arrayordenventa[0]['flag_doc_interno'];

  if ($estado == 1) {
    throw new Exception("El documento todavía no se encuentra generado.");
  }

  if ($flag_descargar == false) {
    if ($arrayordenventa[0]['id_trabajador'] != $_SESSION['id_trabajador']) {
      throw new Exception("No tienes permiso para ver este comprobante.");
    }
  }

  if ($estado == "2") {

    if ($flag_doc_interno == 0) {

      if (strlen($pdf) < 5) {

        $ruta = $arrayordenventa[0]['ruta'];
        $token = $arrayordenventa[0]['token'];
        $serie = $arrayordenventa[0]['serie'];
        $correlativo = $arrayordenventa[0]['correlativo'];
        $codigo_documento_venta = $arrayordenventa[0]['codigo_documento_venta'];
        $data = array(
          "operacion" => "consultar_comprobante",
          "tipo_de_comprobante" => $codigo_documento_venta,
          "serie" => $serie,
          "numero" => $correlativo,
        );

        $data_json = json_encode($data);
        $respuesta = obtenerUrl($ruta, $token, $data_json);
        $leer_respuesta = json_decode($respuesta, true);
        if (!isset($leer_respuesta['errors'])) {
          $pdf = $leer_respuesta['enlace'] . '.pdf';
          $VD = $OBJ_ORDEN_VENTA->update_ruta_pdf($id_venta, $pdf);
          if ($VD != "OK") {
            throw new Exception($VD);
          }
        } else {
          throw new Exception($leer_respuesta['errors']);
        }
      }

      header('Location: ' . $pdf);
    }
  }


  $pdfReporte = new PDF($orientation = 'P', $unit = 'mm', array(75, 280));
  $pdfReporte->AliasNbPages();
  $pdfReporte->AddPage();

  $pdfReporte->SetFillColor(232, 232, 232);
  $pdfReporte->SetFont('Arial', 'B', 12);

  $pdfReporte->setX(1);
  $pdfReporte->setY(4);
  $pdfReporte->Cell(55, 4, strtoupper(utf8_decode($empresa[0]['razon_social'])), 0, 0, 'C', 0);
  $pdfReporte->Ln(6);

  $pdfReporte->SetFont('Arial', '', 7);
  $pdfReporte->MultiCell(55, 3, strtoupper(utf8_decode($empresa[0]['direccion'])), 0, 'C', 0);
  $pdfReporte->Ln(1);
  $pdfReporte->SetFont('Arial', 'B', 8);
  $pdfReporte->Cell(55, 3, 'RUC ' . $empresa[0]['num_documento'], 0, 0, 'C', 0);
  $pdfReporte->Ln(4);
  $pdfReporte->Cell(55, 3, strtoupper($arrayordenventa[0]['name_documento_venta']), 0, 0, 'C', 0);
  $pdfReporte->Ln(3);
  $pdfReporte->Cell(55, 3, strtoupper($arrayordenventa[0]['serie'] . "-" . substr("0000000000" . $arrayordenventa[0]['correlativo'], -8)), 0, 0, 'C', 0);

  $pdfReporte->Ln(9);
  $pdfReporte->setX(4);
  $pdfReporte->SetFont('Arial', 'B', 7);
  $pdfReporte->Cell(55, 3, 'PERSONA ENCARGADA', 0, 0, 'L', 0);

  $pdfReporte->SetFont('Arial', '', 7);
  $pdfReporte->Ln(3);
  $pdfReporte->setX(4);
  $pdfReporte->Cell(66, 3, strtoupper($arrayordenventa[0]['name_documento_cliente'] . " " . $arrayordenventa[0]['numero_documento_cliente']), 0, 0, 'L', 0);
  $pdfReporte->Ln(3);
  $pdfReporte->setX(4);
  $pdfReporte->Cell(66, 3, utf8_decode($arrayordenventa[0]['cliente']), 0, 0, 'L', 0);
  $pdfReporte->Ln(3);
  $pdfReporte->setX(4);
  $pdfReporte->Cell(66, 3, utf8_decode($arrayordenventa[0]['direccion']), 0, 0, 'L', 0);

  $pdfReporte->SetFont('Arial', 'B', 7);
  $pdfReporte->Ln(6);
  $pdfReporte->setX(4);
  $pdfReporte->Cell(22, 3, utf8_decode("FECHA REGISTRO:"), 0, 0, 'L', 0);
  $pdfReporte->SetFont('Arial', '', 8);
  $pdfReporte->Ln(3);
  $pdfReporte->setX(4);
  $pdfReporte->Cell(66, 3, date("d/m/Y", strtotime($arrayordenventa[0]['fecha'])), 0, 0, 'L', 0);

  /* $pdfReporte->SetFont('Arial','B',7);
    $pdfReporte->Ln(3);
    $pdfReporte->setX(4);
    $pdfReporte->Cell(13,3,utf8_decode("MONEDA :"),0,0,'L',0);
    $pdfReporte->SetFont('Arial','',7);
    $pdfReporte->Cell(66,3,strtoupper($arrayordenventa[0]['abreviatura_moneda']),0,0,'L',0);

    $pdfReporte->SetFont('Arial','B',7);
    $pdfReporte->Ln(3);
    $pdfReporte->setX(4);
    $pdfReporte->Cell(8,3,utf8_decode("IGV :"),0,0,'L',0);
    $pdfReporte->SetFont('Arial','',7);
    $pdfReporte->Cell(66,3,strtoupper("18.00 %"),0,0,'L',0); */

  $pdfReporte->SetFont('Arial', '', 4);
  $pdfReporte->Ln(6);
  $pdfReporte->setX(4);
  $pdfReporte->Cell(70, 3, '--------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L', 0);
  $pdfReporte->Ln(3);
  $pdfReporte->SetFont('Arial', 'B', 7);
  $pdfReporte->setX(4);
  $pdfReporte->Cell(41, 3, utf8_decode(' DESCRIPCIÓN DE PRODUCTO '), 0, 0, 'L', 0);
  /*     $pdfReporte->Cell(13,3,'P/U',0,0,'C',0);
 */
  $pdfReporte->Cell(39, 3, 'CANT.', 0, 0, 'C', 0);

  $pdfReporte->Ln(4);
  $pdfReporte->SetFont('Arial', '', 7);
  foreach ($arrayordenventa as $key) {
    $descripcion = utf8_decode('- ' . $key['detalle_descripcion'] . ($key['detalle_maquinaria'] ? " (" . $key['detalle_maquinaria'] . ")" : ""));
    $descripcionFragmentos = str_split($descripcion, 50);
    foreach ($descripcionFragmentos as $indice => $fragmento) {
        $pdfReporte->setX(4);
        $pdfReporte->Cell(43, 3, $fragmento, 0, 'L');
        
        if ($indice === 0) {
            $pdfReporte->setX(43);
            $pdfReporte->Cell(26, 3, number_format(round($key['detalle_cantidad'], 2), 2, ".", ""), 0, 'R', 0);
        }
        
        $pdfReporte->Ln(3);
    }
  }

  $pdfReporte->SetFont('Arial', '', 4);
  $pdfReporte->setX(4);
  $pdfReporte->Cell(70, 3, '------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L', 0);
  $pdfReporte->Ln(4);

  /*     $pdfReporte->SetFont('Arial','B',7);
    $pdfReporte->setX(4);
    $pdfReporte->Cell(41,3,utf8_decode("DESCUENTO"),0,0,'R',0);
    $pdfReporte->Cell(10,3,strtoupper($arrayordenventa[0]['signo_moneda']),0,0,'L',0);
    $pdfReporte->Cell(15,3,strtoupper($arrayordenventa[0]['descuento_total']),0,0,'R',0);
    $pdfReporte->Ln(3);

    $pdfReporte->setX(4);
    $pdfReporte->Cell(41,3,utf8_decode("GRAVADA"),0,0,'R',0);
    $pdfReporte->Cell(10,3,strtoupper($arrayordenventa[0]['signo_moneda']),0,0,'L',0);
    $pdfReporte->Cell(15,3,strtoupper($arrayordenventa[0]['sub_total']),0,0,'R',0);
    $pdfReporte->Ln(3);

    $pdfReporte->setX(4);
    $pdfReporte->Cell(41,3,utf8_decode("IGV"),0,0,'R',0);
    $pdfReporte->Cell(10,3,strtoupper($arrayordenventa[0]['signo_moneda']),0,0,'L',0);
    $pdfReporte->Cell(15,3,strtoupper($arrayordenventa[0]['igv']),0,0,'R',0);
    $pdfReporte->Ln(3);

    $pdfReporte->setX(4);
    $pdfReporte->Cell(41,3,utf8_decode("TOTAL"),0,0,'R',0);
    $pdfReporte->Cell(10,3,strtoupper($arrayordenventa[0]['signo_moneda']),0,0,'L',0);
    $pdfReporte->Cell(15,3,strtoupper($arrayordenventa[0]['total']),0,0,'R',0);
    $pdfReporte->Ln(4); */

  /*   $pdfReporte->SetFont('Arial','',4);
    $pdfReporte->setX(4);
    $pdfReporte->Cell(70,3,'-------------------------------------------------------------------------------------------------------------------------------------------',0,0,'L',0);
    $pdfReporte->Ln(4); */

  /* $pdfReporte->SetFont('Arial','B',7);
    $pdfReporte->setX(4);
    $pdfReporte->Cell(25,3,utf8_decode("MEDIO DE PAGO : "),0,0,'L',0);
    $pdfReporte->SetFont('Arial','',7);
    $pdfReporte->Cell(20,3,strtoupper($arrayordenventa[0]['name_forma_pago']),0,0,'L',0);
    $pdfReporte->Ln(3);

    $pdfReporte->SetFont('Arial','B',7);
    $pdfReporte->setX(4);
    $pdfReporte->Cell(30,3,utf8_decode("INPORTE EN LETRAS : "),0,'L',0);
    $pdfReporte->SetFont('Arial','',7);
    $pdfReporte->Ln(3);
    $pdfReporte->setX(4);
    $pdfReporte->MultiCell(65,3,utf8_decode(strtoupper(CifrasEnLetras::convertirEurosEnLetras($arrayordenventa[0]['total']))),0,'L',0);
    $pdfReporte->Ln(5); */
  $pdfReporte->Ln(3);
  $pdfReporte->setX(4);
  $pdfReporte->SetFont('Arial', 'B', 7);
  $pdfReporte->Cell(55, 3, 'NOTAS', 0, 0, 'L', 0);
  $pdfReporte->Ln(4);
  $pdfReporte->SetFont('Arial', '', 7);
  foreach ($arrayordenventa as $key) {
    $pdfReporte->setX(4);
    $pdfReporte->Cell(43, 3, strtolower(substr(utf8_decode('- ' . $key['detalle_descripcion'] . ': ' . $key['detalle_notas']), 0, 40)), 0, 'L');
    $pdfReporte->setX(43);
    $pdfReporte->Ln(3);
  }

  /*    $pdfReporte->Ln(3);
    $pdfReporte->SetFont('Arial','',6);
    $pdfReporte->setX(4);
    $pdfReporte->Cell(70,3,utf8_decode("*** GRACIAS POR SU PREFERENCIA ***"),0,0,'C',0);
    $pdfReporte->Ln(5); */

  if ($estado == 3) {
    $pdfReporte->Image("resources/global/images/anulado.png", 15, 30, -150);
  }

  $pdfReporte->Output();
} catch (\Exception $e) {

  $pdfReporte = new PDF($orientation = 'P', $unit = 'mm', array(85, 180));
  $pdfReporte->AliasNbPages();
  $pdfReporte->AddPage();
  $pdfReporte->setY(10);
  $pdfReporte->setX(4);
  $pdfReporte->SetFont('Arial', 'B', 12);
  $pdfReporte->Cell(12, 3, (utf8_decode($e->getMessage())), 0, 0, 'L', 0);
  $pdfReporte->Output();
}


function obtenerUrl($ruta, $token, $data_json)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $ruta);
  curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array(
      'Authorization: Token token="' . $token . '"',
      'Accept: application/json',
      'Content-Type: application/json',
    )
  );
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $respuesta  = curl_exec($ch);
  curl_close($ch);
  return $respuesta;
}
