<?php

$id_gasto_servicio = isset($_POST["id_gasto_servicio"]) ? $_POST["id_gasto_servicio"] : "";

try {

  if (empty($id_gasto_servicio)) {
    $response = [
      "error" => "SI",
      "message" => "No se recibió el campo id.",
      "data" => null
    ];
    echo json_encode($response);
    exit();
  }

  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("gastoservicio"));

  if (!isset($access_options[0]) || $access_options[0]['error'] != "NO") {
    throw new Exception("Error al validar los permisos.");
  }
  if ($access_options[0]['flag_anular'] == false) {
    throw new Exception("No tienes permiso para anular este registro.");
  }

  require_once "core/models/ClassGastoServicio.php";
  $VD = $OBJ_GASTO_SERVICIO->delete($id_gasto_servicio);

  if ($VD != "OK") {
    throw new Exception($VD);
  }

  $response = [
    "error" => "NO",
    "message" => "Registro anulado correctamente.",
    "id_anulado" => $id_gasto_servicio
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
