<?php

  $id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : "";
  $id_cliente = isset($_POST["id_cliente"]) ? $_POST["id_cliente"] : "";
  $id_documento = isset($_POST["id_documento"]) ? $_POST["id_documento"] : "";
  $num_documento = isset($_POST["num_documento"]) ? $_POST["num_documento"] : "";
  $nombres = isset($_POST["nombres"]) ? $_POST["nombres"] : "";
  $apellidos = isset($_POST["apellidos"]) ? $_POST["apellidos"] : "";
  $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : "";
  $correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
  $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "";
  $fecha_nacimiento = isset($_POST["fecha_nacimiento"]) ? $_POST["fecha_nacimiento"] : date('Y-m-d');
  $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : "M";
  $estado = "activo";
  $flag_imagen = isset($_POST["flag_imagen"]) ? $_POST["flag_imagen"] : "";
  $src_imagen = "resources/global/images/sin_imagen.png";
  $name_user = isset($_POST["correo"]) ? $_POST["correo"] : "";
  $pass_user = isset($_POST["password"]) ? encript($_POST["password"]) : "";
  $pass_user_confirm = isset($_POST["confirm_password"]) ? encript($_POST["confirm_password"]) : "";
  $sexo = ($sexo=="M") ? "masculino" : "femenino";

  try {

    if (empty(trim($id_documento))) {
      throw new Exception("Campo obligatorio : Documento Identidad.");
    }

    if (empty(trim($nombres))) {
      throw new Exception("Campo obligatorio : Nombres ó Razón Social.");
    }

    if (empty(trim($apellidos))) {
      throw new Exception("Campo obligatorio : Apellidos ó Nombre Comercial.");
    }

    if (empty(trim($num_documento))) {
      throw new Exception("Campo obligatorio : Número de documento.");
    }

    if (validar_email($correo)==false) {
      throw new Exception("Formato de correo no válido.");
    }

    require_once "admin/core/models/ClassDocumentoIdentidad.php";
    $resultDoc1 = $OBJ_DOCUMENTO_IDENTIDAD->getDocumentoForId($id_documento);
    if ($resultDoc1['error']=="SI") {
      throw new Exception($resultDoc1['message']);
    }

    $dataResultDoc1 = $resultDoc1['data'];

    if ($dataResultDoc1[0]['flag_exacto']=="1") {
      if ($dataResultDoc1[0]['size']!=strlen($num_documento)) {
        throw new Exception("El número de documento tiene que tener " . $dataResultDoc1[0]['size'] . " dígitos.");
      }
    }else {
      if ($dataResultDoc1[0]['size']<strlen($num_documento)) {
        throw new Exception("El documento de tiene que ser menor o igual de " . $dataResultDoc1[0]['size'] . " dígitos.");
      }
    }

    if ($dataResultDoc1[0]['flag_numerico']=="1") {
      if (validar_number($num_documento)==false) {
        throw new Exception("El documento tiene que ser sólo números.");
      }
    }

    if (empty(trim($name_user))) {
      throw new Exception("Campo obligatorio : Correo.");
    }

    if (empty(trim($pass_user))) {
      throw new Exception("Campo obligatorio : Contraseña.");
    }

    if ($pass_user != $pass_user_confirm) {
      throw new Exception("Las contraseñas ingresadas no coinciden.");
    }

    require_once "admin/core/models/ClassCliente.php";
    $VD = $OBJ_CLIENTE->insert($id_persona,$id_cliente,$id_documento,$num_documento,$nombres,$apellidos,$direccion,$correo,$telefono,$fecha_nacimiento,$sexo,$estado,$flag_imagen,$src_imagen,$name_user,$pass_user);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Su cuenta fue registrada correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
