<?php
	require("ReadFile.class.php");
	require("Facts.class.php");

	$read = new ReadFile("file.txt");

	$read->_SeparateInput($read->read_file());
?>
