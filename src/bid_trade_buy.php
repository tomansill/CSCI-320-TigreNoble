<?php
	require_once('auth.php');
	include('library/force.php');
	include('header.php');
	
	//the user who is logged in
	$user = $_SESSION['username'];
	$num=false;
	

	 
	 /*****************************************************************
	  *
	  *	THE USER CLICKS ON BID, TRADE or BUY FROM index
	  *
	  ****************************************************************/
	
	//getting the posts
	if(isset($_POST['fromIndex']))
	{
		$posting_id = $_POST['posting_id'];
		$type =  $_POST['transcatType'];
		
		
		//getting the highest bid if the type is bid
		if($type=='bid|buy')
		{
			$num = true;
			$sql = 'CALL getHighestBid(:posting_id)';
			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':posting_id',$posting_id,PDO::PARAM_INT);
			
			$status = $stmt->execute();
			$stmt->closeCursor();
			
			//was the execute success? 
			if($status == true)
			{
				$result = $stmt->fetch();
				
				//change to 0 if the result is null
				if($result["MAX(bid_amount)"] ==NULL)
				{
					//perform some calculation so that the user can do 25% off 
					$sql = 'CALL getPost(:post_id)';
					$stmt1 = $connection->prepare($sql);
					$stmt1->bindParam(':post_id',$posting_id);
					$stmt1->execute();
					$result = $stmt1->fetch();
					
					//calculation
					$money = $result['book_price'] * .75;
				}
				
			}
		}// end if type is bid
		
	}
	
	
	
	
?>

<!--FOR POP UP MODULE TO APPEAR-->
<section id="bidPop">
	<div class="container" >	
		<form class="form" method="post" action="bid_trade_buy_exe.php">
			<div class="col-sm-4 col-lg-4 col-md-4" style="background:white">
				<h4>Post <?php echo $type; ?></h4>
				<input type="hidden" name="post_id" />
				<?php
					if($num==true)
					  {
						echo '<input type="number" name="offer" value="'.$money.'" step="0.01" required="required"/>';
					  }
					  
					  else
					  {
						echo '<input type="text" name="offer"  required="required"/>';
					  }
				?>
				
				<input type="submit" name ="tranBid" class="btn btn-primary" value="Post"/>
				<input type="button" class="btn btn-primary b-close" value="Dismiss"/>
				<input type="hidden" name ="posting_id" class="btn btn-primary b-close" value="<?=$posting_id;?>"/>
				<input type="hidden" name ="tranType" class="btn btn-primary b-close" value="<?=$type;?>"/>
			</div>
		</form>	
	</div>
</section>
<!--end-->

<?php
	include('footer.php');
?>