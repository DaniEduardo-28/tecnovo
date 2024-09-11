<?php

  $name_user = isset($_POST["email"]) ? $_POST["email"] : "";
  $pass_user  = isset($_POST["password"]) ? encript($_POST["password"]) : "";

  try {

    if (empty($name_user)) {
      throw new Exception("Campo correo, obligatorio.");
    }

    if (empty($pass_user)) {
      throw new Exception("Campo contraseña, obligatorio.");
    }

    require_once "admin/core/models/ClassUsuario.php";
    $Resultado = $OBJ_USUARIO->getLoginCliente($name_user);

    if ($Resultado["error"]=="NO") {

      $result = $Resultado["data"];

      if ($result[0]["pass_user"]!=$pass_user) {
        throw new Exception("Contraseña Incorrecta");
      }

      if ($result[0]["estado"]!="activo") {
        throw new Exception("Su cuenta se encuentra deshabilitada.");
      }

    }else {

      throw new Exception($Resultado["message"]);

    }

    $srcImg = $result[0]["src_imagen"];
    if ($srcImg == null || $srcImg == "") {
      $srcImg = "resources/global/images/default-profile.png";
    }


    $_SESSION['id_persona_cliente'] = $result[0]["id_persona"];
    $_SESSION['id_cliente'] = $result[0]["id_cliente"];
    $_SESSION['name_user_cliente'] = $result[0]["name_user"];
    $_SESSION['nombres_cliente'] = $result[0]["nombres"];
    $_SESSION['apellidos_cliente'] = $result[0]["apellidos"];
    $_SESSION['src_imagen_cliente'] = $srcImg;

    $data["error"]="NO";
    $data["message"]="Acceso Correcto.";
    $data["data"] = null;
    echo json_encode($data);
    exit();

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
