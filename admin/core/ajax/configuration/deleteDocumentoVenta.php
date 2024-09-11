<?php

  $id_documento_venta = isset($_POST["id_documento_venta"]) ? $_POST["id_documento_venta"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("documentoventa"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso para eliminar.");
      }
    }else {
      throw new Exception("Ocurrió un error al validar los permisos.");
    }

    if (empty($id_documento_venta)) {
      throw new Exception("No se recibió el id de documento de venta.");
    }

    require_once "core/models/ClassDocumentoVenta.php";
    $VD = $OBJ_DOCUMENTO_VENTA->delete($id_documento_venta);

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
