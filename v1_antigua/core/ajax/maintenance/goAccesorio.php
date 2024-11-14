<?php

  $id_accesorio = isset($_POST["id_accesorio"]) ? $_POST["id_accesorio"] : "";
  $id_categoria = isset($_POST["id_categoria"]) ? $_POST["id_categoria"] : "";
  $name_accesorio = isset($_POST["name_accesorio"]) ? $_POST["name_accesorio"] : "";
  $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
  $stock = isset($_POST["stock"]) ? $_POST["stock"] : 0;
  $stock_minimo = isset($_POST["stock_minimo"]) ? $_POST["stock_minimo"] : 0;
  $precio_compra = isset($_POST["precio_compra"]) ? $_POST["precio_compra"] : 0;
  $precio_venta = isset($_POST["precio_venta"]) ? $_POST["precio_venta"] : 0;
  $estado = isset($_POST["estado"]) ? 1 : 0;
  $flag_imagen = isset($_POST["flag_imagen"]) ? $_POST["flag_imagen"] : 0;
  $src_imagen = "resources/global/images/sin_imagen.png";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";
  $id_fundo = isset($_SESSION["id_fundo"]) ? $_SESSION["id_fundo"] : 0;
  $id_unidad_medida = isset($_POST["id_unidad_medida"]) ? $_POST["id_unidad_medida"] : 0;
  $id_moneda = isset($_POST["id_moneda"]) ? $_POST["id_moneda"] : 0;
  $flag_igv = isset($_POST["flag_igv"]) ? 1 : 0;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("accesorio"));
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

    if (empty(trim($id_categoria))) {
      throw new Exception("Campo obligatorio : Categoria de Producto, Servicios y Gastos.");
    }

    if (empty(trim($id_fundo))) {
      throw new Exception("Campo obligatorio : Sucursal.");
    }

    if (empty(trim($id_unidad_medida))) {
      throw new Exception("Campo obligatorio : Unidad de Medida.");
    }

    if (empty(trim($id_moneda))) {
      throw new Exception("Campo obligatorio : Moneda.");
    }

    if (empty(trim($name_accesorio))) {
      throw new Exception("Campo obligatorio : Nombre de Producto.");
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
        $carpeta = "resources/global/images/accesorios/";

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

    require_once "core/models/ClassAccesorio.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_ACCESORIO->insert($id_accesorio,$id_categoria,$name_accesorio,$descripcion,$stock,$stock_minimo,$precio_compra,$precio_venta,$estado,$flag_imagen,$src_imagen,$id_fundo,$id_unidad_medida,$id_moneda,$flag_igv);
        break;
      case 'edit':
        $VD = $OBJ_ACCESORIO->update($id_accesorio,$id_categoria,$name_accesorio,$descripcion,$stock,$stock_minimo,$precio_compra,$precio_venta,$estado,$flag_imagen,$src_imagen,$id_fundo,$id_unidad_medida,$id_moneda,$flag_igv);
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
