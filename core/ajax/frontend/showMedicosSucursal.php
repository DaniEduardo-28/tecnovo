<?php

  $id_sucursal = isset($_POST['id_sucursal']) ? $_POST['id_sucursal'] : 0;

  try {

    if (!isset($_SESSION['id_cliente'])) {
      throw new Exception("Para realizar esta operación tiene que iniciar sesión.");
    }

    require_once "admin/core/models/ClassAccesoSucursal.php";
    $Resultado = $OBJ_ACCESO_SUCURSAL->getAccesoTrabajadorSucursal($id_sucursal);

    if ($Resultado["error"]=="NO") {
      foreach ($Resultado["data"] as $key) {
        if ($key['flag_medico']=="1") {
          $retorno_array[] =array(
            "id_trabajador" => $key['id_trabajador'],
            "nombres" => $key['nombres_trabajador'],
            "apellidos" => $key['apellidos_trabajador'],
            "name_especialidad" => $key['name_especialidad'],
          );
        }
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
