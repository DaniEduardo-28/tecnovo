<?php

  try {

    $id_servicio = isset($_POST["id_servicio"])	? $_POST["id_servicio"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("servicio"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_servicio=="") {
      throw new Exception("No se recibió el parámetro id servicio.");
    }

    require_once "core/models/ClassServicio.php";
    $Resultado = $OBJ_SERVICIO->getDataEditServicio($id_servicio);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_servicio" => $key['id_servicio'],
          "id_tipo_servicio" => $key['id_tipo_servicio'],
          "name_servicio" => $key['name_servicio'],
          "descripcion_breve" => $key['descripcion_breve'],
          "descripcion_larga" => $key['descripcion_larga'],
          "name_tipo" => $key['name_tipo'],
          "precio" => $key['precio'],
          "id_moneda" => $key['id_moneda'],
          "estado" => $key['estado'],
          "flag_igv" => $key['flag_igv'],
          "src_imagen" => $key['src_imagen']
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
