<?php

  try {

    $id_mascota = isset($_POST["id_mascota"])	? $_POST["id_mascota"]	: "";

    if (!isset($_SESSION['id_cliente'])) {
      throw new Exception("Para realizar esta operación tiene que iniciar sesión.");
    }

    if ($id_mascota=="") {
      throw new Exception("No se recibió el parámetro id mascota.");
    }

    require_once "admin/core/models/ClassMascota.php";
    $Resultado = $OBJ_MASCOTA->getDataEditMascota($id_mascota);

    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }

    if ($Resultado['data'][0]['id_cliente'] != $_SESSION['id_cliente']) {
      throw new Exception("No puedes ver esta mascota.");
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
