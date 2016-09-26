<?php
	require_once('auth.php');
	include('library/force.php');
	
	//ensure that the submit bid was clicked
	if(isset($_POST['submitBid']))
	{
		if(isset($_POST['post']))
		{
			$post = $_POST['post'];
		}
		
		if(isset($_POST['action']))
		{
			$action = $_POST['action'];
		}
		
		if(isset($_POST['buyer']))
		{
			$buyer = $_POST['buyer'];
		}
		//both are not empty
		if(!empty($action) && !empty($post))
		{
			//accept bid
			if($action=='approve')
			{
				$parameter = ':id,:customer';
				$sql = 'CALL acceptMoneyBid('.$parameter.')';	
				$stmt = $connection->prepare($sql);
				$stmt->bindParam(':id',$post);
				$stmt->bindParam(':customer',$buyer);
				
				$stat = $stmt->execute();
				$stmt->closeCursor();
				
				if($stat == true)
				{
					//echo 'True';
					header('location:bidApprovePending.php');
				}
				
				else
				{
					//echo 'failed';
					header('location:bidApprovePending.php');
				}
				
			}
			
			//reject bid 
			if($action=='reject')
			{
				$parameter = ':id,:customer';
				$sql = 'CALL rejectMoneyBid('.$parameter.')';	
				$stmt = $connection->prepare($sql);
				$stmt->bindParam(':id',$post);
				$stmt->bindParam(':customer',$buyer);
				
				$stat = $stmt->execute();
				$stmt->closeCursor();
				
				if($stat == true)
				{
					//echo 'True';
					header('location:bidApprovePending.php');
				}
				
				else
				{
					//echo 'failed';
					header('location:bidApprovePending.php');
				}
				
			}
		}
		
		else
		{
			//echo " Is empty";
			header('location:bidApprovePending.php');
		}
	}
	
	//isset is empty 
	else{
		//echo " You need to go back";
		header('location:bidApprovePending.php');
	}
?>