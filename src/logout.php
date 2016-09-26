<?php
	//destroy all sections
	session_start();
	session_destroy();
	
	header('location:index.php');

?>