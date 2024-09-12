<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("vistareporteordenventa"));
	if ($flag) {
		require("views/reportes/vistareporteordenventa.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
