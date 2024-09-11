<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("sucursales"));
	if ($flag) {
		require("views/configuration/sucursales.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
