<?php

  $id_trabajador = isset($_POST['id_trabajador']) ? $_POST['id_trabajador'] : 0;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("accesosucursal"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassAccesoSucursal.php";
    $Resultado = $OBJ_ACCESO_SUCURSAL->getPermisosSucursal($id_trabajador);

    if ($Resultado["error"]=="NO") {
      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_sucursal" => $key['id_sucursal'],
          "opcion" => '<label class="container-label"><input type="checkbox" checked="checked"><span class="checkmark"></span></label>',
        );
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
