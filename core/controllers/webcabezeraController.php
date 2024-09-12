<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("webcabezera"));
	if ($flag) {
		require("views/paginaweb/webcabezera.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
