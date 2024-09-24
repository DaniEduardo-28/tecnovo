<?php

  sleep(1);

  $id_tipo_cosecha = isset($_POST["id_tipo_cosecha"]) ? $_POST["id_tipo_cosecha"] : "";
  $estado = isset($_POST["estado"]) ? 1 : 0;
  $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("tipocosecha"));
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

    if (empty(trim($descripcion))) {
      throw new Exception("Campo Obligatorio : Nombre de Tipo de Cosecha.");
    }

    require_once "core/models/ClassTipoCosecha.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_TIPO_COSECHA->insert($descripcion,$estado);
        break;
      case 'edit':
        $VD = $OBJ_TIPO_COSECHA->update($id_tipo_cosecha,$descripcion,$estado);
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