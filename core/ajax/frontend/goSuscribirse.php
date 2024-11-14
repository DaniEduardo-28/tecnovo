<?php

  $correo_suscribirse = isset($_POST["correo_suscribirse"]) ? $_POST["correo_suscribirse"] : "";

  try {

    if (trim($correo_suscribirse)=="") {
      throw new Exception("El correo electrónico no puede estar vacío.");
    }else {
      if (validar_email($correo_suscribirse)==false) {
        throw new Exception("Formato de correo es incorrecto.");
      }
    }

    require_once "admin/core/models/ClassSuscriptor.php";
    $VD = $OBJ_SUSCRIPTOR->add($correo_suscribirse);
    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="¡Bien hecho! Te estaremos enviando nuestras ofertas y noticias para tus engreídos.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
