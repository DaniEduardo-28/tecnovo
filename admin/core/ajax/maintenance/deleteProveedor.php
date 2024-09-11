<?php

  $id_proveedor = isset($_POST["id_proveedor"]) ? $_POST["id_proveedor"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("proveedor"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_proveedor)) {
      throw new Exception("No se recibió el campo id proveedor.");
    }

    require_once "core/models/ClassProveedor.php";
    $VD = $OBJ_PROVEEDOR->delete($id_proveedor);

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
