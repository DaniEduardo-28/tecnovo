<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("ordenventa"));
	if ($flag) {
		require("views/operaciones/reportes/reporteventasexcel.php");
	}else{
		require("views/error/error401.php");
	}

?>
