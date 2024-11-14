<?php

  $id_ingreso = isset($_POST["id_ingreso"]) ? $_POST["id_ingreso"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ingreso"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_anular']==false) {
        throw new Exception("No tienes permiso para anular este registro.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_ingreso)) {
        throw new Exception("No se recibió el campo id ingreso.");
    }

    require_once "core/models/ClassIngreso.php";
    $VD = $OBJ_INGRESO->delete($id_ingreso);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Registro anulado correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
