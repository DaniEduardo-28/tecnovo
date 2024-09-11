<?php

  $id_proveedor = isset($_POST["id_proveedor"]) ? $_POST["id_proveedor"] : 0;
  $observacion = isset($_POST["observacion"]) ? $_POST["observacion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_persona'],printCodeOption("observacionesproveedor"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_agregar']==false) {
        throw new Exception("No tienes permisos para agregar una observación.");
      }
    } else {
      throw new Exception("Error al verificar los permisos.");
    }

    if (empty(trim($id_proveedor))) {
      throw new Exception("No se recibió el id proveedor.");
    }

    if (empty(trim($observacion))) {
      throw new Exception("La observación no puede estar en blanco.");
    }

    require_once "core/models/ClassProveedor.php";
    $VD = $OBJ_PROVEEDOR->addObservacion($id_proveedor,$observacion);

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
