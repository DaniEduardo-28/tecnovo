<?php

  $id_venta = isset($_POST["id_venta"]) ? $_POST["id_venta"] : null;
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";
  $codigo_documento_venta = isset($_POST["codigo_documento_venta"]) ? $_POST["codigo_documento_venta"] : null;
  $serie = isset($_POST["serie"]) ? $_POST["serie"] : null;
  $correlativo = isset($_POST["correlativo"]) ? $_POST["correlativo"] : null;
  $codigo_documento_cliente = isset($_POST["codigo_documento_cliente"]) ? $_POST["codigo_documento_cliente"] : null;
  $numero_documento_cliente = isset($_POST["numero_documento_cliente"]) ? $_POST["numero_documento_cliente"] : null;
  $nombres = isset($_POST["nombres"]) ? $_POST["nombres"] : null;
  $apellidos = isset($_POST["apellidos"]) ? $_POST["apellidos"] : null;
  $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : null;
  $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : null;
  $correo = isset($_POST["correo"]) ? $_POST["correo"] : null;
  $fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : null;
  $codigo_moneda = isset($_POST["codigo_moneda"]) ? $_POST["codigo_moneda"] : null;
  $codigo_forma_pago = isset($_POST["codigo_forma_pago"]) ? $_POST["codigo_forma_pago"] : null;
  $total_descuento = isset($_POST["total_descuento"]) ? $_POST["total_descuento"] : null;
  $total_gravada = isset($_POST["total_gravada"]) ? $_POST["total_gravada"] : null;
  $total_igv = isset($_POST["total_igv"]) ? $_POST["total_igv"] : null;
  $total_total = isset($_POST["total_total"]) ? $_POST["total_total"] : null;
  $array_detalle = isset($_POST["array_detalle"]) ? $_POST["array_detalle"] : null;
  $detalle_venta = json_decode($array_detalle);
  $id_trabajador = isset($_SESSION["id_trabajador"]) ? $_SESSION["id_trabajador"] : 0;
  $id_sucursal = isset($_SESSION["id_sucursal"]) ? $_SESSION["id_sucursal"] : 0;

  $monto_recibido = isset($_POST["monto_recibido"]) ? $_POST["monto_recibido"] : 0;
  $vuelto = isset($_POST["vuelto"]) ? $_POST["vuelto"] : 0;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordenventa"));
    if ($access_options[0]['error']=="NO") {
      switch ($accion) {
        case 'add':
          if ($access_options[0]['flag_agregar']==false) {
            throw new Exception("No tienes permisos para registrar la orden.");
          }
          break;
        case 'edit':
          if ($access_options[0]['flag_editar']==false) {
            throw new Exception("No tienes permisos para modificar la orden.");
          }
          break;
        default:
          throw new Exception("Acción no recibida.");
          break;
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if (empty(trim($codigo_documento_venta))) {
      throw new Exception("Campo obligatorio : Documento de venta.");
    }

    if (empty(trim($codigo_documento_cliente))) {
      throw new Exception("Campo obligatorio : Documento de Cliente.");
    }

    if (empty(trim($numero_documento_cliente))) {
      throw new Exception("Campo obligatorio : Número de Documento Cliente.");
    }

    if (empty(trim($nombres))) {
      throw new Exception("Campo obligatorio : Nombres ó Razón Social del Cliente.");
    }

    if (empty(trim($codigo_moneda))) {
      throw new Exception("Campo obligatorio : Moneda.");
    }

    if (empty(trim($codigo_forma_pago))) {
      throw new Exception("Campo obligatorio : Método de Pago.");
    }

    if ($array_detalle==null) {
      throw new Exception("1. No se recibió los detalles de la orden de venta.");
    }

    if (count($detalle_venta->datos)==0) {
      throw new Exception("2. No se recibió los detalles de la orden de venta.");
    }

    require_once "core/models/ClassDocumentoIdentidad.php";
    $resultDoc1 = $OBJ_DOCUMENTO_IDENTIDAD->getDocumentoForId($codigo_documento_cliente);
    if ($resultDoc1['error']=="SI") {
      throw new Exception($resultDoc1['message']);
    }

    $dataResultDoc1 = $resultDoc1['data'];

    if ($dataResultDoc1[0]['flag_exacto']=="1") {
      if ($dataResultDoc1[0]['size']!=strlen($numero_documento_cliente)) {
        throw new Exception("El número de documento de identidad tiene que tener " . $dataResultDoc1[0]['size'] . " dígitos.");
      }
    }else {
      if ($dataResultDoc1[0]['size']<strlen($numero_documento_cliente)) {
        throw new Exception("El documento de identidad tiene que ser menor o igual de " . $dataResultDoc1[0]['size'] . " dígitos.");
      }
    }

    if ($dataResultDoc1[0]['flag_numerico']=="1") {
      if (validar_number($numero_documento_cliente)==false) {
        throw new Exception("El documento de identidad tiene que ser sólo números.");
      }
    }

    if (strtoupper($dataResultDoc1[0]['name_documento'])=="RUC") {
      if (empty(trim($direccion))) {
        throw new Exception("Campo obligatorio : Dirección del cliente obligatorio para RUC.");
      }
    }

    require_once "core/models/ClassOrdenVenta.php";
    require_once "core/models/ClassMoneda.php";
    $tipo_cambio = $OBJ_MONEDA->getTipoCambio($codigo_moneda);

    $VD;
    switch ($accion) {
      case 'add':
        $VD = $OBJ_ORDEN_VENTA->insert($id_venta,$codigo_documento_venta,$serie,$correlativo,$codigo_documento_cliente,$numero_documento_cliente,$nombres,$apellidos,$direccion,$telefono,$correo,$fecha,$codigo_moneda,$codigo_forma_pago,$total_descuento,$total_gravada,$total_igv,$total_total,$detalle_venta,$id_trabajador,$id_sucursal,$monto_recibido,$vuelto,$tipo_cambio);
        break;
      case 'edit':
        $VD = $OBJ_ORDEN_VENTA->update($id_venta,$codigo_documento_venta,$serie,$correlativo,$codigo_documento_cliente,$numero_documento_cliente,$nombres,$apellidos,$direccion,$telefono,$correo,$fecha,$codigo_moneda,$codigo_forma_pago,$total_descuento,$total_gravada,$total_igv,$total_total,$detalle_venta,$id_trabajador,$id_sucursal,$monto_recibido,$vuelto,$tipo_cambio);
        break;
      default:
        $VD1['error'] = "SI";
        $VD1['message'] = "No se encontró la operación a realizar";
        $VD = $VD1;
        break;
    }

    if ($VD['error']=="SI") {
      throw new Exception($VD['message']);
    }

    $data["error"]="NO";
    $data["message"]=$VD['message'];
    $data["id_venta"] = $VD['id_venta'];
    $data["serie"] = $VD['serie'];
    $data["correlativo"] = $VD['correlativo'];
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    echo json_encode($data);

  }

 ?>
