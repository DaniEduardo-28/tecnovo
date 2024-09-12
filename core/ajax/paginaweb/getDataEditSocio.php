<?php

  try {

    $id = isset($_POST["id"])	? $_POST["id"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("websocio"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id=="") {
      throw new Exception("No se recibió el parámetro id socio.");
    }

    require_once "core/models/ClassSocio.php";
    $Resultado = $OBJ_SOCIO->getDataEditSocio($id);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id" => $key['id'],
          "titulo" => $key['titulo'],
          "descripcion" => $key['descripcion'],
          "estado" => $key['estado'],
          "src_imagen" => $key['src']
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
