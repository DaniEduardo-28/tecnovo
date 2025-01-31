<?php

$id_cronograma = $_POST['id_cronograma_pago'] ?? null;
$fecha_pago = $_POST['fecha_pago'] ?? null;
$metodo_pago = $_POST['metodo_pago'] ?? null;
$monto = $_POST['monto'] ?? null;

try {

  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("citas"));
  if ($access_options[0]['error'] == "NO") {
    if ($access_options[0]['flag_agregar'] == false) {
      throw new Exception("No tienes permisos para registrar pagos.");
    }
  } else {
    throw new Exception("Error al verificar los permisos.");
  }

  require_once "core/models/ClassCronograma.php";
  $VD = $OBJ_CRONOGRAMA->addPagos($id_cronograma, $metodo_pago, $fecha_pago, $monto);

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
