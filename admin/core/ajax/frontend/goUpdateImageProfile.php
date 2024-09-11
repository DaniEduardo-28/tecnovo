<?php
  if (isset($_FILES["txtImgProfile"])){

      try {

        if (!isset($_SESSION['id_cliente'])) {
          throw new Exception("Para realizar esta operación tiene que iniciar sesión.");
        }

        require_once "admin/core/models/ClassUsuario.php";

        $name_user = $_SESSION['name_user_cliente'];
        $id_cliente = $_SESSION['id_cliente'];

        $file = $_FILES["txtImgProfile"];
        $nombre = $name_user . '-' . time();
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = "resources/global/images/persons/";

        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg'){
          throw new Exception("El archivo tiene que ser extensión .jpg .jpeg.");
        } else if ($size > 1024*1024*2) {
          throw new Exception("La imagen seleccionada es demasiado grande.");
        } else if ($width > 2000 || $height > 2000) {
          throw new Exception("La imagen seleccionada no puede ser mayor a 2000px.");
        } else if($width < 60 || $height < 60) {
          throw new Exception("La imagen seleccionada no puede ser menor a 60px.");
        } else {

            $src = $carpeta.$nombre.'.png';
            $original = imagecreatefromjpeg($ruta_provisional);
            $copia = imagecreatetruecolor(500,500);
            imagecopyresampled($copia,$original,0,0,0,0,500,500,$width,$height);
            imagejpeg($copia,"admin/" . $src,100);
            $VD = $OBJ_USUARIO->updateImageProfileCliente($id_cliente,$src);

            if ($VD!="OK") {
              throw new Exception($VD);
            }

            $_SESSION["src_imagen_cliente"] = $src;
            $data["error"]="NO";
            $data["message"]="Imagen de perfil, actualizada correctamente.";
            $data["data"] = null;
            echo json_encode($data);

        }

      } catch (\Exception $e) {

        $data["error"]="SI";
        $data["message"]=$e->getMessage();
        $data["data"] = null;
        echo json_encode($data);
        exit();

      }

  } else {

    $data["error"]="SI";
    $data["message"]="No se recibieron los parámetros solicitados.";
    $data["data"] = null;
    echo json_encode($data);
    exit();

  }

?>
