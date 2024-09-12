<?php

  $id_moneda = isset($_POST["id_moneda"]) ? $_POST["id_moneda"] : "";
  $estado = isset($_POST["estado"]) ? '1' : '0';
  $flag_principal = isset($_POST["flag_principal"]) ? '1' : '0';
  $name_moneda = isset($_POST["name_moneda"]) ? $_POST["name_moneda"] : "";
  $cod_sunat = isset($_POST["cod_sunat"]) ? $_POST["cod_sunat"] : "";
  $signo = isset($_POST["signo"]) ? $_POST["signo"] : "";
  $abreviatura = isset($_POST["abreviatura"]) ? $_POST["abreviatura"] : "";
  $accion = isset($_POST["accion"]) ? $_POST["accion"] : "";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("monedas"));
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

    if (empty(trim($name_moneda))) {
      throw new Exception("Campo Obligatorio : Nombre de Moneda.");
    }

    if (empty(trim($cod_sunat))) {
      throw new Exception("Campo Obligatorio : Código Sunat.");
    }

    if (empty(trim($signo))) {
      throw new Exception("Campo Obligatorio : Signo.");
    }

    if (empty(trim($abreviatura))) {
      throw new Exception("Campo Obligatorio : Abreviatura.");
    }

    if ($estado=="0" && $flag_principal=="1") {
      throw new Exception("La moneda por defecto no puede quedar inactiva.");
    }

    require_once "core/models/ClassMoneda.php";
    $VD = "";
    switch ($accion) {
      case 'add':
        $VD = $OBJ_MONEDA->insert($id_moneda,$estado,$flag_principal,$name_moneda,$cod_sunat,$signo,$abreviatura);
        break;
      case 'edit':
        $VD = $OBJ_MONEDA->update($id_moneda,$estado,$flag_principal,$name_moneda,$cod_sunat,$signo,$abreviatura);
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
