<?php
	require_once __DIR__.'/includes/Config.php';

	unset($_SESSION["login"]);
	unset($_SESSION["profesor"]);
	unset($_SESSION["administrador"]);
	unset($_SESSION['id']);
	unset($_SESSION['nombre']);

	session_destroy();
	require_once __DIR__.'/Index.php';
?>