<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("grupousuario"));
	if ($flag) {
		require("views/seguridad/grupousuario.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
