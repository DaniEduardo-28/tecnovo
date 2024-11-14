<?php

  $id_cita = isset($_POST['id_cita']) ? $_POST['id_cita'] : 0;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("atencioncitas"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassDetalleCita.php";
    $Resultado = $OBJ_DETALLE_CITA->getDetalleCita($id_cita);

    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }

    $retorno_array = array();

    foreach ($Resultado['data'] as $elemento) {

      $retorno_array[]=array(
        "name_mascota" => $elemento['nombre'],
        "id_cita" => $elemento['id_cita'],
        "id_mascota" => $elemento['id_mascota'],
        "id_tipo_mascota" => $elemento['id_tipo_mascota'],
        "raza" => $elemento['raza'],
        "color" => $elemento['color'],
        "peso" => $elemento['peso'],
        "sexo" => $elemento['sexo'],
        "fecha_nacimiento" => $elemento['fecha_nacimiento'],
        "src_imagen" => $elemento['src_imagen'],
        "name_tipo_mascota" => $elemento['name_tipo'],
        "estado" => $elemento['estado_cita'],
        "num_documento" => $elemento['num_documento'],
        "name_documento" => $elemento['name_documento'],
        "name_servicio" => $elemento['detalle_name_servicio'],
        "fecha_registro" => date('d/m/Y H:i', strtotime($elemento['fecha_registro'])),
        "fecha_cita" => date('d/m/Y H:i', strtotime($elemento['fecha_cita'])),
        "fecha_termino" => date('d/m/Y H:i', strtotime($elemento['fecha_termino'])),
        "sintoma" => $elemento['sintoma'],
        "detalle_sintomas" => $elemento['detalle_sintomas'],
        "detalle_observaciones" => $elemento['detalle_observaciones'],
        "detalle_tratamiento" => $elemento['detalle_tratamiento'],
        "detalle_vacunas_aplicadas" => $elemento['detalle_vacunas_aplicadas'],
      );

    }

    $data["error"] = "NO";
    $data["message"] = "Success";
    $data["data"] = $retorno_array;
    echo json_encode($data);
    exit();

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

?>
