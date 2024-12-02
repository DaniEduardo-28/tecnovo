<?php



  $id_documento = isset($_POST["id_documento"]) ? $_POST["id_documento"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("identitydocuments"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso para eliminar.");
      }
    }else {
      throw new Exception("Ocurrió un error al validar los permisos.");
    }

    if (empty($id_documento)) {
      throw new Exception("No se recibió el id de documento.");
    }

    require_once "core/models/ClassDocumentoIdentidad.php";
    $VD = $OBJ_DOCUMENTO_IDENTIDAD->delete($id_documento);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Documento eliminado correctmente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
