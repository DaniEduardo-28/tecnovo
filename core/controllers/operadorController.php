<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("operador"));
	if ($flag) {
		require("views/mantenimiento/operador.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
