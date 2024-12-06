<?php

$id_ingreso = $_POST['id_ingreso_pago'] ?? null;
$fecha_pago = $_POST['fecha_pago'] ?? null;
$id_forma_pago = $_POST['id_forma_pago'] ?? null;
$monto_pagado = $_POST['monto_pagado'] ?? null;

try {

  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ingreso"));
  if ($access_options[0]['error'] == "NO") {
    if ($access_options[0]['flag_agregar'] == false) {
      throw new Exception("No tienes permisos para registrar ingresos.");
    }
  } else {
    throw new Exception("Error al verificar los permisos.");
  }
  require_once "core/models/ClassIngreso.php";
  $VD = $OBJ_INGRESO->addPagos($id_ingreso, $id_forma_pago, $fecha_pago, $monto_pagado);

  if ($VD != "OK") {
    throw new Exception($VD);
  }

  $data["error"] = "NO";
  $data["message"] = "Operación realizada correctamente.";
  $data["data"] = null;
  echo json_encode($data);

} catch (\Exception $e) {

  $data["error"] = "SI";
  $data["message"] = $e->getMessage();
  $data["data"] = null;
  echo json_encode($data);

}
