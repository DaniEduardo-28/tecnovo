<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("tipogasto"));
	if ($flag) {
		require("views/configuration/tipogasto.php");
	}else{
		require("views/error/error401.php");
	}

 ?>