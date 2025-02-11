<?php

try {

  $id_gasto_servicio = isset($_POST["id_gasto_servicio"]) ? $_POST["id_gasto_servicio"] : "";

  if (empty($id_gasto_servicio)) {
    $response = [
      "error" => "SI",
      "message" => "No se recibió el parámetro id gasto servicio.",
      "data" => null
    ];
    echo json_encode($response);
    exit();
  }

  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("gastoservicio"));

  if (!isset($access_options[0]) || $access_options[0]['error'] != "NO") {
    throw new Exception("Error al verificar los permisos.");
  }
  if ($access_options[0]['flag_ver'] == false) {
    throw new Exception("No tienes permisos para ver este registro.");
  }

  require_once "core/models/ClassGastoServicio.php";
  $Resultado = $OBJ_GASTO_SERVICIO->getDataVerGastoServicio($id_gasto_servicio);

  if ($Resultado["error"] == "NO") {
    $retorno_array = [];
    foreach ($Resultado["data"] as $key) {
      $retorno_array[] = array(
        "id_gasto_servicio" => $key['id_gasto_servicio'],
        "id_proveedor" => $key['id_proveedor'],
        "name_proveedor" => $key['nombre_proveedor'],
        "src_imagen_proveedor" => $key['src_imagen_proveedor'],
        "fecha_emision" => date('Y-m-d', strtotime($key['fecha_emision'])),
        "observaciones" => $key['observaciones'],
        "estado" => $key['estado'],
        "id_moneda" => $key['id_moneda'],
        "total" => $key['total']
      );
    }

    $response = [
      "error" => "NO",
      "message" => "Success",
      "data" => $retorno_array
    ];
    echo json_encode($response);
  } else {
    throw new Exception($Resultado["message"]);
  }
} catch (Exception $e) {
  $response = [
    "error" => "SI",
    "message" => $e->getMessage(),
    "data" => null
  ];
  echo json_encode($response);
  exit();
}
