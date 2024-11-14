<?php

  $id_orden_compra = isset($_POST["id_orden_compra"]) ? $_POST["id_orden_compra"] : "";
  $id_proveedor = isset($_POST["id_proveedor"]) ? $_POST["id_proveedor"] : "";
  $id_metodo_envio = isset($_POST["id_metodo_envio"]) ? $_POST["id_metodo_envio"] : "";
  $codigo_moneda = isset($_POST["codigo_moneda"]) ? $_POST["codigo_moneda"] : "";
  $fecha_orden = isset($_POST["fecha_orden"]) ? $_POST["fecha_orden"] : "";
  $fecha_entrega = isset($_POST["fecha_entrega"]) ? $_POST["fecha_entrega"] : "";
  $observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : "";
  $array_detalle = isset($_POST["array_detalle"]) ? $_POST["array_detalle"] : null;
  $detalle_compra = json_decode($array_detalle);
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";
  $id_trabajador = isset($_SESSION["id_trabajador"]) ? $_SESSION["id_trabajador"] : "";
  $id_sucursal = isset($_SESSION["id_sucursal"]) ? $_SESSION["id_sucursal"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordencompra"));
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

    if (empty(trim($id_metodo_envio))) {
      throw new Exception("Campo obligatorio : Método de envío.");
    }

    if (empty(trim($codigo_moneda))) {
      throw new Exception("Campo obligatorio : Moneda.");
    }

    if (empty(trim($id_proveedor))) {
      throw new Exception("Campo obligatorio : Tiene que seleccionar el proveedor.");
    }

    if (empty(trim($id_trabajador))) {
      throw new Exception("Campo obligatorio : Tiene que seleccionar el trabajador.");
    }

    if (empty(trim($id_sucursal))) {
      throw new Exception("Campo obligatorio : Tiene que seleccionar una sucursal.");
    }

    if (empty(trim($fecha_orden))) {
      throw new Exception("Campo obligatorio : Fecha de Orden.");
    }

    if (empty(trim($fecha_entrega))) {
      throw new Exception("Campo obligatorio : Fecha de Entrega.");
    }

    if ($array_detalle==null) {
      throw new Exception("1. No se recibió los detalles de la orden.");
    }

    if (count($detalle_compra->datos)==0) {
      throw new Exception("2. No se recibió los detalles de la orden.");
    }

    require_once "core/models/ClassOrdenCompra.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_ORDEN_COMPRA->insert($id_sucursal,$id_orden_compra,$id_proveedor,$id_trabajador,$id_metodo_envio,$codigo_moneda,$fecha_orden,$fecha_entrega,$observaciones,$detalle_compra);
        break;
      case 'edit':
        $VD = $OBJ_ORDEN_COMPRA->update($id_sucursal,$id_orden_compra,$id_proveedor,$id_trabajador,$id_metodo_envio,$codigo_moneda,$fecha_orden,$fecha_entrega,$observaciones,$detalle_compra);
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
