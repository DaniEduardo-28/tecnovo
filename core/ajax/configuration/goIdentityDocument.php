<?php

  sleep(1);

  $id_documento = isset($_POST["id_documento"]) ? $_POST["id_documento"] : "";
  $estado = isset($_POST["estado"]) ? 'activo' : 'inactivo';
  $name_documento = isset($_POST["name_documento"]) ? $_POST["name_documento"] : "";
  $codigo_sunat = isset($_POST["codigo_sunat"]) ? $_POST["codigo_sunat"] : "";
  $size = isset($_POST["size"]) ? $_POST["size"] : "";
  $flag_exacto = isset($_POST["flag_exacto"]) ? $_POST["flag_exacto"] : "";
  $flag_numerico = isset($_POST["flag_numerico"]) ? $_POST["flag_numerico"] : "";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("identitydocuments"));
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

    if (empty(trim($name_documento))) {
      throw new Exception("Campo Obligatorio : Documento.");
    }

    if (empty(trim($codigo_sunat))) {
      throw new Exception("Campo Obligatorio : Código Sunat.");
    }

    if (empty(trim($size))) {
      throw new Exception("Campo Obligatorio : # Caracteres.");
    }

    if ($flag_exacto=="") {
      throw new Exception("Campo Obligatorio : Si es de longitud exacta.");
    }

    if ($flag_numerico=="") {
      throw new Exception("Campo Obligatorio : Si es de númerico o alfanúmerico.");
    }

    require_once "core/models/ClassDocumentoIdentidad.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_DOCUMENTO_IDENTIDAD->insert($name_documento,$codigo_sunat,$size,$flag_exacto,$flag_numerico,$estado);
        break;
      case 'edit':
        $VD = $OBJ_DOCUMENTO_IDENTIDAD->update($id_documento,$name_documento,$codigo_sunat,$size,$flag_exacto,$flag_numerico,$estado);
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
