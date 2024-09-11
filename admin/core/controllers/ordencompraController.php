<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("ordencompra"));
	if ($flag) {
		require("views/operaciones/ordencompra.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
