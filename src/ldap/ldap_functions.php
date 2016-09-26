<?php


	/*THIS FUNCTION CHECKS THE STATUS OF THE LDAP SERVER...
	  IF THERE IS AN ISSUE A FALSE WILL RETURN OTHERWISE TRUE
	*/
	function ldapConnect($server)
	{
		//return false for an empty server name
		if(empty($server))
		{
			return false;
		}
		
		//return the server resource id
		else
		{
			return ldap_connect($server);
		}
		
	}
	
	
	/* THIS FUNCTION TAKES THE STUDENT DCE, RETURN  false if the account is invalid.
	   IF THERE IS AN ISSUE WITH THE SERVER ITSELF THEN AN ERROR MESSAGE WILL PRINT.
	   IF THE STUDENT INFORMATION IS CORRECT THEN THE LDAP CONNECTION IS RETURN
	*/
	function is_valid_DCE($connect,$user, $dns,$password)
	{	
		//CONNECTION TO THE SERVER WAS SUCCESS 
		if (!($bind = @ldap_bind($connect, $user . $dns, $password)) || empty($password))
		{		
			return false;				
		}
		
		//return the ldap connection as the student supply an correct DCE account
		else
		{
			return true;
		}
	}
	
	/* THIS FUNCTION FETCHS THE STUDENTS INFORMATION AND RETURNS IT IN THE FORM OF AN ARRAY
       IN JSON*/

	function fetch_student_info_ldap($connect, $dns,$filter)
	{
		//return false if the connection originally fail;
		if($connect == false)
		{
			return false;
		}
		
		else
		{
			$sr = ldap_search($connect, $dns,$filter);
			$info = ldap_get_entries($connect, $sr);
			//$info = json_encode($info);
			return $info;
		}
	}
	
?>