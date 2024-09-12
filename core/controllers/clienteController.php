<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("cliente"));
	if ($flag) {
		require("views/mantenimiento/cliente.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
