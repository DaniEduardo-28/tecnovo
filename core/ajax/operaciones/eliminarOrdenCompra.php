<?php

  $id_orden_compra = isset($_POST["id_orden_compra"]) ? $_POST["id_orden_compra"] : "";

  try {

    // Verificar permisos
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordencompra"));
    if ($access_options[0]['error'] == "NO") {
      if ($access_options[0]['flag_eliminar'] == false) {
        throw new Exception("No tienes permiso para eliminar este registro.");
      }
    } else {
      throw new Exception("Error al validar los permisos.");
    }

    // Validar el ID de la orden de compra
    if (empty($id_orden_compra)) {
        throw new Exception("No se recibió el campo ID de la orden de compra.");
    }

    // Incluir el modelo
    require_once "core/models/ClassOrdenCompra.php";

    // Llamar a la función eliminarOrden del modelo
    $VD = $OBJ_ORDEN_COMPRA->eliminarOrden($id_orden_compra);

    if ($VD != "OK") {
      throw new Exception($VD);
    }

    // Respuesta exitosa
    $data["error"] = "NO";
    $data["message"] = "Orden eliminada permanentemente.";
    $data["data"] = null;
    echo json_encode($data);

  } catch (\Exception $e) {

    // Manejar errores
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

?>
