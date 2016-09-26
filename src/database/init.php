<?php
	
	include "databaseClass.php";
	include "databaseConfig.php";

	//echo "The name of the config is ".var_dump($database_config);
	$database = new Database($database_config);
	$database->_construct($database_config);
	$conn = $database->establishConnection();


?>