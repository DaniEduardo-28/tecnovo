<?php

  $id_mascota = isset($_POST["id_mascota"]) ? $_POST["id_mascota"] : 0;
  $id_trabajador = isset($_POST["id_trabajador"]) ? $_POST["id_trabajador"] : 0;
  $id_fundo = isset($_SESSION["id_fundo"]) ? $_SESSION["id_fundo"] : 0;
  $id_servicio = isset($_POST["cboServicioForm"]) ? $_POST["cboServicioForm"] : 0;
  $fecha_inicio = isset($_POST["txtFechaInicio"]) ? $_POST["txtFechaInicio"] : 0;
  $hora_inicio = isset($_POST["txtHoraInicio"]) ? $_POST["txtHoraInicio"] : 0;
  $fecha_fin = isset($_POST["txtFechaTermino"]) ? $_POST["txtFechaTermino"] : 0;
  $hora_fin = isset($_POST["txtHoraFin"]) ? $_POST["txtHoraFin"] : 0;
  $sintomas = isset($_POST["txtSintomas"]) ? $_POST["txtSintomas"] : 0;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("citas"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_agregar']==false) {
        throw new Exception("No tienes permisos para agregar.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_mascota==0) {
      throw new Exception("Campo obligatorio : Seleccionar Operación");
    }

    if ($id_trabajador==0) {
      throw new Exception("Campo obligatorio : Seleccionar Usuario de Cita..");
    }

    if ($id_servicio==0) {
      throw new Exception("Campo obligatorio : Seleccionar el servicio de atención.");
    }

    $fecha_1 = date('Y-m-d H:i', strtotime("$fecha_inicio $hora_inicio"));
    $fecha_2 = date('Y-m-d H:i', strtotime("$fecha_fin $hora_fin"));

    require_once "core/models/ClassCita.php";
    $VD = $OBJ_CITA->registrarCitaAdmin($id_mascota,$id_trabajador,$id_servicio,$fecha_1,$fecha_2,$sintomas,$id_fundo);

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
