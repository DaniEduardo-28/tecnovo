<?php

  try {

    $id_documento = isset($_POST["id_documento"])	? $_POST["id_documento"]	: 0;
    $num_documento = isset($_POST["num_documento"])	? $_POST["num_documento"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("citas"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.", 1);
    }

    require_once "core/models/ClassMascota.php";
    $Resultado = $OBJ_MASCOTA->showMascotasDocumento($id_documento,$num_documento);

    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }

    foreach ($Resultado["data"] as $key) {
      $retorno_array[] =array(
        "id_mascota" => $key['id_mascota'],
        "cliente" => $key['nombres'] . ' ' . $key['apellidos'],
        "name_tipo" => $key['name_tipo'],
        "nombre" => strtoupper($key['nombre']),
        "raza" => $key['raza'],
        "color" => $key['color'],
        "peso" => $key['peso'],
        "fecha_nacimiento" => date('d/m/Y', strtotime($key['fecha_nacimiento']))
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
