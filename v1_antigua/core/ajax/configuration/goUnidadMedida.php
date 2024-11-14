<?php

  $id_unidad_medida = isset($_POST["id_unidad_medida"]) ? $_POST["id_unidad_medida"] : "";
  $estado = isset($_POST["estado"]) ? '1' : '0';
  $name_unidad = isset($_POST["name_unidad"]) ? $_POST["name_unidad"] : "";
  $cod_sunat = isset($_POST["cod_sunat"]) ? $_POST["cod_sunat"] : "";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("unidadmedida"));
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

    if (empty(trim($name_unidad))) {
      throw new Exception("Campo Obligatorio : Nombre de Unidad de Medida.");
    }

    if (empty(trim($cod_sunat))) {
      throw new Exception("Campo Obligatorio : Código Sunat.");
    }

    require_once "core/models/ClassUnidadMedida.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_UNIDAD_MEDIDA->insert($id_unidad_medida,$name_unidad,$cod_sunat,$estado);
        break;
      case 'edit':
        $VD = $OBJ_UNIDAD_MEDIDA->update($id_unidad_medida,$name_unidad,$cod_sunat,$estado);
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
