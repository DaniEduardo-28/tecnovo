<?php

  sleep(1);

  $id_tipo_cosecha = isset($_POST["id_tipo_cosecha"]) ? $_POST["id_tipo_cosecha"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("tipocosecha"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_tipo_cosecha)) {
        throw new Exception("No se recibió el campo id tipo de cosecha.");
    }

    require_once "core/models/ClassTipoCosecha.php";
    $VD = $OBJ_TIPO_COSECHA->delete($id_tipo_cosecha);

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