<?php

  

  $id_tipo_gasto = isset($_POST["id_tipo_gasto"]) ? $_POST["id_tipo_gasto"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("tipogasto"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_tipo_gasto)) {
        throw new Exception("No se recibió el campo id tipo de gasto.");
    }

    require_once "core/models/ClassTipoGasto.php";
    $VD = $OBJ_TIPO_GASTO->delete($id_tipo_gasto);

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
