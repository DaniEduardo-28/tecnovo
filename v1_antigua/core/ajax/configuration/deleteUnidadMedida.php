<?php

  $id_unidad_medida = isset($_POST["id_unidad_medida"]) ? $_POST["id_unidad_medida"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("unidadmedida"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_unidad_medida)) {
        throw new Exception("No se recibió el campo id unidad de medida.");
    }

    require_once "core/models/ClassUnidadMedida.php";
    $VD = $OBJ_UNIDAD_MEDIDA->delete($id_unidad_medida);

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
