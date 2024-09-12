<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("historialclinico"));
	if ($flag) {
		require("views/citas/historialclinico.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
