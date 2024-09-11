<?php

  $horario_top_nav = isset($_POST["horario_top_nav"]) ? $_POST["horario_top_nav"] : "#";
  $correo = isset($_POST["correo"]) ? $_POST["correo"] : "#";
  $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "#";
  $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : "#";
  $number_clientes = isset($_POST["number_clientes"]) ? $_POST["number_clientes"] : 0;
  $number_proyectos = isset($_POST["number_proyectos"]) ? $_POST["number_proyectos"] : 0;
  $number_premios = isset($_POST["number_premios"]) ? $_POST["number_premios"] : 0;
  $number_horas = isset($_POST["number_horas"]) ? $_POST["number_horas"] : 0;
  $horario_1 = isset($_POST["horario_1"]) ? $_POST["horario_1"] : "No especificado";
  $horario_2 = isset($_POST["horario_2"]) ? $_POST["horario_2"] : "No especificado";
  $horario_3 = isset($_POST["horario_3"]) ? $_POST["horario_3"] : "No especificado";
  $horario_4 = isset($_POST["horario_4"]) ? $_POST["horario_4"] : "No especificado";
  $horario_5 = isset($_POST["horario_5"]) ? $_POST["horario_5"] : "No especificado";
  $horario_6 = isset($_POST["horario_6"]) ? $_POST["horario_6"] : "No especificado";
  $horario_7 = isset($_POST["horario_7"]) ? $_POST["horario_7"] : "No especificado";
  $descripcion_footer = isset($_POST["descripcion_footer"]) ? $_POST["descripcion_footer"] : "No especificado";
  $mapa = isset($_POST["mapa"]) ? $_POST["mapa"] : "No especificado";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("webcontacto"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permiso para modificar estos datos.");
      }
    }else {
      throw new Exception("Ocurrió un error al realizar la consulta.");
    }

    require_once "core/models/ClassOverall.php";
    $VD = $OBJ_OVERALL->updateDatosContacto($horario_top_nav,$correo,$telefono,$direccion,$number_clientes,$number_proyectos,$number_premios,$number_horas,$horario_1,$horario_2,$horario_3,$horario_4,$horario_5,$horario_6,$horario_7,$descripcion_footer,$mapa);
    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Los datos fueron actualizados correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
