<?php

  $id_orden_gasto = isset($_POST["id_orden_gasto"]) ? $_POST["id_orden_gasto"] : "";
  $id_proveedor = isset($_POST["id_proveedor"]) ? $_POST["id_proveedor"] : "";
  $codigo_moneda = isset($_POST["codigo_moneda"]) ? $_POST["codigo_moneda"] : "";
  $fecha_gasto = isset($_POST["fecha_gasto"]) ? $_POST["fecha_gasto"] : "";
  $observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : "";
  $array_detalle = isset($_POST["array_detalle"]) ? $_POST["array_detalle"] : null;
  $detalle_gasto = json_decode($array_detalle);
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";
  $id_trabajador = isset($_SESSION["id_trabajador"]) ? $_SESSION["id_trabajador"] : "";
 
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
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }


    if (empty(trim($codigo_moneda))) {
      throw new Exception("Campo obligatorio : Moneda.");
    }

    if (empty(trim($id_proveedor))) {
      throw new Exception("Campo obligatorio : Tiene que seleccionar el proveedor.");
    }

    if (empty(trim($fecha_gasto))) {
      throw new Exception("Campo obligatorio : Fecha de Gasto.");
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
        $VD = $OBJ_ORDEN_GASTO->insert($id_orden_gasto,$id_proveedor,$id_trabajador,$codigo_moneda,$fecha_gasto,$observaciones,$detalle_gasto);
        break;
      case 'edit':
        $VD = $OBJ_ORDEN_GASTO->update($id_orden_gasto,$id_proveedor,$id_trabajador,$codigo_moneda,$fecha_gasto,$observaciones,$detalle_gasto);
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
