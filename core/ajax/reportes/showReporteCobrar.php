<?php
  try {  
    $fecha_inicio = isset($_POST["fecha_inicio"]) ? $_POST["fecha_inicio"] : date("Y-m-d");
    $fecha_fin = isset($_POST["fecha_fin"]) ? $_POST["fecha_fin"] : date("Y-m-d");
    $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";
    $tipobusqueda = isset($_POST["tipobusqueda"]) ? $_POST["tipobusqueda"] : "-1";

    require_once "core/models/ClassGastoServicio.php";
    $Resultado = $OBJ_GASTO_SERVICIO->showReporteCobrar($valor, $fecha_inicio, $fecha_fin, $tipobusqueda);

    if ($Resultado["error"] == "NO") {
      $retorno_array = [];
      $count = 1;

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] = array(
          "num" => "$count",
          "id" => $key['id'],
          "codigo" => $key['codigo'],
          "fecha" => $key['fecha'],
          "nombre_cliente" => $key['nombre_cliente'],
          "total" => number_format($key['total'], 2),
          "pagado" => number_format($key['pagado'], 2),
          "pendiente" => number_format($key['pendiente'], 2)
        );
        $count++;
      }

      $data["error"] = "NO";
      $data["message"] = "Success";
      $data["data"] = $retorno_array;
      echo json_encode($data);

    } else {
      throw new Exception($Resultado["message"]);
    }

  } catch (Exception $e) {
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
  }
?>
