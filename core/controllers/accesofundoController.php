<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("accesofundo"));
	if ($flag) {
		require("views/seguridad/accesofundo.php");
	}else{
		require("views/error/error401.php");
	}

 ?>