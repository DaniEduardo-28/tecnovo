
<?php
ini_set('display_errors', 0);
error_reporting(0);

try {
    // Obtener los valores para la paginación y otros parámetros
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"]) : 10;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"]) >= 0 ? intval($_POST["offset"]) : 0;
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
    $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";

    // Verificar permisos
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordenventa"));

    if ($access_options[0]['error'] == "NO" && !$access_options[0]['flag_buscar']) {
        throw new Exception("No tienes permisos para realizar búsquedas.");
    } elseif ($access_options[0]['error'] != "NO") {
        throw new Exception("Error al verificar los permisos.");
    }

    // Incluir el modelo requerido
    require_once "core/models/ClassOrdenVenta.php";

    // Obtener la cantidad total de registros
    $DataCantidad = $OBJ_ORDEN_VENTA->getCountDetalleParaOrden($tipo, $valor);

    if ($DataCantidad["error"] == "NO") {
        $cantidad = $DataCantidad["data"][0]["cantidad"];
        $Resultado = $OBJ_ORDEN_VENTA->showDetalleParaOrden($tipo, $valor, $offset, $limit);

        // Array para almacenar los datos de retorno
        $retorno_array = [];
        $count = 1 + $offset;
        $signo_moneda = "S/"; // Establecer el símbolo de moneda

        // Llenar el array con los resultados obtenidos
        if (isset($Resultado["data"]) && !empty($Resultado["data"])) {
            foreach ($Resultado["data"] as $key) {
                $options = '<a id="btnSeleccionar" class="btn btn-icon btn-outline-success btn-round mr-0 mb-1 mb-sm-0"><i class="ti ti-check"></i></a>';
                
                $retorno_array[] = [
                    "num" => "$count",
                    "descripcion" => $key['descripcion'],
                    "cod_producto" => $key['cod_producto'],
                    "seleccionar" => $options
                ];
                $count++;
            }
        }

        // Preparar los datos de respuesta
        $data = [
            "error" => "NO",
            "message" => "Success",
            "cantidad" => $cantidad,
            "data" => $retorno_array,
        ];
    } else {
        throw new Exception($DataCantidad["message"]);
    }

    echo json_encode($data);

} catch (Exception $e) {
    $data = [
        "error" => "SI",
        "message" => $e->getMessage(),
        "data" => null
    ];
    echo json_encode($data);
    exit();
}
?>
