<?php

  $link_1 = isset($_POST["link_1"]) ? $_POST["link_1"] : "#";
  $link_2 = isset($_POST["link_2"]) ? $_POST["link_2"] : "#";
  $link_3 = isset($_POST["link_3"]) ? $_POST["link_3"] : "#";
  $link_4 = isset($_POST["link_4"]) ? $_POST["link_4"] : "#";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("webredessociales"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permiso para modificar estos datos.");
      }
    }else {
      throw new Exception("Ocurrió un error al realizar la consulta.");
    }


    require_once "core/models/ClassOverall.php";
    $VD = $OBJ_OVERALL->updateRedesSociales($link_1,$link_2,$link_3,$link_4);
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
