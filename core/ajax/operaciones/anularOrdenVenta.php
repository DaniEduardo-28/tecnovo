<?php

  $id_venta = isset($_POST["id_venta"]) ? $_POST["id_venta"] : 0;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordenventa"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_anular']==false) {
        throw new Exception("No tienes permiso para anular este registro.");
      }
    }else {
      throw new Exception("Error al válidar los permisos.");
    }

    if (empty($id_venta)) {
        throw new Exception("No se recibió el campo id orden venta.");
    }

    require_once "core/models/ClassOrdenVenta.php";
    $VD = $OBJ_ORDEN_VENTA->anular($id_venta);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Registro anulado correctamente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

  function eviarDocumento($ruta,$token,$data_json){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ruta);
    curl_setopt(
      $ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Token token="'. $token . '"',
        'Accept: application/json',
    	  'Content-Type: application/json',
      )
    );
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $respuesta  = curl_exec($ch);
    curl_close($ch);
    return $respuesta;
  }
  
 ?>
