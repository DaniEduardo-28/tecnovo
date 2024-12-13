<?php

  $id_servicio = isset($_POST["id_servicio"]) ? $_POST["id_servicio"] : "";
  $id_tipo_servicio = isset($_POST["id_tipo_servicio"]) ? $_POST["id_tipo_servicio"] : "";
  $id_maquinaria = isset($_POST["id_maquinaria"]) ? $_POST["id_maquinaria"] : "";
  $id_unidad_medida = isset($_POST["id_unidad_medida"]) ? $_POST["id_unidad_medida"] : "";
  $name_servicio = isset($_POST["name_servicio"]) ? $_POST["name_servicio"] : "";
  $descripcion_breve = isset($_POST["descripcion_breve"]) ? $_POST["descripcion_breve"] : "";
  $descripcion_larga = isset($_POST["descripcion_larga"]) ? $_POST["descripcion_larga"] : "";
  $id_moneda = isset($_POST["id_moneda"]) ? $_POST["id_moneda"] : "";
  $precio = isset($_POST["precio"]) ? $_POST["precio"] : 0.00;
  $estado = isset($_POST["estado"]) ? 1 : 0;
  $flag_igv = isset($_POST["flag_igv"]) ? 1 : 0;
  $flag_imagen = isset($_POST["flag_imagen"]) ? $_POST["flag_imagen"] : "";
  $src_imagen = "resources/global/images/sin_imagen.png";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_persona'],printCodeOption("servicio"));
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

    if (empty(trim($id_tipo_servicio))) {
      throw new Exception("Campo obligatorio : Unidad de negocio.");
    }
    if (empty(trim($id_maquinaria))) {
      throw new Exception("Campo obligatorio : Maquinaria.");
    }

    if (empty(trim($name_servicio))) {
      throw new Exception("Campo obligatorio : Nombre del Servicio.");
    }

    if (empty(trim($id_moneda))) {
      throw new Exception("Campo obligatorio : Moneda.");
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
        $carpeta = "resources/global/images/servicios/";

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
          $copia = imagecreatetruecolor(500,500);
          imagecopyresampled($copia,$original,0,0,0,0,500,500,$width,$height);
          imagejpeg($copia,$src_imagen,100);

        }

      }

    }

    require_once "core/models/ClassServicio.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_SERVICIO->insert($id_servicio,$id_tipo_servicio,$id_maquinaria,$id_unidad_medida,$name_servicio,$descripcion_breve,$descripcion_larga,$precio,$estado,$flag_imagen,$src_imagen,$id_moneda,$flag_igv);
        break;
      case 'edit':
        $VD = $OBJ_SERVICIO->update($id_servicio,$id_tipo_servicio,$id_maquinaria,$id_unidad_medida,$name_servicio,$descripcion_breve,$descripcion_larga,$precio,$estado,$flag_imagen,$src_imagen,$id_moneda,$flag_igv);
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
