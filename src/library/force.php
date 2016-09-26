<?php
	/*
		This function force load all necessary files regardless of its path
	*/
	
	
	
	//this program force all necessary files to be include
	function path($filename)
	{
		return dirname(dirname(__FILE__)).$filename;
	}
	
	$configFile = path('/library/config.php');
	$libraryFile = path('/library/library.php');
	$libraryClass = path('/library/libraryClass.php');
	
	include_once($configFile);
	include_once($libraryFile);
	include_once($libraryClass);
	

?>