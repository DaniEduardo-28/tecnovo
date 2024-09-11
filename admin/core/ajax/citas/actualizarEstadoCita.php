<?php

  $id_cita = isset($_POST["id_cita"]) ? $_POST["id_cita"] : "";
  $estado = isset($_POST["estado"]) ? $_POST["estado"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("citas"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar.");
      }
    } else {
      throw new Exception("Error al verificar los permisos.");
    }

    if (empty($id_cita)) {
        throw new Exception("No se recibió el campo id cita.");
    }

    if (empty($estado)) {
        throw new Exception("No se recibió el campo estado de cita.");
    }

    require_once "core/models/ClassCita.php";
    $VD = $OBJ_CITA->actualizarEstado($id_cita,$estado);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Cita cancelada correctamente..";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
