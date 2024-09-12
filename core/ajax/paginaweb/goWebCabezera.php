<?php

  $flag_imagen_1 = isset($_POST["flag_imagen_1"]) ? $_POST["flag_imagen_1"] : "";
  $flag_imagen_2 = isset($_POST["flag_imagen_2"]) ? $_POST["flag_imagen_2"] : "";
  $flag_imagen_3 = isset($_POST["flag_imagen_3"]) ? $_POST["flag_imagen_3"] : "";
  $src_imagen_1 = "resources/global/images/sin_imagen.png";
  $src_imagen_2 = "resources/global/images/sin_imagen.png";
  $src_imagen_3 = "resources/global/images/sin_imagen.png";
  $titulo_1 = isset($_POST["titulo_1"]) ? $_POST["titulo_1"] : "";
  $titulo_2 = isset($_POST["titulo_2"]) ? $_POST["titulo_2"] : "";
  $titulo_3 = isset($_POST["titulo_3"]) ? $_POST["titulo_3"] : "";
  $descripcion_1 = isset($_POST["descripcion_1"]) ? $_POST["descripcion_1"] : "";
  $descripcion_2 = isset($_POST["descripcion_2"]) ? $_POST["descripcion_2"] : "";
  $descripcion_3 = isset($_POST["descripcion_3"]) ? $_POST["descripcion_3"] : "";
  $boton_1 = isset($_POST["boton_1"]) ? $_POST["boton_1"] : "";
  $boton_2 = isset($_POST["boton_2"]) ? $_POST["boton_2"] : "";
  $boton_3 = isset($_POST["boton_3"]) ? $_POST["boton_3"] : "";
  $enlace_1 = isset($_POST["enlace_1"]) ? $_POST["enlace_1"] : "";
  $enlace_2 = isset($_POST["enlace_2"]) ? $_POST["enlace_2"] : "";
  $enlace_3 = isset($_POST["enlace_3"]) ? $_POST["enlace_3"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("webcabezera"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permiso para modificar los datos de la cabezera.");
      }
    }else {
      throw new Exception("Ocurrió un error al realizar la consulta.");
    }

    if ($flag_imagen_1 == "1") {

      if (isset($_FILES["imagen_1"])){

        $file = $_FILES["imagen_1"];
        $nombre_file = 'img-' . time();
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = "resources/global/images/banners/";

        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg'){
          throw new Exception("El archivo tiene que ser extensión .jpg .jpeg.");
        } else if ($size > 1024*1024*4) {
          throw new Exception("La imagen del banner 1 es demasiado grande.");
        } else if ($width > 2000 || $height > 2000) {
          throw new Exception("La imagen del banner 1 no puede ser mayor a 1500px.");
        } else if($width < 60 || $height < 60) {
          throw new Exception("La imagen del banner 1 no puede ser menor a 60px.");
        } else {

          $src_imagen_1 = $carpeta.$nombre_file.'.png';
          $original = imagecreatefromjpeg($ruta_provisional);
          $copia = imagecreatetruecolor(1920,720);
          imagecopyresampled($copia,$original,0,0,0,0,1920,720,$width,$height);
          imagejpeg($copia,$src_imagen_1,100);

        }

      }else {
        throw new Exception("No se recibió una imagen válida para el banner 1.");
      }

    }

    if ($flag_imagen_2 == "1") {

      if (isset($_FILES["imagen_2"])){

        $file = $_FILES["imagen_2"];
        $nombre_file = 'img-' . time();
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = "resources/global/images/banners/";

        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg'){
          throw new Exception("El archivo del banner 2 tiene que ser extensión .jpg .jpeg.");
        } else if ($size > 1024*1024*4) {
          throw new Exception("La imagen del banner 2 es demasiado grande.");
        } else if ($width > 2000 || $height > 2000) {
          throw new Exception("La imagen del banner 2 no puede ser mayor a 1500px.");
        } else if($width < 60 || $height < 60) {
          throw new Exception("La imagen del banner 2 no puede ser menor a 60px.");
        } else {

          $src_imagen_2 = $carpeta.$nombre_file.'.png';
          $original = imagecreatefromjpeg($ruta_provisional);
          $copia = imagecreatetruecolor(1920,720);
          imagecopyresampled($copia,$original,0,0,0,0,1920,720,$width,$height);
          imagejpeg($copia,$src_imagen_2,100);

        }

      }else {
        throw new Exception("No se recibió una imagen válida para el banner 2.");
      }

    }

    if ($flag_imagen_3 == "1") {

      if (isset($_FILES["imagen_3"])){

        $file = $_FILES["imagen_3"];
        $nombre_file = 'img-' . time();
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = "resources/global/images/banners/";

        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg'){
          throw new Exception("El archivo del banner 3 tiene que ser extensión .jpg .jpeg.");
        } else if ($size > 1024*1024*4) {
          throw new Exception("La imagen del banner 3 es demasiado grande.");
        } else if ($width > 2000 || $height > 2000) {
          throw new Exception("La imagen del banner 3 no puede ser mayor a 1500px.");
        } else if($width < 60 || $height < 60) {
          throw new Exception("La imagen del banner 3 no puede ser menor a 60px.");
        } else {

          $src_imagen_3 = $carpeta.$nombre_file.'.png';
          $original = imagecreatefromjpeg($ruta_provisional);
          $copia = imagecreatetruecolor(1920,720);
          imagecopyresampled($copia,$original,0,0,0,0,1920,720,$width,$height);
          imagejpeg($copia,$src_imagen_3,100);

        }

      }else {
        throw new Exception("No se recibió una imagen válida para el banner 3.");
      }

    }

    require_once "core/models/ClassOverall.php";
    $VD = $OBJ_OVERALL->updateCabezera($flag_imagen_1,$flag_imagen_2,$flag_imagen_3,$src_imagen_1,$src_imagen_2,$src_imagen_3,$titulo_1,$titulo_2,$titulo_3,$descripcion_1,$descripcion_2,$descripcion_3,$boton_1,$boton_2,$boton_3,$enlace_1,$enlace_2,$enlace_3);
    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Los datos de la cabezera fueron actualizados correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
