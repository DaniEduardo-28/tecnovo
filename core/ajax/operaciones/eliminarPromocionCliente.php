<?php

  $id_promocion = isset($_POST["id_promocion"]) ? $_POST["id_promocion"] : 0;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("promocion"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar promociones de clientes.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_promocion)) {
        throw new Exception("No se recibió el campo id detalle promoción.");
    }

    require_once "core/models/ClassCliente.php";
    $VD = $OBJ_CLIENTE->deletePromocion($id_promocion);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Promoción eliminada correctmente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
