<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("vistareporteproveedor"));
	if ($flag) {
		require("views/reportes/vistareporteproveedor.php");
	}else{
		require("views/error/error401.php");
	}

?>