<?php

  sleep(1);

  $id_categoria = isset($_POST["id_categoria"]) ? $_POST["id_categoria"] : "";
  $estado = isset($_POST["estado"]) ? 1 : 0;
  $name_categoria = isset($_POST["name_categoria"]) ? $_POST["name_categoria"] : "";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("categoriaaccesorio"));
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

    if (empty(trim($name_categoria))) {
      throw new Exception("Campo Obligatorio : Nombre de Categoria.");
    }

    require_once "core/models/ClassCategoriaAccesorio.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_CATEGORIA_ACCESORIO->insert($name_categoria,$estado);
        break;
      case 'edit':
        $VD = $OBJ_CATEGORIA_ACCESORIO->update($id_categoria,$name_categoria,$estado);
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
