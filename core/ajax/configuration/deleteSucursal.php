<?php

  $id_fundo = isset($_POST["id_fundo"]) ? $_POST["id_fundo"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("sucursales"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso para eliminar.");
      }
    }else {
      throw new Exception("Ocurrió un error al validar los permisos.");
    }

    if (empty($id_fundo)) {
      throw new Exception("No se recibió el id de sucursal.");
    }

    if ($id_fundo == $_SESSION['id_fundo']) {
      throw new Exception("No puedes eliminar la sucursal con la que accediste al sistema.");
    }

    require_once "core/models/ClassSucursal.php";
    $VD = $OBJ_SUCURSAL->delete($id_fundo);

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
