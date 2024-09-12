<?php

  $id_proveedor = isset($_POST["id_proveedor"]) ? $_POST["id_proveedor"] : 0;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("observacionesproveedor"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_ver']==false) {
        throw new Exception("No tienes permisos para ver esta información.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassProveedor.php";
    $Resultado = $OBJ_PROVEEDOR->showObservacionesProveedor($id_proveedor);

    if ($Resultado["error"]=="NO") {
      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $options="";
        if ($access_options[0]['flag_eliminar']) {
          $options.='<a href="javascript:eliminarObservacion(' . $key['id_detalle'] . ')" class="btn btn-icon btn-outline-danger btn-round"><i class="ti ti-close"></i></a>';
        }
        $retorno_array[] =array(
          "num" => "$count",
          "id_detalle" => $key['id_detalle'],
          "id_proveedor" => $key['id_proveedor'],
          "observacion" => $key['observacion'],
          "fecha" => date('d/m/Y H:i', strtotime($key['fecha'])),
          "options" => "$options"
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
