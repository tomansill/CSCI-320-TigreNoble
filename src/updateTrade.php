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
			//echo 'hello';
			//echo '<br/>'.$action;
			//accept bid
			if($action=='approve')
			{
				$parameter = ':id,:customer';
				$sql = 'CALL acceptTradeBid('.$parameter.')';	
				$stmt = $connection->prepare($sql);
				$stmt->bindParam(':id',$post);
				$stmt->bindParam(':customer',$buyer);
				
				$stat = $stmt->execute();
				$stmt->closeCursor();
				
				if($stat == true)
				{
					echo 'True';
					header('location:tradeApprovePending.php');
				}
				
				else
				{
					echo 'failed';
				}
				
			}
			
			//reject bid 
			if($action=='reject')
			{
				$parameter = ':id,:customer';
				$sql = 'CALL rejectTradeBid('.$parameter.')';	
				$stmt = $connection->prepare($sql);
				$stmt->bindParam(':id',$post);
				$stmt->bindParam(':customer',$buyer);
				
				$stat = $stmt->execute();
				$stmt->closeCursor();
				
				if($stat == true)
				{
					echo 'True';
					header('location:tradeApprovePending.php');
				}
				
				else
				{
					echo 'failed';
				}
				
			}
		}
		
		else
		{
			echo " Is empty";
			header('location:tradeApprovePending.php');
		}
	}
	
	//isset is empty 
	else{
		echo " You need to go back";
	}
?>