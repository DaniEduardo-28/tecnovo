<?php

  $id_maquinaria = isset($_POST['maquinaria']) ? $_POST['maquinaria'] : "all";
  $id_operador = isset($_POST['operador']) ? $_POST['operador'] : "all";
  $id_cliente = isset($_SESSION['cliente']) ? $_SESSION['cliente'] : "all";
  $id_fundo = isset($_POST['fundo']) ? $_POST['fundo'] : "all";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("citas"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassCronograma.php";
    $Resultado = $OBJ_CRONOGRAMA->showCitas($id_maquinaria, $id_operador, $id_cliente, $id_fundo);

    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }

    $data = array();
    foreach ($Resultado['data'] as $elemento) {

      $estado = $elemento['estado_trabajo'];
      $color = "#757571";
      $editable = ($estado === 'PENDIENTE');;
      switch ($estado) {
        case 'EN PROCESO':
          $color = '#ffd500';
          $editable = false;
          break;
        case 'PENDIENTE':
          $color = '#757571';
          $editable = true;
          break;
        case 'cancelada':
          $color = '#f62f41';
          $editable = false;
          break;
        case 'ANULADO':
          $color = '#f62f41';
          $editable = false;
          break;
        case 'TERMINADO':
          $color = '#2ee009';
          $editable = false;
          break;
        default:
          $color = '#757571';
          break;
      }

      $data[]=array(
        "title" => 'SER-' . $elemento['id_cronograma'],
        "start" => date('Y-m-d H:i', strtotime($elemento['fecha_ingreso'])),
        "end" => date('Y-m-d H:i', strtotime($elemento['fecha_salida'])),
        "color" => $color,
        "id" => $elemento['id_cronograma'],
        "description" => $elemento['id_cronograma'],
        "durationEditable" => $editable,
        "editable" => $editable,
        "estado" => $estado,
        "id_fundo" => $elemento['id_fundo'],
        "fecha_inicio" => date('d/m/Y H:i', strtotime($elemento['fecha_ingreso'])),
        "fecha_fin" => date('d/m/Y H:i', strtotime($elemento['fecha_salida'])),
        "description" => 'Estado : ' . $elemento['estado_trabajo'],
        "nombre_maquinaria" => $elemento['nombre_maquinaria'],
        "nombre_operador" => $elemento['nombre_operador'],
        "nombre_cliente" => $elemento['nombre_cliente'],
        "nombre_fundo" => $elemento['nombre_fundo'],
        "nombre_servicio" => $elemento['nombre_servicio']
      );
    }

    echo json_encode($data);

  } catch (\Exception $e) {

    echo json_encode($e->getMessage());

  }
// "num_documento" => $elemento['num_documento'],
//         "name_documento" => $elemento['name_documento'],
//         "name_medico" => $elemento['apellidos_trabajador'] .' ' . $elemento['nombres_trabajador'],
//         "id_servicio" => $elemento['name_servicio'],
 ?>