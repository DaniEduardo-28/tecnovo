<?php

  sleep(2);

  $id_empresa = isset($_POST["id_empresa"]) ? $_POST["id_empresa"] : "";
  $id_documento = isset($_POST["id_documento"]) ? $_POST["id_documento"] : "";
  $num_documento = isset($_POST["num_documento"]) ? $_POST["num_documento"] : "";
  $razon_social = isset($_POST["razon_social"]) ? $_POST["razon_social"] : "";
  $nombre_comercial = isset($_POST["nombre_comercial"]) ? $_POST["nombre_comercial"] : "";
  $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : "";
  $fono01 = isset($_POST["fono01"]) ? $_POST["fono01"] : "";
  $fono02 = isset($_POST["fono02"]) ? $_POST["fono02"] : "";
  $correo01 = isset($_POST["correo01"]) ? $_POST["correo01"] : "";
  $correo02 = isset($_POST["correo02"]) ? $_POST["correo02"] : "";
  $web = isset($_POST["web"]) ? $_POST["web"] : "";
  $id_documento_representante = isset($_POST["id_documento_representante"]) ? $_POST["id_documento_representante"] : "";
  $num_documento_representante = isset($_POST["num_documento_representante"]) ? $_POST["num_documento_representante"] : "";
  $nombres_representante = isset($_POST["nombres_representante"]) ? $_POST["nombres_representante"] : "";
  $apellidos_representante = isset($_POST["apellidos_representante"]) ? $_POST["apellidos_representante"] : "";
  $flag_imagen = isset($_POST["flag_imagen"]) ? $_POST["flag_imagen"] : "";
  $src_imagen = "resources/global/images/sin_imagen.png";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("mybusiness"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permiso para modificar los datos de la empresa.");
      }
    }else {
      throw new Exception("Ocurrió un error al realizar la consulta.");
    }


    if (empty(trim($id_empresa))) {
      throw new Exception("Id Empresa no válido.");
    }

    if (empty(trim($id_documento))) {
      throw new Exception("Campo obligatorio : Documento de empresa.");
    }

    if (empty(trim($num_documento))) {
      throw new Exception("Campo obligatorio : Número de Documento.");
    }

    if (empty(trim($razon_social))) {
      throw new Exception("Campo obligatorio : Razón Social.", 1);
    }

    if (empty(trim($nombre_comercial))) {
      throw new Exception("Campo obligatorio : Nombre Comercial.");
    }

    if (empty(trim($id_documento_representante))) {
      throw new Exception("Campo obligatorio : Documento Representante.");
    }

    if (empty(trim($num_documento_representante))) {
      throw new Exception("Campo obligatorio : Número Documento Representante.");
    }

    if (empty(trim($nombres_representante))) {
      throw new Exception("Campo obligatorio : Nombre Representante.");
    }

    if (empty(trim($apellidos_representante))) {
      throw new Exception("Campo obligatorio : Apellidos Representante.");
    }

    if (trim($correo01)!="") {
      if (validar_email($correo01)==false) {
        throw new Exception("Formato de correo de la empresa no válido.");
      }
    }

    if (trim($fono01)!="") {
      if (validar_number($fono01)==false) {
        throw new Exception("Formato de telefono de la empresa no válido.");
      }
    }

    if (trim($correo02)!="") {
      if (validar_email($correo02)==false) {
        throw new Exception("Formato de correo del representante no válido.");
      }
    }

    if (trim($fono02)!="") {
      if (validar_number($fono02)==false) {
        throw new Exception("Formato de telefono del representante no válido.");
      }
    }

    require_once "core/models/ClassDocumentoIdentidad.php";
    $resultDoc1 = $OBJ_DOCUMENTO_IDENTIDAD->getDocumentoForId($id_documento);
    $resultDoc2 = $OBJ_DOCUMENTO_IDENTIDAD->getDocumentoForId($id_documento_representante);
    if ($resultDoc1['error']=="SI") {
      throw new Exception($resultDoc1['message']);
    }
    if ($resultDoc2['error']=="SI") {
      throw new Exception($resultDoc2['message']);
    }

    $dataResultDoc1 = $resultDoc1['data'];
    $dataResultDoc2 = $resultDoc2['data'];

    if ($dataResultDoc1[0]['flag_exacto']=="1") {
      if ($dataResultDoc1[0]['size']!=strlen($num_documento)) {
        throw new Exception("El documento de la empresa tiene que tener " . $dataResultDoc1[0]['size'] . " dígitos.");
      }
    }else {
      if ($dataResultDoc1[0]['size']<strlen($num_documento)) {
        throw new Exception("El documento de la empresa tiene que tener menor o igual de " . $dataResultDoc1[0]['size'] . " dígitos.");
      }
    }

    if ($dataResultDoc1[0]['flag_numerico']=="1") {
      if (validar_number($num_documento)==false) {
        throw new Exception("El documento de la empresa tiene que ser sólo números.");
      }
    }

    if ($dataResultDoc2[0]['flag_exacto']=="1") {
      if ($dataResultDoc2[0]['size']!=strlen($num_documento_representante)) {
        throw new Exception("El documento del representante tiene que tener " . $dataResultDoc2[0]['size'] . " dígitos.");
      }
    }else {
      if ($dataResultDoc2[0]['size']<strlen($num_documento_representante)) {
        throw new Exception("El documento del representante tiene que tener menor o igual de " . $dataResultDoc2[0]['size'] . " dígitos.");
      }
    }

    if ($dataResultDoc2[0]['flag_numerico']=="1") {
      if (validar_number($num_documento_representante)==false) {
        throw new Exception("El documento del representante tiene que ser sólo números.");
      }
    }

    if ($flag_imagen=="1") {

      if (isset($_FILES["imagen"])){

        $file = $_FILES["imagen"];
        $nombre_file = 'img-' . time();
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = "resources/global/images/business_logo/";

        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg'){
          throw new Exception("El archivo tiene que ser extensión .jpg .jpeg.");
        } else if ($size > 1024*1024*2) {
          throw new Exception("La imagen seleccionada es demasiado grande.");
        } else if ($width > 2000 || $height > 2000) {
          throw new Exception("La imagen seleccionada no puede ser mayor a 1500px.");
        } else if($width < 60 || $height < 60) {
          throw new Exception("La imagen seleccionada no puede ser menor a 60px.");
        } else {

          $src_imagen = $carpeta.$nombre_file.'.jpg';
          $original = imagecreatefromjpeg($ruta_provisional);
          $copia = imagecreatetruecolor(500,500);
          imagecopyresampled($copia,$original,0,0,0,0,500,500,$width,$height);
          imagejpeg($copia,$src_imagen,100);

        }

      }else {
        throw new Exception("No se recibió una imagen válida para el logo de la empresa.");
      }

    }

    require_once "core/models/ClassEmpresa.php";
    $VD = $OBJ_EMPRESA->update($id_empresa,$id_documento,$num_documento,$razon_social,$nombre_comercial,$direccion,$fono01,$fono02,$correo01,$correo02,$web,$id_documento_representante,$num_documento_representante,$nombres_representante,$apellidos_representante,$flag_imagen,$src_imagen);
    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Datos actualizados correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
