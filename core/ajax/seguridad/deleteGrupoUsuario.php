<?php



  $id_grupo = isset($_POST["id_grupo"]) ? $_POST["id_grupo"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("grupousuario"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_grupo)) {
        throw new Exception("No se recibió el campo id grupo.");
    }

    require_once "core/models/ClassGrupoUsuario.php";
    $VD = $OBJ_GRUPO_USUARIO->delete($id_grupo);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Grupo eliminado correctmente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
