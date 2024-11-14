<?php

  $id_trabajador = isset($_POST['id_trabajador']) ? $_POST['id_trabajador'] : 0;

  try {

    if (!isset($_SESSION['id_cliente'])) {
      throw new Exception("Para realizar esta operación tiene que iniciar sesión.");
    }

    if ($id_trabajador==0) {
      throw new Exception("Error, no se recibió el parametro id médico.");
    }

    require_once "admin/core/models/ClassTrabajadorServicio.php";
    $Resultado = $OBJ_TRABAJADOR_SERVICIO->show($id_trabajador);

    if ($Resultado["error"]=="NO") {
      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_servicio" => $key['id_servicio'],
          "name_servicio" => $key['name_servicio'],
          "signo_moneda" => $key['signo_moneda'],
          "flag_igv" => $key['flag_igv'],
          "precio" => $key['precio'],
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
