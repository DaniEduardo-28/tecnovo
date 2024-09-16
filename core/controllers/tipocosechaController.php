<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("tipocosecha"));
	if ($flag) {
		require("views/configuration/tipocosecha.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
