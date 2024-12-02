<?php

  try {

    $id_trabajador = isset($_POST["id_trabajador"])	? $_POST["id_trabajador"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("trabajador"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_trabajador=="") {
      throw new Exception("No se recibió el parámetro id trabajador.");
    }

    require_once "core/models/ClassTrabajador.php";
    $Resultado = $OBJ_TRABAJADOR->getDataEditTrabajador($id_trabajador);

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
          "id_trabajador" => $key['id_trabajador'],
          "id_grupo" => $key['id_grupo'],
          "id_especialidad" => $key['id_especialidad'],
          "name_user" => $key['name_user'],
          "apodo" => $key['apodo'],
          "pass_user" => $key['pass_user'],
          "estado" => $key['estado'],
          "flag_medico" => $key['flag_medico'],
          "descripcion" => $key['descripcion'],
          "link_facebook" => $key['link_facebook'],
          "link_instagram" => $key['link_instagram'],
          "link_twitter" => $key['link_twitter']
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
