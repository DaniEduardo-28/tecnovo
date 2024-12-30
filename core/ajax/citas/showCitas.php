<?php

$id_trabajador = isset($_POST['id_medico']) ? $_POST['id_medico'] : "all";
$id_documento = isset($_POST['id_documento']) ? $_POST['id_documento'] : "all";
$id_sucursal = isset($_SESSION['id_sucursal']) ? $_SESSION['id_sucursal'] : 0;
$valor = isset($_POST['valor']) ? $_POST['valor'] : "";

try {

  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("citas"));
  if ($access_options[0]['error'] == "NO") {
    if ($access_options[0]['flag_buscar'] == false) {
      throw new Exception("No tienes permisos para realizar busquedas.");
    }
  } else {
    throw new Exception("Error al verificar los permisos.");
  }

  require_once "core/models/ClassCronograma.php";
  $Resultado = $OBJ_CRONOGRAMA->showCitas($id_trabajador, $id_documento, $valor, $id_sucursal);

  if ($Resultado["error"] == "SI") {
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

    $data[] = array(
      "title" => 'Actividad: ' . $elemento['actividad'],
      "start" => date('Y-m-d H:i', strtotime($elemento['fecha_ingreso'])),
      "end" => date('Y-m-d H:i', strtotime($elemento['fecha_salida'])),
      "color" => $color,
      "id" => $elemento['id_cronograma'],
      "durationEditable" => $editable,
      "editable" => $editable,
      "estado" => $elemento['estado'],
      "id_maquinaria" => $elemento['id_maquinaria'],
      "id_operador" => $elemento['id_operador'],
      "id_cliente" => $elemento['id_cliente'],
      "id_fundo" => $elemento['id_fundo'],
      "nombre_maquinaria" => $elemento['nombre_maquinaria'],
      "nombre_operador" => $elemento['nombre_operador'],
      "nombre_cliente" => $elemento['nombre_cliente'],
      "nombre_fundo" => $elemento['nombre_fundo'],
      "observaciones" => $elemento['observaciones'],
      "description" => 'Actividad: ' . $elemento['actividad'] . '<br> Estado: ' . $elemento['estado']
    );
  }

  echo json_encode($data);
} catch (\Exception $e) {

  echo json_encode($e->getMessage());
}