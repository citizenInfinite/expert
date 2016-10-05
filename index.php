<?php

require("Class/Class.read_file.php");

$file_data = new ReadFile($argv[1]);
$nik = $file_data->read_file();
$file_data->_SeparateInput($nik);

?>