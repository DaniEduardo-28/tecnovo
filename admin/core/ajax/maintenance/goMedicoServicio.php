<?php

  sleep(1);

  $id_trabajador = isset($_POST["id_trabajador"]) ? $_POST["id_trabajador"] : "";
  $datos = isset($_POST["datos"]) ? $_POST["datos"] : null;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("medicoservicio"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permiso para modificar.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if (empty(trim($id_trabajador))) {
      throw new Exception("Campo Obligatorio : Id Trabajador.");
    }

    if ($datos != null) {
      $datos = json_decode($datos);
    }

    require_once "core/models/ClassTrabajadorServicio.php";
    $VD = $OBJ_TRABAJADOR_SERVICIO->updateTrabajadorServicio($id_trabajador,$datos);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Operación realizada correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
