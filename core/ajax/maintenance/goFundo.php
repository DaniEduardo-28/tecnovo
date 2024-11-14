<?php

  $id_fundo = isset($_POST["id_fundo"]) ? $_POST["id_fundo"] : "";
  $id_empresa = ID_EMPRESA;
  $estado = isset($_POST["estado"]) ? '1' : '0';
  $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
  $cod_ubigeo = isset($_POST["cod_ubigeo"]) ? $_POST["cod_ubigeo"] : "";
  $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : "";
  $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "";
  $mapa = isset($_POST["mapa"]) ? $_POST["mapa"] : "";
  $token = isset($_POST["token"]) ? $_POST["token"] : "";
  $ruta = isset($_POST["ruta"]) ? $_POST["ruta"] : "";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("fundos"));
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
          throw new Exception("No se recibió el parametro de acción.");
          break;
      }
    }else {
      throw new Exception("Error al validar los permisos.");
    }

    if (empty(trim($nombre))) {
      throw new Exception("Campo Obligatorio : Nombre del Fundo.");
    }


    require_once "core/models/ClassFundo.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_FUNDO->insert($id_fundo,$id_empresa,$estado,$nombre,$cod_ubigeo,$direccion,$telefono,$mapa,$token,$ruta);
        break;
      case 'edit':
        $VD = $OBJ_FUNDO->update($id_fundo,$id_empresa,$estado,$nombre,$cod_ubigeo,$direccion,$telefono,$mapa,$token,$ruta);
        break;
      default:
        $VD = "Tipo de Operación no encontrada.";
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
