<?php

  $id_cita = isset($_POST["id_cita"]) ? $_POST["id_cita"] : "";

  try {

    if (!isset($_SESSION['id_cliente'])) {
      throw new Exception("Para realizar esta operación tiene que iniciar sesión.");
    }

    if (empty($id_cita)) {
        throw new Exception("No se recibió el campo id cita.");
    }

    require_once "admin/core/models/ClassCita.php";
    $VD = $OBJ_CITA->cancelar($id_cita,$_SESSION['id_cliente']);

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
