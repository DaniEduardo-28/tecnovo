<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("vistareportemedicamentos"));
	if ($flag) {
		require("views/reportes/vistareportemedicamentos.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
