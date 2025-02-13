<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("vistareportepagar"));
	if ($flag) {
		require("views/reportes/vistareportepagar.php");
	}else{
		require("views/error/error401.php");
	}

?>
