<?php

  $id_orden_compra = isset($_POST["id_orden_compra"]) ? $_POST["id_orden_compra"] : "";
  $id_trabajador = isset($_SESSION["id_trabajador"]) ? $_SESSION["id_trabajador"] : "";
  $id_tipo_docu = isset($_POST["id_tipo_docu"]) ? $_POST["id_tipo_docu"] : "";
  $id_sucursal = isset($_SESSION["id_sucursal"]) ? $_SESSION["id_sucursal"] : "";
  $num_documento = isset($_POST["num_documento"]) ? $_POST["num_documento"] : "";
  $observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : "";
  $array_detalle = isset($_POST["array_detalle"]) ? $_POST["array_detalle"] : null;
  $detalle_compra = json_decode($array_detalle);

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ingreso"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_agregar']==false) {
        throw new Exception("No tienes permisos para registrar ingresos.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if (empty(trim($id_orden_compra))) {
      throw new Exception("Campo obligatorio : Id. Orden de Compra.");
    }

    if (empty(trim($id_trabajador))) {
      throw new Exception("Campo obligatorio : Id. Trabajador.");
    }

    if (empty(trim($id_sucursal))) {
      throw new Exception("Campo obligatorio : Seleccionar sucursal.");
    }

    if (empty(trim($id_tipo_docu))) {
      throw new Exception("Campo obligatorio : Seleccionar el tipo de documento.");
    }

    if (empty(trim($num_documento))) {
      throw new Exception("Campo obligatorio : Tiene que ingresar un número de documento.");
    }

    if ($array_detalle==null) {
      throw new Exception("1. No se recibió los detalles de la orden.");
    }

    if (count($detalle_compra->datos)==0) {
      throw new Exception("2. No se recibió los detalles de la orden.");
    }

    require_once "core/models/ClassIngreso.php";
    $VD = $OBJ_INGRESO->insert($id_sucursal,$id_trabajador,$id_orden_compra,$id_tipo_docu,$num_documento,$observaciones,$detalle_compra);

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
