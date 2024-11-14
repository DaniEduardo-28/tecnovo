<?php

$id_cliente = isset($_POST["id_cliente"]) ? $_POST["id_cliente"] : "";
$datos = isset($_POST["datos"]) ? $_POST["datos"] : null;

try {

  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("accesofundo"));
  if ($access_options[0]['error'] == "NO") {
    if ($access_options[0]['flag_editar'] == false) {
      throw new Exception("No tienes permiso para modificar.");
    }
  } else {
    throw new Exception("Error al verificar los permisos.");
  }


  if (empty($id_cliente)) {
    throw new Exception("Campo Obligatorio: Id Cliente.");
  }

  if ($datos != null) {
    $datos = json_decode($datos);
  }
  
  require_once "core/models/ClassAccesoFundo.php";
  $VD = $OBJ_ACCESO_FUNDO->updateAccesoFundo($id_cliente, $datos);

  if ($VD != "OK") {
    throw new Exception($VD);
  }

  $data["error"] = "NO";
  $data["message"] = "Operación realizada correctamente.";
  $data["data"] = null;
  echo json_encode($data);

} catch (\Exception $e) {

  $data = [
    "error" => "SI",
    "message" => $e->getMessage(),
    "data" => null
  ];
  echo json_encode($data);

}

?>