<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("categoriaaccesorio"));
	if ($flag) {
		require("views/configuration/categoriaaccesorio.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
