<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("vistareportecliente"));
	if ($flag) {
		require("views/reportes/reportes/reporteclienteexcel.php");
	}else{
		require("views/error/error401.php");
	}

?>