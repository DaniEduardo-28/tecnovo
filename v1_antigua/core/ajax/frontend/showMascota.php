<?php

  try {

    if (!isset($_SESSION['id_cliente'])) {
      throw new Exception("Para realizar esta operación tiene que iniciar sesión.");
    }

    require_once "admin/core/models/ClassMascota.php";
    $Resultado = $OBJ_MASCOTA->show_mis_mascotas($_SESSION['id_cliente']);

    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }

    $count = 1;

    foreach ($Resultado["data"] as $key) {
      $estado = ($key['estado']=="activo") ? 'Activo' : 'Inactivo' ;
      $flag_editar = '<button onclick="javascript:getDataEdit(' . $key['id_mascota'] . ')" class="btn btn-warning"><i class="fa fa-pencil"></i></button>';
      $flag_imprimir = '<a href="?view=ticketvacuna&id_mascota=' . $key['id_mascota'] . '" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a>';
      $retorno_array[] =array(
        "num" => "$count",
        "id_mascota" => $key['id_mascota'],
        "cliente" => $key['nombres'] . ' ' . $key['apellidos'],
        "name_tipo" => $key['name_tipo'],
        "nombre" => $key['nombre'],
        "raza" => $key['raza'],
        "color" => $key['color'],
        "peso" => $key['peso'],
        "fecha_nacimiento" => date('d/m/Y', strtotime($key['fecha_nacimiento'])),
        "estado" => $estado,
        "options" => $flag_editar . ' ' . $flag_imprimir
      );
      $count++;
    }

    $data["error"] = "NO";
    $data["message"] = "Success";
    $data["data"] = $retorno_array;
    echo json_encode($data);

  } catch (\Exception $e) {
    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
  }

 ?>
