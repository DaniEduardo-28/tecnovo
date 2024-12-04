<?php

  $id_orden_compra = isset($_POST["id_orden_compra"]) ? $_POST["id_orden_compra"] : "";
  $id_trabajador = isset($_SESSION["id_trabajador"]) ? $_SESSION["id_trabajador"] : "";
  $id_tipo_docu = isset($_POST["id_tipo_docu"]) ? $_POST["id_tipo_docu"] : "";
  $id_sucursal = isset($_SESSION["id_sucursal"]) ? $_SESSION["id_sucursal"] : "";
  $num_documento = isset($_POST["num_documento"]) ? $_POST["num_documento"] : "";
  $observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : "";
  $src_evidencia = "resources/global/images/sin_imagen.png";
  $array_detalle = isset($_POST["array_detalle"]) ? $_POST["array_detalle"] : null;
  $detalle_compra = json_decode($array_detalle);
  $total = isset($_POST["total"]) ? $_POST["total"] : 0;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ingreso"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_agregar']==false) {
        throw new Exception("No tienes permisos para registrar ingresos.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if (empty(trim($id_orden_compra))) {
      throw new Exception("Campo obligatorio : Id. Orden de Compra.");
    }

    if (empty(trim($id_trabajador))) {
      throw new Exception("Campo obligatorio : Id. Trabajador.");
    }

    if (empty(trim($id_sucursal))) {
      throw new Exception("Campo obligatorio : Seleccionar sucursal.");
    }

    if (empty(trim($id_tipo_docu))) {
      throw new Exception("Campo obligatorio : Seleccionar el tipo de documento.");
    }

    if (empty(trim($num_documento))) {
      throw new Exception("Campo obligatorio : Tiene que ingresar un número de documento.");
    }

    if ($array_detalle==null) {
      throw new Exception("1. No se recibió los detalles de la orden.");
    }

    if (count($detalle_compra->datos)==0) {
      throw new Exception("2. No se recibió los detalles de la orden.");
    }

        // Manejo del archivo src_evidencia
        if (isset($_FILES['src_evidencia']) && $_FILES['src_evidencia']['error'] === UPLOAD_ERR_OK) {
          $fileTmpPath = $_FILES['src_evidencia']['tmp_name'];
          $fileName = $_FILES['src_evidencia']['name'];
          $fileSize = $_FILES['src_evidencia']['size'];
          $fileType = $_FILES['src_evidencia']['type'];
          $uploadFileDir = 'resources/global/images/';
          $dest_path = $uploadFileDir . $fileName;
    
          // Validar tipo de archivo (solo imágenes y PDFs permitidos)
          $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
          if (!in_array($fileType, $allowedTypes)) {
            throw new Exception("El tipo de archivo no es válido. Solo se permiten JPEG, PNG y PDF.");
          }
    
          // Validar tamaño máximo del archivo (ejemplo: 5 MB)
          if ($fileSize > 5 * 1024 * 1024) {
            throw new Exception("El archivo excede el tamaño máximo permitido de 5 MB.");
          }
    
          // Mover archivo al destino
          if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $src_evidencia = $dest_path;
          } else {
            throw new Exception("Error al guardar el archivo de evidencia.");
          }
        }

    require_once "core/models/ClassIngreso.php";
    $VD = $OBJ_INGRESO->insert($id_sucursal,$id_trabajador,$id_orden_compra,$id_tipo_docu,$num_documento,$observaciones,$src_evidencia,$total,$detalle_compra);

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
