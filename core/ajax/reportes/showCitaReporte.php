<?php
  try {  
    

    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 10;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $estado = isset($_POST["estado"])	? $_POST["estado"]	: "all";
    $fecha_inicio = isset($_POST["fecha_inicio"])	? $_POST["fecha_inicio"]	: date("Y-m-d");
    $fecha_fin = isset($_POST["fecha_fin"])	? $_POST["fecha_fin"]	: date("Y-m-d");
    $val = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $tipobusqueda = isset($_POST["tipobusqueda"])	? $_POST["tipobusqueda"]	: "-1";
    $chkfechas = isset($_POST["chkfechas"])	? $_POST["chkfechas"]	: false;

    require_once "core/models/ClassReserva.php";
    $Resultado = $OBJ_RESERVA->showreporte("all",$fecha_inicio,$fecha_fin,$val,$tipobusqueda,$chkfechas);

    if ($Resultado["error"]=="NO") {

      $options="";
      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "num" => "$count",
          "id_cita" => $key['id_cita'],
          "fecha_cita" => $key['fecha_cita'],
          "estado" => $key['estado'],
          "name_servicio" => $key['name_servicio'],
          "nombre_trabajador" => $key['nombre_trabajador'],
          "name_maquinaria" => $key['name_maquinaria']
        );
        $count++;
      }
      $data["error"] = "NO";
      $data["message"] = "Success";
      $data["data"] = $retorno_array;
      echo json_encode($data);

    }else {
      throw new Exception($Resultado["message"]);
    }

  } catch (\Exception $e) {
    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
  }

 ?>