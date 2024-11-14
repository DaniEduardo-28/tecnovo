<?php

  

  $id_grupo = isset($_POST["id_grupo"]) ? $_POST["id_grupo"] : "";
  $datos = isset($_POST["datos"]) ? $_POST["datos"] : null;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("accesogrupo"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permiso para modificar los permisos.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if (empty(trim($id_grupo))) {
      throw new Exception("Campo Obligatorio : Id Grupo.");
    }

    if ($datos==null) {
      throw new Exception("No se recibieron datos a modificar.");
    }

    $datos = json_decode($datos);
    $VD = $OBJ_ACCESO_OPCION->updatePermisos($id_grupo,$datos);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Operación realizada correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
