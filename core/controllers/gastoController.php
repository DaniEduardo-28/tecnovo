<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("gasto"));
	if ($flag) {
		require("views/mantenimiento/gasto.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
