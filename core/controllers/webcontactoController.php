<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("webcontacto"));
	if ($flag) {
		require("views/paginaweb/webcontacto.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
