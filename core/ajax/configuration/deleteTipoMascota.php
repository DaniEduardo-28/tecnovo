<?php

  sleep(1);

  $id_tipo_mascota = isset($_POST["id_tipo_mascota"]) ? $_POST["id_tipo_mascota"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("tipomascota"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_tipo_mascota)) {
        throw new Exception("No se recibió el campo id tipo de mascota.");
    }

    require_once "core/models/ClassTipoMascota.php";
    $VD = $OBJ_TIPO_MASCOTA->delete($id_tipo_mascota);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Registro eliminado correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
