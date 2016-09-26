<?php
	/*--------------------------------------
		THIS FILE IS CHECKS IF THE SESSION
		DOESNT EXIST AND REDIRECT THE USER
		TO THE LOGIN PAGE.
	*/
	

	session_start();
	//redirect the user to the index.php if he/she is already logged in
	if( isset($_SESSION['username']) && isset($_SESSION['name'] ) )
	{	
		$basename = basename($_SERVER["SCRIPT_FILENAME"], '.php');
		if($basename=='login')
		{
			header('Location:index.php');
		}
	}
	
	else
	{
		
		$basename = basename($_SERVER["SCRIPT_FILENAME"], '.php');
		if($basename!='login')
		{
			header('Location:login.php');
		}
	}
	

?>