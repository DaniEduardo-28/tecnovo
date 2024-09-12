<?php

  $id_venta = isset($_POST["id_venta"]) ? $_POST["id_venta"] : 0;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordenventa"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso para eliminar este registro.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_venta)) {
        throw new Exception("No se recibió el campo id orden venta.");
    }

    require_once "core/models/ClassOrdenVenta.php";
    $VD = $OBJ_ORDEN_VENTA->delete($id_venta);

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
