<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("tipocambio"));
	if ($flag) {
		require("views/configuration/tipocambio.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
