<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("formapago"));
	if ($flag) {
		require("views/configuration/formapago.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
