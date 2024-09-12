<?php

  $id_cliente = isset($_POST["id_cliente"]) ? $_POST["id_cliente"] : "";
  $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : "";
  $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
  $fecha_inicio = isset($_POST["fecha_inicio"]) ? $_POST["fecha_inicio"] : date('Y-m-d');
  $fecha_fin = isset($_POST["fecha_fin"]) ? $_POST["fecha_fin"] : date('Y-m-d');
  $src_imagen = "resources/global/images/sin_imagen.png";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_persona'],printCodeOption("promocion"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_agregar']==false) {
        throw new Exception("No tienes permisos para agregar promociones.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if (empty(trim($titulo))) {
      throw new Exception("Campo obligatorio : Título.");
    }

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

        $src_imagen = $carpeta.$nombre.'.jpg';
        $original = imagecreatefromjpeg($ruta_provisional);
        $copia = imagecreatetruecolor(370,340);
        imagecopyresampled($copia,$original,0,0,0,0,370,340,$width,$height);
        imagejpeg($copia,$src_imagen,100);

      }

    }

    require_once "core/models/ClassCliente.php";
    $VD = $OBJ_CLIENTE->addPromocion($id_cliente,$titulo,$descripcion,$fecha_inicio,$fecha_fin,$src_imagen);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $Result = $OBJ_CLIENTE->getDataEditCliente($id_cliente);
    if ($Result["error"]=="SI") {
      throw new Exception("Promoción agregada correctamente. Pero ocurrió un error al obtener los datos de correo");
    }

    $correo = $Result["data"][0]['name_user'];
    if (validar_email($correo)==true) {

      // Varios destinatarios
      $para  = $correo; // atención a la coma

      // mensaje
      $mensaje = '
      <html>
      <head>
        <title>Se registró una nueva promoción</title>
      </head>
      <body>
        <h3 style="text-align : center;">' . strtoupper($titulo) . '</h3>
        <table>
          <tr>
            <th colspan="2"><img src="' . APP_URL . $src_imagen . '"/></th>
          </tr>
          <tr>
            <th style="text-align : center;">Descripción</th><th style="text-align : center;">Datos de Cita</th>
          </tr>
          <tr>
            <td>Descripción</td><td>' . $descripcion . '</td>
          </tr>
          <tr>
            <td>Fecha Inicio</td><td>' . date('d/m/Y', strtotime($fecha_inicio)) . '</td>
          </tr>
          <tr>
            <td>Fecha Fin</td><td>' . date('d/m/Y', strtotime($fecha_fin)) . '</td>
          </tr>
          <tr>
            <td>Descripción </td><td>' . $descripcion . '</td>
          </tr>
        </table>
      </body>
      </html>
      ';

      // Para enviar un correo HTML, debe establecerse la cabecera Content-type
      $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
      $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

      // send the email
      if(!mail($para, $titulo, $mensaje, $cabeceras)){
        throw new Exception("Promoción agregada correctamente en el sistema, pero ocurrió un error al enviar el correo electrónico de aviso al cliente.");
      }

    }

    $data["error"]="NO";
    $data["message"]="Promoción agregada correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
