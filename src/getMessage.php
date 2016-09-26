<?php

	include('auth.php');
	include('library/force.php');
	
	$user = $_SESSION['username'];
	
	$id = $_GET['key'];
	
	//$id =11;
	$sql = 'CALL getMessage(:message_id,:dce)';
	$stmt = $connection->prepare($sql);
	$stmt->bindParam(':dce',$user);
	$stmt->bindParam(':message_id',$id);
	$stmt->execute();
	
	$result = $stmt->fetch();
	$stmt->closeCursor();
	
	echo json_encode($result);
	

?>