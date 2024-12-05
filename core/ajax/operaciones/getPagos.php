<?php
var_dump($_GET);
var_dump($_POST);
require_once "core/models/ClassIngreso.php";

try {
    $id_ingreso = isset($_POST["id_ingreso"]) ? $_POST["id_ingreso"] : null;

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ingreso"));
    if ($access_options[0]['error']=="NO") {
        if ($access_options[0]['flag_agregar']==false) {
          throw new Exception("No tienes permisos para registrar ingresos.");
        }
      }else {
        throw new Exception("Error al verificar los permisos.");
      }

    if (!$id_ingreso) {
        throw new Exception("No se recibió el ID del ingreso.");
    }

    $pagos = $OBJ_INGRESO->getPagosByIngreso($id_ingreso);
    var_dump($pagos);

    if ($pagos["error"] === "NO") {
        echo json_encode(["error" => "NO", "data" => $pagos["data"]]);
    } else {
        throw new Exception($pagos["message"]);
    }
} catch (Exception $e) {
    echo json_encode(["error" => "SI", "message" => $e->getMessage()]);
}
?>

