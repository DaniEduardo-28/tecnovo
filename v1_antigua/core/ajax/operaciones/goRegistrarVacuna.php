<?php

  $id_mascota = isset($_POST["id_mascota_edit"]) ? $_POST["id_mascota_edit"] : "";
  $id_vacuna = isset($_POST["id_vacuna_edit"]) ? $_POST["id_vacuna_edit"] : "";
  $observaciones = isset($_POST["observaciones_edit"]) ? $_POST["observaciones_edit"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("fichamascota"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_agregar']==false) {
        throw new Exception("No tienes permiso para registrar la vacuna.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_mascota)) {
      throw new Exception("No se recibió el campo id mascota.");
    }

    if (empty($id_vacuna)) {
      throw new Exception("No se recibió el campo id vacuna.");
    }

    require_once "core/models/ClassMascotaVacuna.php";
    $VD = $OBJ_MASCOTA_VACUNA->goRegistrarVacuna($id_mascota,$id_vacuna,$observaciones);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Vacuna registrada correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
