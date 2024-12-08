<?php

$id_ingreso = $_POST['id_ingreso_pago'] ?? null;
$fecha_pago = $_POST['fecha_pago'] ?? null;
$id_forma_pago = $_POST['id_forma_pago'] ?? null;
$monto_pagado = $_POST['monto_pagado'] ?? null;
$src_factura = "resources/global/images/sin_imagen.png";

try {

  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ingreso"));
  if ($access_options[0]['error'] == "NO") {
    if ($access_options[0]['flag_agregar'] == false) {
      throw new Exception("No tienes permisos para registrar ingresos.");
    }
  } else {
    throw new Exception("Error al verificar los permisos.");
  }

        // Manejo del archivo
        if (isset($_FILES['src_factura']) && $_FILES['src_factura']['error'] === UPLOAD_ERR_OK) {
          $fileTmpPath = $_FILES['src_factura']['tmp_name'];
          $fileName = $_FILES['src_factura']['name'];
          $fileSize = $_FILES['src_factura']['size'];
          $fileType = $_FILES['src_factura']['type'];
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
            $src_factura = $dest_path;
          } else {
            throw new Exception("Error al guardar el archivo de factura.");
          }
        }

  require_once "core/models/ClassIngreso.php";
  $VD = $OBJ_INGRESO->addPagos($id_ingreso, $id_forma_pago, $fecha_pago, $monto_pagado, $src_factura);

  if ($VD != "OK") {
    throw new Exception($VD);
  }

  $data["error"] = "NO";
  $data["message"] = "Operación realizada correctamente.";
  $data["data"] = null;
  echo json_encode($data);

} catch (\Exception $e) {

  $data["error"] = "SI";
  $data["message"] = $e->getMessage();
  $data["data"] = null;
  echo json_encode($data);

}
