<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("citas"));
	if ($flag) {
		require("views/citas/citas.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
