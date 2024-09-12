<?php

  $id_sucursal = isset($_POST["id_sucursal"]) ? $_POST["id_sucursal"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("sucursales"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso para eliminar.");
      }
    }else {
      throw new Exception("Ocurrió un error al validar los permisos.");
    }

    if (empty($id_sucursal)) {
      throw new Exception("No se recibió el id de sucursal.");
    }

    if ($id_sucursal == $_SESSION['id_sucursal']) {
      throw new Exception("No puedes eliminar la sucursal con la que accediste al sistema.");
    }

    require_once "core/models/ClassSucursal.php";
    $VD = $OBJ_SUCURSAL->delete($id_sucursal);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Sucursal eliminada correctmente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
