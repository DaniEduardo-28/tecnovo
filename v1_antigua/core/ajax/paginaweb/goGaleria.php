<?php

  $id = isset($_POST["id"]) ? $_POST["id"] : "";
  $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : "";
  $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
  $estado = isset($_POST["estado"]) ? 1 : 0;
  $flag_imagen = isset($_POST["flag_imagen"]) ? $_POST["flag_imagen"] : 0;
  $src_imagen = "resources/global/images/sin_imagen.png";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_persona'],printCodeOption("webgaleria"));
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

    if (empty(trim($titulo))) {
      throw new Exception("Campo obligatorio : Título.");
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
        $carpeta = "resources/global/images/galeria/";

        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg'){
          throw new Exception("El archivo tiene que ser extensión .jpg .jpeg.");
        } else if ($size > 1024*1024*2) {
          throw new Exception("La imagen seleccionada es demasiado grande.");
        } else if ($width > 2000 || $height > 2000) {
            throw new Exception("La imagen seleccionada no puede ser mayor a 1500px.");
        } else if($width < 60 || $height < 60) {
            throw new Exception("La imagen seleccionada no puede ser menor a 60px.");
        } else {

          $src_imagen = $carpeta.$nombre.'.png';
          $original = imagecreatefromjpeg($ruta_provisional);
          $copia = imagecreatetruecolor(370,340);
          imagecopyresampled($copia,$original,0,0,0,0,370,340,$width,$height);
          imagejpeg($copia,$src_imagen,100);

        }

      }

    }

    require_once "core/models/ClassGaleria.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_GALERIA->insert($id,$titulo,$descripcion,$estado,$flag_imagen,$src_imagen);
        break;
      case 'edit':
        $VD = $OBJ_GALERIA->update($id,$titulo,$descripcion,$estado,$flag_imagen,$src_imagen);
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
