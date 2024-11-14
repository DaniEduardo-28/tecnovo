<?php

  $id_persona = isset($_POST["id_persona"]) ? $_POST["id_persona"] : "";
  $id_proveedor = isset($_POST["id_proveedor"]) ? $_POST["id_proveedor"] : "";
  $id_documento = isset($_POST["id_documento"]) ? $_POST["id_documento"] : "";
  $num_documento = isset($_POST["num_documento"]) ? $_POST["num_documento"] : "";
  $nombres = isset($_POST["nombres"]) ? $_POST["nombres"] : "";
  $apellidos = isset($_POST["apellidos"]) ? $_POST["apellidos"] : "";
  $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : "";
  $correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
  $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "";
  $estado = isset($_POST["estado"]) ? '1' : '0';
  $flag_imagen = isset($_POST["flag_imagen"]) ? $_POST["flag_imagen"] : "";
  $src_imagen = "resources/global/images/sin_imagen.png";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("proveedor"));
    if ($access_options[0]['error']=="NO") {
      switch ($accion) {
        case 'add':
          if ($access_options[0]['flag_agregar']==false) {
            throw new Exception("No tienes permisos para agregar.");
          }
          break;
        case 'edit':
          if ($access_options[0]['flag_editar']==false) {
            throw new Exception("No tienes permisos para modificar.");
          }
          break;
        default:
          throw new Exception("Acción no recibida.");
          break;
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

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

    if (trim($correo)!="") {
      if (validar_email($correo)==false) {
        throw new Exception("Formato de correo del trabajador no válido.");
      }
    }

    if (trim($telefono)!="") {
      if (validar_number($telefono)==false) {
        throw new Exception("Formato de telefono del trabajador no válido.");
      }
    }

    require_once "core/models/ClassDocumentoIdentidad.php";
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

    if ($flag_imagen=="1") {

      if (isset($_FILES["src_imagen"])){

        $file = $_FILES["src_imagen"];
        $nombre = 'img-' . time();
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = "resources/global/images/persons/";

        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg'){
          throw new Exception("El archivo tiene que ser extensión .jpg .jpeg.");
        } else if ($size > 1024*1024*4) {
          throw new Exception("La imagen seleccionada es demasiado grande.");
        } else if ($width > 3000 || $height > 3000) {
            throw new Exception("La imagen seleccionada no puede ser mayor a 2000px.");
        } else if($width < 60 || $height < 60) {
            throw new Exception("La imagen seleccionada no puede ser menor a 60px.");
        } else {

          $src_imagen = $carpeta.$nombre.'.png';
          $original = imagecreatefromjpeg($ruta_provisional);
          $copia = imagecreatetruecolor(500,500);
          imagecopyresampled($copia,$original,0,0,0,0,500,500,$width,$height);
          imagejpeg($copia,$src_imagen,100);

        }

      }

    }

    require_once "core/models/ClassProveedor.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_PROVEEDOR->insert($id_persona,$id_proveedor,$id_documento,$num_documento,$nombres,$apellidos,$direccion,$correo,$telefono,$estado,$flag_imagen,$src_imagen);
        break;
      case 'edit':
        $VD = $OBJ_PROVEEDOR->update($id_persona,$id_proveedor,$id_documento,$num_documento,$nombres,$apellidos,$direccion,$correo,$telefono,$estado,$flag_imagen,$src_imagen);
        break;
      default:
        $VD = "No se recibió parametro de acción.";
        break;
    }

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
