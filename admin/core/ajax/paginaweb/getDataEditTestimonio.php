<?php

  try {

    $id = isset($_POST["id"])	? $_POST["id"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("webtestimonio"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id=="") {
      throw new Exception("No se recibió el parámetro id del testimonio.");
    }

    require_once "core/models/ClassTestimonio.php";
    $Resultado = $OBJ_TESTIMONIO->getDataEditTestimonio($id);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id" => $key['id'],
          "titulo" => $key['titulo'],
          "descripcion" => $key['descripcion'],
          "estado" => $key['estado'],
          "referencia_1" => $key['referencia_1'],
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
