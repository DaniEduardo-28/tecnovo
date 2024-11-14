<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("websocio"));
	if ($flag) {
		require("views/paginaweb/websocio.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
