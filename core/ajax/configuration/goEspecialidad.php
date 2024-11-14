<?php

  sleep(1);

  $id_especialidad = isset($_POST["id_especialidad"]) ? $_POST["id_especialidad"] : "";
  $estado = isset($_POST["estado"]) ? 1 : 0;
  $name_especialidad = isset($_POST["name_especialidad"]) ? $_POST["name_especialidad"] : "";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("especialidad"));
    if ($access_options[0]['error']=="NO") {
      switch ($accion) {
        case 'add':
          if ($access_options[0]['flag_agregar']==false) {
            throw new Exception("No tienes permiso para agregar especialidades.");
          }
          break;
        case 'edit':
          if ($access_options[0]['flag_editar']==false) {
            throw new Exception("No tienes permiso para editar especialidades.");
          }
          break;
        default:
          throw new Exception("Acción no recibida.");
          break;
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if (empty(trim($name_especialidad))) {
      throw new Exception("Campo Obligatorio : Nombre de Cargo.");
    }

    require_once "core/models/ClassEspecialidad.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_ESPECIALIDAD->insert($name_especialidad,$estado);
        break;
      case 'edit':
        $VD = $OBJ_ESPECIALIDAD->update($id_especialidad,$name_especialidad,$estado);
        break;
      default:
        $VD = "Error de operación";
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
