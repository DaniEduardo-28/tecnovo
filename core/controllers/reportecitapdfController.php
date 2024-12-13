<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("vistareportecita"));
	if ($flag) {
		require("views/reportes/reportes/reportecitapdf.php");
	}else{
		require("views/error/error401.php");
	}

?>
