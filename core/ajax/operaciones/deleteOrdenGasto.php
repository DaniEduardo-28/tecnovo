<?php

  $id_orden_gasto = isset($_POST["id_orden_gasto"]) ? $_POST["id_orden_gasto"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordengasto"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_anular']==false) {
        throw new Exception("No tienes permiso para anular este registro.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_orden_gasto)) {
        throw new Exception("No se recibió el campo id orden.");
    }

    require_once "core/models/ClassOrdenGasto.php";
    $VD = $OBJ_ORDEN_GASTO->delete($id_orden_gasto);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Registro anulado correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

?>
