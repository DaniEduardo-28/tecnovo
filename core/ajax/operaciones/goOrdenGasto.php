<?php

  $id_orden_gasto = isset($_POST["id_orden_gasto"]) ? $_POST["id_orden_gasto"] : "";
  $id_proveedor = isset($_POST["id_proveedor"]) ? $_POST["id_proveedor"] : "";
  $id_gasto = isset($_POST["id_gasto"]) ? $_POST["id_gasto"] : "";
  $codigo_moneda = isset($_POST["codigo_moneda"]) ? $_POST["codigo_moneda"] : "";
  $fecha_gasto = isset($_POST["fecha_gasto"]) ? $_POST["fecha_gasto"] : "";
  $observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : "";
  $array_detalle = isset($_POST["array_detalle"]) ? $_POST["array_detalle"] : null;
  $detalle_compra = json_decode($array_detalle);
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";
  $id_trabajador = isset($_SESSION["id_trabajador"]) ? $_SESSION["id_trabajador"] : "";
  $id_gasto = isset($_SESSION["id_gasto"]) ? $_SESSION["id_gasto"] : "";
  $precio_unit = isset($_POST["precio_unit"]) ? $_POST["precio_unit"] : null;
  $cantidad_ga = isset($_POST["cantidad_ga"]) ? $_POST["cantidad_ga"] : null;

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

    /* if (empty(trim($id_gasto))) {
      throw new Exception("Campo obligatorio : Gasto.");
    } */

    if (empty(trim($codigo_moneda))) {
      throw new Exception("Campo obligatorio : Moneda.");
    }

    if (empty(trim($id_proveedor))) {
      throw new Exception("Campo obligatorio : Tiene que seleccionar el proveedor.");
    }

    /* if (empty(trim($id_trabajador))) {
      throw new Exception("Campo obligatorio : Tiene que seleccionar el trabajador.");
    } */

    require_once "core/models/ClassOrdenGasto.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_ORDEN_GASTO->insert($id_proveedor,$id_orden_gasto,$id_gasto,$id_trabajador,$codigo_moneda,$fecha_gasto,$observaciones,$precio_unit,$cantidad_ga);
        break;
      case 'edit':
        $VD = $OBJ_ORDEN_GASTO->update($id_proveedor,$id_orden_gasto,$id_gasto,$id_trabajador,$codigo_moneda,$fecha_gasto,$observaciones,$precio_unit,$cantidad_ga);
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
