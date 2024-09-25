<?php

  sleep(1);

  $id_maquinaria = isset($_POST["id_maquinaria"]) ? $_POST["id_maquinaria"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("maquinaria"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_maquinaria)) {
        throw new Exception("No se recibió el campo id maquinaria.");
    }

    require_once "core/models/ClassMaquinaria.php";
    $VD = $OBJ_MAQUINARIA->delete($id_maquinaria);

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