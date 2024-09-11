<?php

	require('core/core.php');

	require_once "admin/core/models/ClassOverall.php";
	$result = $OBJ_OVERALL->getOverall(1,50);
	if ($result['error']=="SI") {
		header('location: ?view=error');
	}
	$dataResult = $result['data'];

	if (isset($_GET["view"])) {
		if (file_exists('core/controllers/' . strtolower($_GET['view']) . 'Controller.php')) {
			include('core/controllers/' . strtolower($_GET['view']) . 'Controller.php');
		}else{
			include("core/controllers/errorController.php");
		}
	}else{
		include("core/controllers/indexController.php");
	}

 ?>
