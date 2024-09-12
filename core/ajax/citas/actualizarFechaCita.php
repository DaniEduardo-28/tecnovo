<?php

  $id_cita = isset($_POST["id_cita"]) ? $_POST["id_cita"] : 0;
  $fecha_inicio = isset($_POST["fecha_inicio"]) ? $_POST["fecha_inicio"] : date('Y-m-d');
  $hora_inicio = isset($_POST["hora_inicio"]) ? $_POST["hora_inicio"] : date('H:i');
  $fecha_fin = isset($_POST["fecha_fin"]) ? $_POST["fecha_fin"] : date('Y-m-d');
  $hora_fin = isset($_POST["hora_fin"]) ? $_POST["hora_fin"] : date('H:i');

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("citas"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar.");
      }
    } else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_cita==0) {
      throw new Exception("Campo obligatorio : Id de Cita");
    }

    $fecha_1 = date('Y-m-d H:i', strtotime("$fecha_inicio $hora_inicio"));
    $fecha_2 = date('Y-m-d H:i', strtotime("$fecha_fin $hora_fin"));

    require_once "core/models/ClassCita.php";
    $VD = $OBJ_CITA->actualizarFechaCita($id_cita,$fecha_1,$fecha_2);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Operación realizada correctamente";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
