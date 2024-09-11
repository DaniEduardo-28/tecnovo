<?php

  sleep(1);

  $id_tipo_medicamento = isset($_POST["id_tipo_medicamento"]) ? $_POST["id_tipo_medicamento"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("tipomedicamento"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_eliminar']==false) {
        throw new Exception("No tienes permiso a eliminar.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_tipo_medicamento)) {
        throw new Exception("No se recibió el campo id tipo medicamento.");
    }

    require_once "core/models/ClassTipoMedicamento.php";
    $VD = $OBJ_TIPO_MEDICAMENTO->delete($id_tipo_medicamento);

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
