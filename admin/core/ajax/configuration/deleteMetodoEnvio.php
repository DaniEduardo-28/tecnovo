<?php

  $id_metodo_envio = isset($_POST["id_metodo_envio"]) ? $_POST["id_metodo_envio"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("metodoenvio"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_metodo_envio)) {
        throw new Exception("No se recibió el campo id método de envío.");
    }

    require_once "core/models/ClassMetodoEnvio.php";
    $VD = $OBJ_METODO_ENVIO->delete($id_metodo_envio);

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
