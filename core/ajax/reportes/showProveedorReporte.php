<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 10;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $id_documento = isset($_POST["id_documento"])	? $_POST["id_documento"]	: "";
    $id_proveedor = isset($_SESSION['id_proveedor']) ? $_SESSION['id_proveedor'] : "0";
    $estado = isset($_POST["estado"])	? $_POST["estado"]	: "all";
    $tipo_busqueda = isset($_POST["id_sucursal"])	? $_POST["id_sucursal"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("vistareporteproveedor"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
      if ($access_options[0]['flag_descargar']) {
        $id_proveedor = "all";
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassProveedor.php";
    $Resultado = $OBJ_PROVEEDOR->showReporte("all","","");

    if ($Resultado["error"]=="NO") {

      $options="";
      $count = 1;
    foreach ($Resultado["data"] as $key) {

      $retorno_array[] =array(
        "num" => $count + $offset,
        "id_proveedor" => $key['id_proveedor'],
        "numero_documento" => $key['numero_documento'],
        "nombre_proveedor" => $key['nombre_proveedor'],
        "apodo" => $key['apodo'],
        "direccion" => $key['direccion'],
        "telefono" => $key['telefono'],
        "estado" => $key['estado']
      );
      $count++;
    }

    $data["error"] = "NO";
    $data["message"] = "Success";
    $data["data"] = $retorno_array;
    echo json_encode($data);

  }else {
    throw new Exception($Resultado["message"]);
  }

} catch (\Exception $e) {
  $data["error"]="SI";
  $data["message"]=$e->getMessage();
  $data["data"] = null;
  echo json_encode($data);
  exit();
}

 ?>
