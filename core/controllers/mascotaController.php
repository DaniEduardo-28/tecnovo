<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("mascota"));
	if ($flag) {
		require("views/mantenimiento/mascota.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
