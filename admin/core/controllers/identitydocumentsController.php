<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("identitydocuments"));
	if ($flag) {
		require("views/configuration/identitydocuments.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
