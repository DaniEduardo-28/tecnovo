<?php

  $id_trabajador = isset($_POST['id_medico']) ? $_POST['id_medico'] : 0;
  $id_sucursal = isset($_POST['id_sucursal']) ? $_POST['id_sucursal'] : 0;

  try {

    if (!isset($_SESSION['id_cliente'])) {
      throw new Exception("Para realizar esta operación tiene que iniciar sesión.");
    }

    if ($id_trabajador==0) {
      throw new Exception("No se recibió el médico a atender la cita.");
    }

    require_once "admin/core/models/ClassCita.php";
    $Resultado = $OBJ_CITA->showCitasTrabajador($id_sucursal,$id_trabajador);

    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }

    $data = array();
    foreach ($Resultado['data'] as $elemento) {
      if ($elemento['id_cliente'] == $_SESSION['id_cliente']) {
        $estado = $elemento['estado_cita'];
        $color = "#757571";
        $editable = true;
        switch ($estado) {
          case 'registrada':
            $color = '#757571';
            break;
          case 'aceptada':
            $color = '#dede0a';
            $editable = false;
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
          "title" => 'Mascota : ' . $elemento['nombre'],
          "start" => date('Y-m-d H:i', strtotime($elemento['fecha_cita'])),
          "end" => date('Y-m-d H:i', strtotime($elemento['fecha_termino_cita'])),
          "color" => $color,
          "id" => $elemento['id_cita'],
          "durationEditable" => $editable,
          "editable" => $editable,
          "estado" => $estado,
          "id_mascota" => $elemento['id_mascota'],
          "id_servicio" => $elemento['id_servicio'],
          "fecha_inicio" => date('Y-m-d', strtotime($elemento['fecha_cita'])),
          "hora_inicio" => date('H:i', strtotime($elemento['fecha_cita'])),
          "fecha_fin" => date('Y-m-d', strtotime($elemento['fecha_termino_cita'])),
          "hora_fin" => date('H:i', strtotime($elemento['fecha_termino_cita'])),
          "sintoma" => $elemento['sintoma_cita'],
          "description" => 'Servicio : ' . $elemento['name_servicio'] . '<br> Estado : ' . $elemento['estado_cita'],
        );

      } else {

        $estado = $elemento['estado_cita'];

        if ($estado != 'cancelada' && $estado != 'anulada') {

          $data[]=array(
            "title" => 'RESERVADO',
            "start" => date('Y-m-d H:i', strtotime($elemento['fecha_cita'])),
            "end" => date('Y-m-d H:i', strtotime($elemento['fecha_termino_cita'])),
            "color" => "#bb0000",
            "id" => $elemento['id_cita'],
            "durationEditable" => false,
            "editable" => false,
            "estado" => "NO",
            "description" => '',
          );

        }

      }
    }

    echo json_encode($data);

  } catch (\Exception $e) {

    echo json_encode($e->getMessage());

  }

 ?>
