
<?php
ini_set('display_errors', 0);
error_reporting(0);

try {

    // obtiene los valores para realizar la paginación
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"]) : 10;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"]) >= 0 ? intval($_POST["offset"]) : 0;
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
    $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordenventa"));

    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_buscar'] == false) {
            throw new Exception("No tienes permisos para realizar búsquedas.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassOrdenVenta.php";
    
    // Obtiene el conteo total de registros
    $DataCantidad = $OBJ_ORDEN_VENTA->getCountDetalleParaOrden($tipo, $valor);

    if ($DataCantidad["error"] == "NO") {

        $cantidad = $DataCantidad["data"][0]["cantidad"];
        $Resultado = $OBJ_ORDEN_VENTA->showDetalleParaOrden($tipo, $valor, $offset, $limit);

        $count = 1 + $offset;
        $signo_moneda = "S/";  // Puedes establecer un valor predeterminado o fijo

        // Inicializa un array para almacenar los resultados
        $retorno_array = [];

        // Recorre los resultados y construye el array de retorno
        if (isset($Resultado["data"]) && !empty($Resultado["data"])) {
          foreach ($Resultado["data"] as $key) {
              // Procesar cada elemento
              $precio_unitario = 1; // Ajusta esta lógica según tu caso
              $options = '<a id="btnSeleccionar" class="btn btn-icon btn-outline-success btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-check"></i></a>';
              
              $retorno_array[] = [
                  "num" => "$count",
                  "descripcion" => $key['descripcion'],
                  "cod_producto" => $key['cod_producto'],
                  "precio_unitario" => $precio_unitario,
                  "precio_unitario_string" => $signo_moneda . " " . $precio_unitario,
                  "seleccionar" => "$options",
              ];
              $count++;
          }
      } else {
          $retorno_array = []; // Vacío si no hay datos
          $cantidad = 0; // Cantidad cero si no se encontraron datos
      }
      
      $data = [
          "error" => "NO",
          "message" => "Success",
          "cantidad" => $cantidad,
          "data" => $retorno_array,
      ];
      echo json_encode($data);
      

    } else {
        throw new Exception($DataCantidad["message"]);
    }

} catch (Exception $e) {
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
}

?>
