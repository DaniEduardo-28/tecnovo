<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("ingreso"));
	if ($flag) {
		require("views/operaciones/ingreso.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
