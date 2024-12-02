<?php



  $id_trabajador = isset($_POST["id_trabajador"]) ? $_POST["id_trabajador"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("trabajador"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_trabajador)) {
        throw new Exception("No se recibió el campo id trabajador.");
    }

    if ($id_trabajador==$_SESSION['id_trabajador']) {
      throw new Exception("Por motivos de seguridad no puedes eliminar tu propio usuario, si desea eliminar este registro lo puede hacer otro usuario con los mismos privilegios.");
    }

    require_once "core/models/ClassTrabajador.php";
    $VD = $OBJ_TRABAJADOR->delete($id_trabajador);

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
