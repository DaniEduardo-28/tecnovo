<?php

  $id_orden_gasto = isset($_POST["id_orden_gasto"]) ? $_POST["id_orden_gasto"] : "";
  $id_documento_venta = isset($_POST["id_documento_venta"]) ? $_POST["id_documento_venta"] : "";
  $id_proveedor = isset($_POST["id_proveedor"]) ? $_POST["id_proveedor"] : "";
  $id_moneda = isset($_POST["id_moneda"]) ? $_POST["id_moneda"] : "";
  $fecha_orden = isset($_POST["fecha_orden"]) ? $_POST["fecha_orden"] : "";
  $fecha_entrega = isset($_POST["fecha_entrega"]) ? $_POST["fecha_entrega"] : "";
  $array_detalle = isset($_POST["array_detalle"]) ? $_POST["array_detalle"] : null;
  $detalle_gasto = json_decode($array_detalle);
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordengasto"));
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

    if (empty(trim($id_moneda))) {
      throw new Exception("Campo obligatorio : Moneda.");
    }

    if (empty(trim($id_proveedor))) {
      throw new Exception("Campo obligatorio : Tiene que seleccionar el proveedor.");
    }

    if (empty(trim($fecha_gasto))) {
      throw new Exception("Campo obligatorio : Fecha de Orden.");
    }

    if ($array_detalle==null) {
      throw new Exception("1. No se recibió los detalles de la orden.");
    }

    if (count($detalle_gasto->datos)==0) {
      throw new Exception("2. No se recibió los detalles de la orden.");
    }

    require_once "core/models/ClassOrdenGasto.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_ORDEN_GASTO->insert($id_orden_gasto,$id_documento_venta,$id_proveedor,$id_moneda,$fecha_gasto,$serie,$correlativo,$descuento_total,$sub_total,$igv_total,$monto_total,$monto_recibido,$vuelto,$detalle_gasto);
        break;
      case 'edit':
        $VD = $OBJ_ORDEN_GASTO->update($id_orden_gasto,$id_documento_venta,$id_proveedor,$id_moneda,$fecha_gasto,$serie,$correlativo,$descuento_total,$sub_total,$igv_total,$monto_total,$monto_recibido,$vuelto,$detalle_gasto);
        break;
      default:
        $VD = "No se recibió parametro de acción.";
        break;
    }

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Operación realizada correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

?>
