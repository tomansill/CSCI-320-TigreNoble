<?php

	/////////////////////////////////////////////////////////////////////////////
	/////////////// CHECKING TO ENSURE THAT THE DB IS INSTALLED	/////////////////
	/////////////////////////////////////////////////////////////////////////////
	include('database/init.php');
	
	
	//check if the db exist
	if($database->check_if_database_exist($conn)==false)
	{
		//echo 'The database doesnt exist. We will make it.';
		
		//make the db
		if($database->makeDatabase($conn))
		{
			//echo 'Created is true';
			//switch connection to the main connection which is in library/config.php
			include('library/force.php');
			$conn = $connection;
			
		   //read the sql file and execute it to make the tables in the database
		  $database->readSQLfile("database/updateTiger.sql", $conn);
		  $database->readStoredProcedure("database/storedProcedure.sql", $conn);
		  
		  //echo 'Successfully!';
		}	
	}

?>