<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("unidadmedida"));
	if ($flag) {
		require("views/configuration/unidadmedida.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
