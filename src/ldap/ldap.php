<?php
	//ensure that this is actived by the user pressing post
	if( isset($_POST['loginSubmit']) )
	{
		/*--------------------------------------------
			INCLUDING THE NECESSARY DEPENDENCIES
		----------------------------------------------*/
		include('ldap_functions.php');
		include('header.php');
		$path = dirname(dirname(__FILE__))."/library/force.php";
		include($path);
		
		//some spaces
		echo'<br/><br/><br/><br/><br/><br/><br/><div class="container"><div class="row">';
		
		/*------------------------------------------------
		   IN CASE THERE IS AN ISSUE WITH THE CONNECTION
		   NOT CONFIGURED PROPERLY....
		   
		   MIGHT CONSIDER MOVING THIS TO AUTH.PHP
		 -----------------------------------------------*/
		if($connection==false || !(isset($connection)))
		{
			echo '
					<div class="bs-example">
							<div class="alert alert-danger" style="text-align:center">
							
								<strong>The connection has not been set up correctly. <br/> Please contact the web master</strong>
							</div>
						</div><br/><br/><br/><br/>
			
			';
			
		}
		
		/*--------------------------------------------------
			SUBMIT THE USER LOGGED INFORMATION TO LDAP
			AND QUERY IT TO SEE IF EVERYTHING IS ALL OKAY
		--------------------------------------------------*/
		else
		{
			//GETTING THE USER INPUT VIA POST
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			/*----------------------------------------
				NECESSARY DEPENDENCIES FOR RIT LDAP
				SERVER AND THIS IS ALSO FORMMAATED
				ACCORD TO ITS WAY
			------------------------------------------*/
			$server    = "ldap.rit.edu";//LDAP SERVER
			$dns       = "ou=people,dc=rit,dc=edu";//dns
			$user      = "uid=$username, ";
			$filter    = "(uid=$username)";
			
			
			$ldapconn = ldapConnect($server);//ESTABLISH THE CONNECTION TO THE LDAP SERVER
			$isValid = is_valid_DCE($ldapconn,$user, $dns,$password);//CHECK WHETHER THE USER CREDIENTIAL IS VALID
			
			
			//STUDENT DCE INFORMATION IS INCORRECT
			if($isValid==false)
			{
				echo '
						<div class="bs-example">
							<div class="alert alert-danger" style="text-align:center">
							
								<strong>You have enter wrong username or password</strong>
							</div>
						</div><br/><br/><br/><br/>
				
				';
			}
			
			//STUDENT DCE IS CORRECT
			else
			{
				//NECESSARY PARAMETERS TO PASS TO THE SELECT FUNCTION
				$columns ='DCE,name';
				$bindings=array(':DCE'=>$username);
				$where="WHERE DCE = :DCE";
				$tables='student';
				$result = $library->select($connection,$columns,$bindings,$tables,$where);
				
				
				//the student information exist in the database
				if($result->rowCount()>0)
				{
					$data = $result->fetchAll();
					foreach($data as $row)
					{
						$username = $row['DCE'];
						$name = $row['name'];
					}
					
					//save the session
					session_start();
					$_SESSION['username'] = $username;
					$_SESSION['name'] = $name;
					
					
					
					//redirect to the member page
					header('Location: ../index.php');
				}
				
				//else this is a new student
				else
				{
					$info = fetch_student_info_ldap($ldapconn, $dns,$filter); //fetch the student information from the ldap server
					
					//print_r($info);
					/*---------------------------------------------
						REGISTER THE NEW STUDENT INFORMATION IN THE
						DATABASE FROM LDAP SERVER
					-----------------------------------------------*/

					
					//fill in the information retrived from the server
					$firstname = ucwords(strtolower($info['0']['givenname']['0']));
					$lastname = ucwords(strtolower($info['0']['sn']['0']));
					$name = $firstname. ' '.$lastname;
					$email = $info['0']['mail']['0'];
					$DCE = $DCE = $info['0']['uid']['0'];
					
					
					//unbinded the ldap since we wont need it anymore
					ldap_unbind($ldapconn);
					
					/*
						This is a new stduent so we will be using createStudent stored procedure and insert the student using
						prepare / binding statement
					*/
					$parameters =":student_dce,:student_name,:student_email";
					$sql = "CALL createStudent(".$parameters .")";
					$stmt = $connection->prepare($sql);
					$stmt->bindParam(':student_dce',$DCE,PDO::PARAM_STR);
					$stmt->bindParam(':student_name',$name,PDO::PARAM_STR);
					$stmt->bindParam(':student_email',$email,PDO::PARAM_STR);
					
					$result = $stmt->execute();
					$stmt->closeCursor();
					
					if($result==true)
					{
						//creating the session cookie
						session_start();
						$_SESSION['username'] = $username;
						$_SESSION['name'] = $name;
						
						//redirect to the member page
						header('Location: ../index.php');
					}
					
					
					
/* 					//passing the necessary parameters to the library->insert() function
					$columns='DCE,name,email';
					$values =':DCE,:name,:email';
					$bindings = array(':DCE'=>$DCE, ':name'=>$name,':email'=>$email);
					$table ='student';
					
					//insert the student in the database
					$result = $library->insert($connection,$columns,$bindings,$tables,$values);
					if($result==true)
					{
						//echo 'Insert successful';
						
						//creating the session cookie
						session_start();
						$_SESSION['username'] = $username;
						$_SESSION['name'] = $name;
						
						//redirect to the member page
						header('Location: student/index.php');
						
					} */
					
					else
					{
						echo 'Failed';
					}
									
				}
				
				
			}
		}
	}//end of submit by post
	echo'</div></div><br/><br/><br/><br/><br/><br/><br/>';
	include('../footer.php');
	

?>