<?php



  $id_tipo_mascota = isset($_POST["id_tipo_mascota"]) ? $_POST["id_tipo_mascota"] : "";
  $estado = isset($_POST["estado"]) ? 1 : 0;
  $name_tipo = isset($_POST["name_tipo"]) ? $_POST["name_tipo"] : "";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("tipomascota"));
    if ($access_options[0]['error']=="NO") {
      switch ($accion) {
        case 'add':
          if ($access_options[0]['flag_agregar']==false) {
            throw new Exception("No tienes permiso para agregar.");
          }
          break;
        case 'edit':
          if ($access_options[0]['flag_editar']==false) {
            throw new Exception("No tienes permiso para editar.");
          }
          break;
        default:
          throw new Exception("Acción no recibida.");
          break;
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if (empty(trim($name_tipo))) {
      throw new Exception("Campo Obligatorio : Nombre de Tipo de Operación.");
    }

    require_once "core/models/ClassTipoMascota.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_TIPO_MASCOTA->insert($name_tipo,$estado);
        break;
      case 'edit':
        $VD = $OBJ_TIPO_MASCOTA->update($id_tipo_mascota,$name_tipo,$estado);
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
