<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("accesofundo"));
	if ($flag) {
		require("views/mantenimiento/accesosfundo.php");
	}else{
		require("views/error/error401.php");
	}

 ?>