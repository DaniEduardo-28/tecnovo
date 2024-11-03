<?php

// Cargar el archivo de modelo de permisos
require("core/models/ClassAccesoOpcion.php");

// Verificar permisos de acceso al módulo de Orden de Gasto
$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("ordengasto"));

// Redirigir a la vista correspondiente según los permisos
if ($flag) {
    // Si el usuario tiene permisos, carga la vista de Orden de Gasto
    require("views/operaciones/ordengasto.php");
} else {
    // Si no tiene permisos, muestra una página de error
    require("views/error/error401.php");
}

?>
