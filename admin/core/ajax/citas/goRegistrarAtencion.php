<?php

  $id_cita = isset($_POST["id_cita"]) ? $_POST["id_cita"] : "";
  $peso = isset($_POST["peso"]) ? $_POST["peso"] : "";
  $observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : "";
  $sintomas = isset($_POST["sintomas"]) ? $_POST["sintomas"] : "";
  $tratamiento = isset($_POST["tratamiento"]) ? $_POST["tratamiento"] : "";
  $vacunas = isset($_POST["vacunas"]) ? $_POST["vacunas"] : "";
  $motivo = isset($_POST["motivo"]) ? $_POST["motivo"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("atencioncitas"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permiso para registrar atención de citas.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_cita)) {
      throw new Exception("No se recibió el campo id cita.");
    }

    if (empty($peso)) {
      throw new Exception("No se recibió el peso de la mascota.");
    }

    require_once "core/models/ClassDetalleCita.php";
    $VD = $OBJ_DETALLE_CITA->goRegistrarAtencion($id_cita,$peso,$observaciones,$sintomas,$tratamiento,$vacunas,$motivo);

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
