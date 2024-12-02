<?php



  $id = isset($_POST["id"]) ? $_POST["id"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("webtestimonio"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id)) {
        throw new Exception("No se recibió el campo id del testimonio.");
    }

    require_once "core/models/ClassTestimonio.php";
    $VD = $OBJ_TESTIMONIO->delete($id);

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
