<?php
	
	require_once('auth.php');
	include('library/force.php');
	/*--------------------------------------------------------------
	 *
	 *	The user post either bid, trade or buy at bid_trade_buy.php
	 *
	 *------------------------------------------------------------*/
	 if(isset($_POST['tranBid']))
	 {
		$user = $_SESSION['username'];
		//sp order post_id, customer_id, amount
		
		//figure the type that was posted
		$type = $_POST['tranType'];
		$money = $_POST['offer'];
		$id = $_POST['posting_id'];
		$_SESSION['status'] ="";
		$_SESSION['type'] = $type;
		
		
		//find the seller for this specific book
		 $query = 'SELECT seller_dce from post where id = :id';
		 $bind = array(':id'=>$id);
		 $sql = $library->advanceQuery($query, $bind,$connection);
		 $final = false;
		 
		 $seller = $sql->fetch();
		 
		 print_r($seller);
		
		//posting to the correct tables
		
		//bid type
		if($type=='bid|buy')
		{
			//prepare to insert in the make_bid_money if this is a bid type
			$parameter = ':post_id,:customer_id,:amount';
			$sql = 'CALL makeMoneyBid('.$parameter.')';
			$stmt = $connection->prepare($sql);
			
			$stmt->bindParam(':post_id',$id);
			$stmt->bindParam(':customer_id',$user);
			$stmt->bindParam(':amount',$money);
			
			$status = $stmt->execute();
			$stmt->closeCursor();
			
			//redirect the user if this was successful

			if($status == true)
			{
				$_SESSION['status'] = "passed";
				
				header('location: successOffer.php');
				
			}
			
			else
			{
				$_SESSION['status'] = "failed";
				header('location: successOffer.php');
			}
			
			header('location: successOffer.php');
		}
		
		//trade type
		if($type=='trade')
		{
			$parameter =':posting_id,:student_id,:offer_message';
			$sql = 'CALL makeTradeBid('.$parameter.')';
			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':posting_id',$id);
			$stmt->bindParam(':student_id',$user);
			$stmt->bindParam(':offer_message',$money);
			$res = $stmt->execute();
			$stmt->closeCursor();
			
			if($res == true)
			{
				$_SESSION['status'] = "passed";
				header('location: successOffer.php');
				
				
			}
			
			else
			{
				$_SESSION['status'] = "failed";
				header('location: successOffer.php');
			}
			header('location: successOffer.php');
		}
		
		
		header('location: successOffer.php');
	 }

?>