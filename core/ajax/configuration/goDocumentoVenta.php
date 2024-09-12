<?php

  $id_documento_venta = isset($_POST["id_documento_venta"]) ? $_POST["id_documento_venta"] : "";
  $id_sucursal = $_SESSION['id_sucursal'];
  $estado = isset($_POST["estado"]) ? '1' : '0';
  $flag_doc_interno = isset($_POST["flag_doc_interno"]) ? '1' : '0';
  $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
  $nombre_corto = isset($_POST["nombre_corto"]) ? $_POST["nombre_corto"] : "";
  $cod_sunat = isset($_POST["cod_sunat"]) ? $_POST["cod_sunat"] : "";
  $serie = isset($_POST["serie"]) ? $_POST["serie"] : "";
  $correlativo = isset($_POST["correlativo"]) ? $_POST["correlativo"] : "";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("documentoventa"));
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
      throw new Exception("Campo Obligatorio : Nombre de Documento.");
    }

    if (empty(trim($cod_sunat))) {
      throw new Exception("Campo Obligatorio : Código Sunat.");
    }

    if (empty(trim($serie))) {
      throw new Exception("Campo Obligatorio : Serie.");
    }

    if (empty(trim($correlativo))) {
      throw new Exception("Campo Obligatorio : Correlativo.");
    }

    require_once "core/models/ClassDocumentoVenta.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_DOCUMENTO_VENTA->insert($id_documento_venta,$id_sucursal,$estado,$flag_doc_interno,$nombre,$nombre_corto,$cod_sunat,$serie,$correlativo);
        break;
      case 'edit':
        $VD = $OBJ_DOCUMENTO_VENTA->update($id_documento_venta,$id_sucursal,$estado,$flag_doc_interno,$nombre,$nombre_corto,$cod_sunat,$serie,$correlativo);
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
