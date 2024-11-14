<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("trabajador"));
	if ($flag) {
		require("views/seguridad/trabajador.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
