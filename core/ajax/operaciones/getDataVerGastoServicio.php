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
    $key = $Resultado["data"];

    $response = [
      "error" => "NO",
      "message" => "Success",
      "data" => [
        "id_gasto_servicio" => isset($key['id_gasto_servicio']) ? $key['id_gasto_servicio'] : "",
        "id_proveedor" => isset($key['id_proveedor']) ? $key['id_proveedor'] : "",
        "name_proveedor" => isset($key['nombre_proveedor']) ? $key['nombre_proveedor'] : "No disponible",
        "src_imagen_proveedor" => isset($key['src_imagen_proveedor']) ? $key['src_imagen_proveedor'] : "resources/global/images/sin_imagen.png",
        "fecha_emision" => isset($key['fecha_emision']) ? date('Y-m-d', strtotime($key['fecha_emision'])) : "",
        "id_tipo_gasto" => isset($key['id_tipo_gasto']) ? $key['id_tipo_gasto'] : "",
        "id_documento_venta" => isset($key['id_documento_venta']) ? $key['id_documento_venta'] : "",
        "serie" => isset($key['serie']) ? $key['serie'] : "",
        "correlativo" => isset($key['correlativo']) ? $key['correlativo'] : "",
        "estado" => isset($key['estado']) ? $key['estado'] : "0",
        "id_moneda" => isset($key['id_moneda']) ? $key['id_moneda'] : "",
        "total" => isset($key['total']) ? $key['total'] : "0.00",
        "detalles" => isset($key['detalles']) ? $key['detalles'] : []
      ]
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
