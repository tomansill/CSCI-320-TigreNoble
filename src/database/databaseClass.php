<?php


	Class Database
	{
		private $dbname;
		private $dbusername;
		private $dbpassword;
		private $host;
		private $errorMessage;

		//constructor 
		public function _construct($config)
		{
			$this->dbname = $config['dbname'];
			$this->dbusername = $config['dbusername'];
			$this->dbpassword = $config['dbpassword'];
			$this->host = $config['host'];

		}


		//remote connect... return true if passed else failed
		public function establishConnection()
		{
			try{
					$databaseConnectString = 'mysql:host='.$this->host;
					$conn = new PDO($databaseConnectString,$this->dbusername,$this->dbpassword);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					return $conn;//database successful connected
			   }

			catch(PDOException $e)
			{
				return false;
			}
			   

		}

		public function check_if_database_exist($connection)
		{
			$conn = $connection;
			if($conn!=false)
			{
				$stmt = $conn->prepare("SHOW DATABASES LIKE '$this->dbname' " );
		 		$stmt->execute();

		 		if($stmt->rowCount() > 0 )
		 		{
		 			//echo "Asian this was successful done! GET YOUR HEAD IN THIS ";
		 			return true;
		 	
		 		}
		 		return false;
		 	}
		 	return false;

		}

		//connect to server if it doesnt exist
		 public function makeDatabase($connection)
		 {
		 	$conn = $connection;

		 	if($conn!=false)
		 	{ 
		 		$status = $this->check_if_database_exist($conn);
		 		if($status==false)
		 		{
		 			//echo "duplicating?";
		 			$conn->query("CREATE DATABASE IF NOT EXISTS $this->dbname");
		 			$conn->query("use $this->dbname");
					
					return true;
		 		}

		 	}//end of if connection is not false
			

			return false;

		 }

		public function readSQLfile($filename, $conn)
		{
			//algorithm 1. check if is actually a file, 2 check if conn not false, read file content
			
			//read file content
			
			$sql = file_get_contents($filename);
			//$prepare = $conn->prepare($sql);
			
			$conn->exec($sql);
		}
		
		public function readStoredProcedure($filename,$conn)
		{
			
			//$storedProcedure = file_get_contents($filename);
			$handle = @fopen($filename, "r");
			$storedProcedure ="";
			if ($handle) {
				while (!feof($handle)) {
					$buffer = fgetss($handle, 4096);
				
					//does the buffer has the string END#? 
					$status = strstr($buffer, 'END#');
					if($status==true)
					{
						$buffer = substr($buffer,0,strlen($buffer)-1);
						$storedProcedure.= $buffer;
						$conn->query($storedProcedure);
						$storedProcedure ="";
						
					}
					
					else
					{
						$storedProcedure.= $buffer;
					}
				}
				fclose($handle);
			}
			//$conn->query($storedProcedure);
		}
	}
?>