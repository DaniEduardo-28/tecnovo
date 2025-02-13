
<?php

$id_gasto_servicio = isset($_POST["id_gasto_servicio"]) ? $_POST["id_gasto_servicio"] : "";
$id_proveedor = isset($_POST["id_proveedor"]) ? $_POST["id_proveedor"] : "";
$codigo_moneda = isset($_POST["codigo_moneda"]) ? $_POST["codigo_moneda"] : "";
$fecha_emision = isset($_POST["fecha_emision"]) ? $_POST["fecha_emision"] : "";
$serie = isset($_POST["serie"]) ? $_POST["serie"] : "";
$correlativo = isset($_POST["correlativo"]) ? $_POST["correlativo"] : "";
$array_detalle = isset($_POST["array_detalle"]) ? $_POST["array_detalle"] : null;
$detalle_gastoserv = json_decode($array_detalle);
$observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : "";
$id_documento_venta = isset($_POST["id_documento_venta"]) ? $_POST["id_documento_venta"] : "0";
$accion = isset($_POST["accion"]) ? $_POST["accion"] : "";
$id_trabajador = isset($_SESSION["id_trabajador"]) ? $_SESSION["id_trabajador"] : "";
$id_sucursal = isset($_SESSION["id_sucursal"]) ? $_SESSION["id_sucursal"] : "";

try {

  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("gastoservicio"));
  if (!isset($access_options[0]) || $access_options[0]['error'] != "NO") {
    throw new Exception("Error al verificar los permisos.");
  }

  switch ($accion) {
    case 'add':
      if ($access_options[0]['flag_agregar'] == false) {
        throw new Exception("No tienes permisos para registrar el gasto de servicio.");
      }
      break;
    case 'edit':
      if ($access_options[0]['flag_editar'] == false) {
        throw new Exception("No tienes permisos para modificar el gasto de servicio.");
      }
      break;
    default:
      throw new Exception("Acción no recibida.");
      break;
  }

  if (empty(trim($codigo_moneda))) {
    throw new Exception("Campo obligatorio: Moneda.");
  }

  if (empty(trim($id_proveedor))) {
    throw new Exception("Campo obligatorio: Tiene que seleccionar el proveedor.");
  }

  if (empty(trim($id_trabajador))) {
    throw new Exception("Campo obligatorio: Tiene que seleccionar el trabajador.");
  }

  if (empty(trim($id_sucursal))) {
    throw new Exception("Campo obligatorio: Tiene que seleccionar una sucursal.");
  }

  if (empty(trim($serie))) {
    throw new Exception("Campo obligatorio: Serie.");
  }

  if ($array_detalle == null) {
    throw new Exception("1. No se recibió los detalles del gasto.");
  }

  foreach ($detalle_gastoserv->datos as $detalle) {
    if (!isset($detalle->id_tipo_gasto) || intval($detalle->id_tipo_gasto) <= 0) {
        throw new Exception("Uno o más registros del detalle no tienen un id_tipo_gasto válido.");
    }
}

  require_once "core/models/ClassGastoServicio.php";
  $VD = "";

  switch ($accion) {
    case 'add':
      $VD = $OBJ_GASTO_SERVICIO->insert(
        $id_sucursal, $id_proveedor, $id_trabajador, 
        $observaciones, $codigo_moneda, $id_documento_venta, $fecha_emision, 
        $serie, $correlativo, $detalle_gastoserv
      );
      break;
    case 'edit':
      $VD = $OBJ_GASTO_SERVICIO->update(
        $id_sucursal, $id_gasto_servicio, $id_proveedor, $id_trabajador, 
        $observaciones, $codigo_moneda, $id_documento_venta, $fecha_emision, 
        $serie, $correlativo, $detalle_gastoserv
      );
      break;
    default:
      throw new Exception("No se recibió parámetro de acción.");
      break;
  }

  if ($VD != "OK") {
    throw new Exception($VD);
  }

  $response = [
    "error" => "NO",
    "message" => "Operación realizada correctamente.",
    "data" => null
  ];
  echo json_encode($response);
} catch (Exception $e) {
  $response = [
    "error" => "SI",
    "message" => $e->getMessage(),
    "data" => null
  ];
  echo json_encode($response);
}
