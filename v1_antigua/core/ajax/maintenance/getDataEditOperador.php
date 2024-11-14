<?php

  try {

    $id_operador = isset($_POST["id_operador"])	? $_POST["id_operador"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("operador"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_operador=="") {
      throw new Exception("No se recibió el parámetro id operador.");
    }

    require_once "core/models/ClassOperador.php";
    $Resultado = $OBJ_OPERADOR->getDataEditOperador($id_operador);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_persona" => $key['id_persona'],
          "id_documento" => $key['id_documento'],
          "num_documento" => $key['num_documento'],
          "nombres" => $key['nombres'],
          "apellidos" => $key['apellidos'],
          "direccion" => $key['direccion'],
          "telefono" => $key['telefono'],
          "correo" => $key['correo'],
          "fecha_nacimiento" => $key['fecha_nacimiento'],
          "sexo" => $key['sexo'],
          "src_imagen" => $key['src_imagen'],
          "id_operador" => $key['id_operador'],
          "name_user" => $key['name_user'],
          "pass_user" => $key['pass_user'],
          "estado" => $key['estado']
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
