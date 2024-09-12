<?php

  $correo = isset($_POST["email"]) ? $_POST["email"] : "";
  $nombres = isset($_POST["name"]) ? $_POST["name"] : "";
  $telefono = isset($_POST["phone"]) ? $_POST["phone"] : "";
  $asunto = isset($_POST["sub"]) ? $_POST["sub"] : "";
  $mensaje = isset($_POST["message"]) ? $_POST["message"] : "";

  try {

    if (validar_email($correo)==false) {
      throw new Exception("Formato de correo es incorrecto.");
    }

    if ($nombres=="") {
      throw new Exception("Campo obligatorio : nombres");
    }

    if ($asunto=="") {
      throw new Exception("Campo obligatorio : asunto");
    }

    if ($mensaje=="") {
      throw new Exception("Campo obligatorio : mensaje");
    }

    // Set the from email address.
    $from = "<paginaweb@mican.com>";
    $to = CORREO_RECIBE;

    // Build the email content.
    $message = "
          Hola,

          Un visitante ha recibido una consulta " . APP_URL . "

          Nombres : $nombres

          Correo Visitante: $correo

          Asunto: $asunto

          Teléfono: $telefono

          Mensaje: $mensaje


          Gracias,

          " . APP_TITLE;


    // send the email
    if(mail($to,$asunto,$message)){
      echo "OK";
    }else{
      throw new Exception("Ocurrió un error al enviar el correo.");
    }

  } catch (\Exception $e) {

    echo $e->getMessage();

  }

 ?>
