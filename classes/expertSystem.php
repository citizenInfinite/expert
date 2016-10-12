<?php
	require("ReadFile.class.php");
	require("Facts.class.php");

	$engine = new Engine("file.txt");
	$engine->runEngine();
?>
