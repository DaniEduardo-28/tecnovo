<?php

	require("core/models/ClassAccesoOpcion.php");
	$flag = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("gastoservicio"));
	if ($flag) {
		require("views/operaciones/gastoservicio.php");
	}else{
		require("views/error/error401.php");
	}

 ?>
