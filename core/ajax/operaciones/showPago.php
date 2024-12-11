<?php

try {

  $id_ingreso = isset($_POST["id_ingreso_pago"]) ? $_POST["id_ingreso_pago"] : null;

  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ingreso"));
  if ($access_options[0]['error'] == "NO") {
    if ($access_options[0]['flag_buscar'] == false) {
      throw new Exception("No tienes permisos para realizar busquedas.");
    }
  } else {
    throw new Exception("Error al verificar los permisos.", 1);
  }

  require_once 'core/models/ClassIngreso.php';
  $DataCantidad = $OBJ_INGRESO->getCountPagos($id_ingreso);

  if ($DataCantidad["error"] == "NO") {

    $cantidad = $DataCantidad["data"][0]["cantidad"];
    $Resultado = $OBJ_INGRESO->getPagos($id_ingreso);
    $count = 1;
    foreach ($Resultado["data"] as $key) {
      $flag_eliminar = '<a href="javascript:deleteRegistro(' . $key['id_pago'] . ",'" . str_replace('"', ' ', str_replace("'", ' ', $key['name_forma_pago'])) . "'" . ')" class="btn btn-icon btn-outline-danger btn-round"><i class="ti ti-close"></i></a>';
      $retorno_array[] = array(
        "num" => "$count",
        "id_pago" => $key['id_pago'],
        "fecha_pago" => $key['fecha_pago'],
        "name_forma_pago" => $key['name_forma_pago'],
        "monto_pagado" => $key['monto_pagado'],
        "src_factura" => $key['src_factura'],
        "total_ing" => $key['total_ing'],
        "flag_eliminar" => "$flag_eliminar"
      );
      $count++;
    }
    $data["error"] = "NO";
    $data["message"] = "Success";
    $data["cantidad"] = $cantidad;
    $data["data"] = $retorno_array ?? [];
    echo json_encode($data);
  } else {
    throw new Exception($DataCantidad["message"]);
  }
} catch (\Exception $e) {
  $data["error"] = "SI";
  $data["message"] = $e->getMessage();
  $data["data"] = null;
  echo json_encode($data);
}
