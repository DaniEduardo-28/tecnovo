<?php

  

  $id_categoria = isset($_POST["id_categoria"]) ? $_POST["id_categoria"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("tipoproducto"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_categoria)) {
        throw new Exception("No se recibió el campo id categoria.");
    }

    require_once "core/models/ClassCategoriaAccesorio.php";
    $VD = $OBJ_CATEGORIA_ACCESORIO->delete($id_categoria);

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
