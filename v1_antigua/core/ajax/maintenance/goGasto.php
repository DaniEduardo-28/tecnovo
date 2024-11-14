<?php

  $id_gasto = isset($_POST["id_gasto"]) ? $_POST["id_gasto"] : "";
  $id_tipo_gasto = isset($_POST["id_tipo_gasto"]) ? $_POST["id_tipo_gasto"] : "";
  $name_gasto = isset($_POST["name_gasto"]) ? $_POST["name_gasto"] : "";
  $descripcion_gasto = isset($_POST["descripcion_gasto"]) ? $_POST["descripcion_gasto"] : "";
  $estado = isset($_POST["estado"]) ? 1 : 0;
  $flag_igv = isset($_POST["flag_igv"]) ? 1 : 0;
   $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_persona'],printCodeOption("gasto"));
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
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if (empty(trim($id_tipo_gasto))) {
      throw new Exception("Campo obligatorio : Tipo de Gasto.");
    }

    if (empty(trim($name_gasto))) {
      throw new Exception("Campo obligatorio : Nombre del Gasto.");
    }

  


    require_once "core/models/ClassGasto.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_GASTO->insert($id_gasto,$id_tipo_gasto,$name_gasto,$descripcion_gasto,$estado,$flag_igv);
        break;
      case 'edit':
        $VD = $OBJ_GASTO->update($id_gasto,$id_tipo_gasto,$name_gasto,$descripcion_gasto,$estado,$flag_igv);
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
