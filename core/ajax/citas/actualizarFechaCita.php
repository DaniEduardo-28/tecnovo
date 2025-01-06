<?php

$id_cronograma = isset($_POST["id_cronograma"]) ? $_POST["id_cronograma"] : 0;
$fecha_inicio = isset($_POST["fecha_ingreso"]) ? $_POST["fecha_ingreso"] : date('Y-m-d');
$hora_inicio = isset($_POST["hora_ingreso"]) ? $_POST["hora_ingreso"] : date('H:i');
$fecha_fin = isset($_POST["fecha_salida"]) ? $_POST["fecha_salida"] : date('Y-m-d');
$hora_fin = isset($_POST["hora_salida"]) ? $_POST["hora_salida"] : date('H:i');

try {

  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("citas"));
  if ($access_options[0]['error'] == "NO") {
    if ($access_options[0]['flag_editar'] == false) {
      throw new Exception("No tienes permisos para editar.");
    }
  } else {
    throw new Exception("Error al verificar los permisos.");
  }

  if ($id_cronograma == 0) {
    throw new Exception("Campo obligatorio : Id de Cronograma");
  }

  $fecha_1 = date('Y-m-d H:i', strtotime("$fecha_inicio $hora_inicio"));
  $fecha_2 = date('Y-m-d H:i', strtotime("$fecha_fin $hora_fin"));

  require_once "core/models/ClassCronograma.php";
  $VD = $OBJ_CRONOGRAMA->actualizarFechaCita($id_cronograma, $fecha_1, $fecha_2);

  if ($VD != "OK") {
    throw new Exception($VD);
  }

  $data["error"] = "NO";
  $data["message"] = "Operación realizada correctamente";
  $data["data"] = null;
  echo json_encode($data);
} catch (\Exception $e) {

  $data["error"] = "SI";
  $data["message"] = $e->getMessage();
  $data["data"] = null;
  echo json_encode($data);
}
