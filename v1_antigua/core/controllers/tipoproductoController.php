<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("tipoproducto"));
	if ($flag) {
		require("views/configuration/tipoproducto.php");
	}else{
		require("views/error/error401.php");
	}

 ?>