<?php

  try {

    $id_venta = isset($_POST["id_venta"])	? $_POST["id_venta"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordenventa"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_ver']==false) {
        throw new Exception("No tienes permisos para ver este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_venta=="") {
      throw new Exception("No se recibió el parámetro id orden compra.");
    }

    require_once "core/models/ClassOrdenVenta.php";
    $Resultado = $OBJ_ORDEN_VENTA->getDataVerOrdenVenta($id_venta);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_venta" => $key['id_venta'],
          "id_sucursal" => $key['id_sucursal'],
          "id_trabajador" => $key['id_trabajador'],
          "id_documento_venta" => $key['id_documento_venta'],
          "name_documento_venta" => $key['name_documento_venta'],
          "codigo_documento_venta" => $key['codigo_documento_venta'],
          "serie" => $key['serie'],
          "correlativo" => $key['correlativo'],
          "id_documento_cliente" => $key['id_documento_cliente'],
          "name_documento_cliente" => $key['name_documento_cliente'],
          "codigo_documento_cliente" => $key['codigo_documento_cliente'],
          "numero_documento_cliente" => $key['numero_documento_cliente'],
          "id_forma_pago" => $key['id_forma_pago'],
          "codigo_forma_pago" => $key['codigo_forma_pago'],
          "name_forma_pago" => $key['name_forma_pago'],
          "cliente" => $key['cliente'],
          "direccion" => $key['direccion'],
          "telefono" => $key['telefono'],
          "correo" => $key['correo'],
          "fecha" => date('Y-m-d', strtotime($key['fecha'])),
          "fecha_vencimiento" => date('Y-m-d', strtotime($key['fecha_vencimiento'])),
          "descuento_total" => $key['descuento_total'],
          "sub_total" => $key['sub_total'],
          "igv" => $key['igv'],
          "total" => $key['total'],
          "estado" => $key['estado'],
          "pdf" => $key['pdf'],
          "xml" => $key['xml'],
          "cdr" => $key['cdr'],
          "ruta" => $key['ruta'],
          "token" => $key['token'],
          "flag_doc_interno" => $key['flag_doc_interno'],
          "monto_recibido" => $key['monto_recibido'],
          "vuelto" => $key['vuelto'],
          "id_moneda" => $key['id_moneda'],
          "codigo_moneda" => $key['codigo_moneda'],
          "signo_moneda" => $key['signo_moneda'],
          "abreviatura_moneda" => $key['abreviatura_moneda'],
          "signo_moneda_cambio" => $key['signo_moneda_cambio'],
          "monto_tipo_cambio" => $key['monto_tipo_cambio'],
          "observaciones" => $key['observaciones'],
          "flag_enviado" => $key['flag_enviado'],
          "detalle_name_tabla" => $key['detalle_name_tabla'],
          "detalle_cod_producto" => $key['detalle_cod_producto'],
          "detalle_descripcion" => $key['detalle_descripcion'],
          "detalle_cantidad" => $key['detalle_cantidad'],
          "detalle_precio_unitario" => $key['detalle_precio_unitario'],
          "detalle_descuento" => $key['detalle_descuento'],
          "detalle_sub_total" => $key['detalle_sub_total'],
          "detalle_tipo_igv" => $key['detalle_tipo_igv'],
          "detalle_igv" => $key['detalle_igv'],
          "detalle_total" => $key['detalle_total'],
          "notas" => $key['notas'],
        );
      }

      $data["error"] = "NO";
      $data["message"] = "Success";
      $data["data"] = $retorno_array;
      echo json_encode($data);

    }else {
      throw new Exception($Resultado["message"]);
    }

  } catch (\Exception $e) {
    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
  }

 ?>
