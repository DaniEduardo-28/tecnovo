<?php

  $id_moneda = isset($_POST["id_moneda"]) ? $_POST["id_moneda"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("monedas"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso para eliminar.");
      }
    }else {
      throw new Exception("Ocurrió un error al validar los permisos.");
    }

    if (empty($id_moneda)) {
      throw new Exception("No se recibió el id de moneda.");
    }

    require_once "core/models/ClassMoneda.php";
    $VD = $OBJ_MONEDA->delete($id_moneda);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Moneda eliminada correctmente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
