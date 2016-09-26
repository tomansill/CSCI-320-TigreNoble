<?php
	include('auth.php');
	include('library/force.php');
	
	if(isset($_POST))
	{
		$sender = $_SESSION['username'];
		$to = $_POST['to'];
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		
		$parameter =':sender,:receipent,:subject_msg,:message_content';
		$sql = 'CALL sendMessage('.$parameter.')';
		$stmt = $connection->prepare($sql);
		
		$stmt->bindParam(':sender',$sender);
		$stmt->bindParam(':receipent',$to);
		$stmt->bindParam(':subject_msg',$subject);
		$stmt->bindParam(':message_content',$message);
		
		$stmt->execute();
		$stmt->closeCursor();
		
		
	}

?>