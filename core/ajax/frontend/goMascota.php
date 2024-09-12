<?php

  $id_mascota = isset($_POST["id_mascota"]) ? $_POST["id_mascota"] : "";
  $id_cliente = $_SESSION['id_cliente'];
  $id_tipo_mascota = isset($_POST["id_tipo_mascota"]) ? $_POST["id_tipo_mascota"] : "";
  $nombre_mascota = isset($_POST["nombre_mascota"]) ? $_POST["nombre_mascota"] : "";
  $raza = isset($_POST["raza"]) ? $_POST["raza"] : "";
  $color = isset($_POST["color"]) ? $_POST["color"] : "";
  $peso = isset($_POST["peso"]) ? $_POST["peso"] : "";
  $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : "macho";
  $fecha_nacimiento = isset($_POST["fecha_nacimiento"]) ? date('Y-m-d', strtotime($_POST["fecha_nacimiento"])) : date('Y-m-d');
  $observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : "";
  $estado = isset($_POST["estado"]) ? "activo" : "inactivo";
  $flag_imagen = isset($_POST["flag_imagen"]) ? $_POST["flag_imagen"] : 0;
  $src_imagen = "resources/global/images/sin_imagen.png";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    if (!isset($_SESSION['id_cliente'])) {
      throw new Exception("Para realizar esta operación tiene que iniciar sesión.");
    }

    if (empty(trim($nombre_mascota))) {
      throw new Exception("Campo obligatorio : Nombre de Mascota.");
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
        $carpeta = "resources/global/images/mascotas/";

        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg'){
          throw new Exception("El archivo tiene que ser extensión .jpg .jpeg.");
        } else if ($size > 1024*1024*2) {
          throw new Exception("La imagen seleccionada es demasiado grande.");
        } else if ($width > 2000 || $height > 2000) {
            throw new Exception("La imagen seleccionada no puede ser mayor a 2000px.");
        } else if($width < 60 || $height < 60) {
            throw new Exception("La imagen seleccionada no puede ser menor a 60px.");
        } else {

          $src_imagen = $carpeta.$nombre.'.png';
          $original = imagecreatefromjpeg($ruta_provisional);
          $copia = imagecreatetruecolor(500,500);
          imagecopyresampled($copia,$original,0,0,0,0,500,500,$width,$height);
          imagejpeg($copia,'admin/' . $src_imagen,100);

        }

      }

    }

    require_once "admin/core/models/ClassMascota.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_MASCOTA->insert_mi_mascota($id_mascota,$id_cliente,$id_tipo_mascota,$nombre_mascota,$raza,$color,$peso,$sexo,$fecha_nacimiento,$observaciones,$estado,$flag_imagen,$src_imagen);
        break;
      case 'edit':
        $VD = $OBJ_MASCOTA->update_mi_mascota($id_mascota,$id_cliente,$id_tipo_mascota,$nombre_mascota,$raza,$color,$peso,$sexo,$fecha_nacimiento,$observaciones,$estado,$flag_imagen,$src_imagen);
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
