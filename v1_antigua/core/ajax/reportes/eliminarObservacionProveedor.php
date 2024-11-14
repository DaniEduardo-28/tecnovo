<?php

  $id_detalle = isset($_POST["id_detalle"]) ? $_POST["id_detalle"] : 0;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("observacionesproveedor"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar observaciones.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_detalle)) {
        throw new Exception("No se recibió el campo id detalle observación.");
    }

    require_once "core/models/ClassProveedor.php";
    $VD = $OBJ_PROVEEDOR->deleteObservacion($id_detalle);

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
