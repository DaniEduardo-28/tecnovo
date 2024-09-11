<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("accesorio"));
	if ($flag) {
		require("views/mantenimiento/accesorio.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
