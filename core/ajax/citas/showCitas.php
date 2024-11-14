<?php

  $id_trabajador = isset($_POST['id_medico']) ? $_POST['id_medico'] : "all";
  $id_documento = isset($_POST['id_documento']) ? $_POST['id_documento'] : "all";
  $id_sucursal = isset($_SESSION['id_sucursal']) ? $_SESSION['id_sucursal'] : 0;
  $valor = isset($_POST['valor']) ? $_POST['valor'] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("citas"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassCita.php";
    $Resultado = $OBJ_CITA->showCitas($id_trabajador,$id_documento,$valor,$id_sucursal);

    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }

    $data = array();
    foreach ($Resultado['data'] as $elemento) {

      $estado = $elemento['estado_cita'];
      $color = "#757571";
      $editable = true;
      switch ($estado) {
        case 'registrada':
          $color = '#757571';
          break;
        case 'aceptada':
          $color = '#dede0a';
          break;
        case 'cancelada':
          $color = '#f62f41';
          $editable = false;
          break;
        case 'anulada':
          $color = '#f76d09';
          $editable = false;
          break;
        case 'atendida':
          $color = '#2ee009';
          $editable = false;
          break;
        default:
          $color = '#757571';
          break;
      }

      $data[]=array(
        "title" => 'Operación : ' . $elemento['nombre'],
        "start" => date('Y-m-d H:i', strtotime($elemento['fecha_cita'])),
        "end" => date('Y-m-d H:i', strtotime($elemento['fecha_termino_cita'])),
        "color" => $color,
        "id" => $elemento['id_cita'],
        "durationEditable" => $editable,
        "editable" => $editable,
        "estado" => $estado,
        "id_mascota" => $elemento['nombre'],
        "num_documento" => $elemento['num_documento'],
        "name_documento" => $elemento['name_documento'],
        "name_medico" => $elemento['apellidos_trabajador'] .' ' . $elemento['nombres_trabajador'],
        "id_servicio" => $elemento['name_servicio'],
        "fecha_inicio" => date('d/m/Y H:i', strtotime($elemento['fecha_cita'])),
        "fecha_fin" => date('d/m/Y H:i', strtotime($elemento['fecha_termino_cita'])),
        "sintoma" => $elemento['sintoma_cita'],
        "description" => 'Servicio : ' . $elemento['name_servicio'] . '<br> Estado : ' . $elemento['estado_cita'],
      );

    }

    echo json_encode($data);

  } catch (\Exception $e) {

    echo json_encode($e->getMessage());

  }

 ?>
