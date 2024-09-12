<?php

  sleep(1);

  $id_especialidad = isset($_POST["id_especialidad"]) ? $_POST["id_especialidad"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("especialidad"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar especialidades.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_especialidad)) {
        throw new Exception("No se recibió el campo id especialidad.");
    }

    require_once "core/models/ClassEspecialidad.php";
    $VD = $OBJ_ESPECIALIDAD->delete($id_especialidad);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Registro eliminado correctmente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
