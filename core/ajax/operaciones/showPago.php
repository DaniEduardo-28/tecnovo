<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

try {

    $id_ingreso = isset($_POST["id_ingreso_pago"]) ? $_POST["id_ingreso_pago"] : null;

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("operador"));
    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_buscar'] == false) {
            throw new Exception("No tienes permisos para realizar busquedas.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.", 1);
    }

    require_once 'core/models/ClassIngreso.php'; 
    $Resultado = $OBJ_INGRESO->getPagos($id_ingreso);

    if ($Resultado["error"]=="NO") {

        $flag_eliminar = '<a href="javascript:deleteRegistro(' . $key['id_pago'] . ",'" . str_replace('"',' ',str_replace("'",' ',$key['name_forma_pago'])) . "'" . ')" class="btn btn-icon btn-outline-danger btn-round"><i class="ti ti-close"></i></a>';
  
        $count = 1;
        foreach ($Resultado["data"] as $key) {
          $retorno_array[] =array(
            "num" => "$count",
            "id_pago" => $key['id_pago'],
            "fecha_pago" => $key['fecha_pago'],
            "name_forma_pago" => $key['name_forma_pago'],
            "monto_pagado" => $key['monto_pagado'],
            "src_factura" => $key['src_factura'],
            "flag_eliminar" => "$flag_eliminar"
          );
          $count++;
        }
        $data["error"] = "NO";
        $data["message"] = "Success";
        $data["data"] = $retorno_array;
        echo json_encode($data);
        exit();
  
      }else {
  
        $data["error"] = "SI";
        $data["message"] = $Resultado["message"];
        $data["data"] = null;
        echo json_encode($data);
        exit();
  
      }
  
    } catch (\Exception $e) {
      $data["error"]="SI";
      $data["message"]=$e->getMessage();
      $data["data"] = null;
      echo json_encode($data);
      exit();

}
