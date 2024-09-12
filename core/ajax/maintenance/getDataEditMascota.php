<?php

  try {

    $id_mascota = isset($_POST["id_mascota"])	? $_POST["id_mascota"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("mascota"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_mascota=="") {
      throw new Exception("No se recibió el parámetro id mascota.");
    }

    require_once "core/models/ClassMascota.php";
    $Resultado = $OBJ_MASCOTA->getDataEditMascota($id_mascota);

    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }

    foreach ($Resultado["data"] as $key) {
      $retorno_array[] =array(
        "id_mascota" => $key['id_mascota'],
        "id_documento" => $key['id_documento'],
        "num_documento" => $key['num_documento'],
        "nombres" => $key['nombres'],
        "apellidos" => $key['apellidos'],
        "id_tipo_mascota" => $key['id_tipo_mascota'],
        "nombre_mascota" => $key['nombre'],
        "raza" => $key['raza'],
        "color" => $key['color'],
        "peso" => $key['peso'],
        "sexo" => $key['sexo'],
        "src_imagen" => $key['src_imagen'],
        "fecha_nacimiento" => date('Y-m-d', strtotime($key['fecha_nacimiento'])),
        "observaciones" => $key['observaciones'],
        "estado" => $key['estado'],
      );
    }

    $data["error"] = "NO";
    $data["message"] = "Success";
    $data["data"] = $retorno_array;
    echo json_encode($data);

  } catch (\Exception $e) {
    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
  }

 ?>
