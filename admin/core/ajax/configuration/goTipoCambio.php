<?php

  $id_moneda = isset($_POST["id_moneda"]) ? $_POST["id_moneda"] : "";
  $tipo_cambio = isset($_POST["tipo_cambio"]) ? $_POST["tipo_cambio"] : 0;
  $name_user = isset($_SESSION["name_user"]) ? $_SESSION["name_user"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("tipocambio"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_agregar']==false) {
        throw new Exception("No tienes permiso para agregar.");
      }
    }else {
      throw new Exception("Error al validar los permisos.");
    }

    if ($id_moneda=="") {
      throw new Exception("Campo Obligatorio : Seleccionar la moneda.");
    }

    if ($tipo_cambio==0) {
      throw new Exception("Campo Obligatorio : Tipo de Cambio.");
    }

    require_once "core/models/ClassTipoCambio.php";
    $VD = $OBJ_TIPO_CAMBIO->insert($id_moneda,$tipo_cambio,$name_user);

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
