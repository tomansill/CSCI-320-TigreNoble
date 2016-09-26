<?php
	require_once('auth.php');
	include('library/force.php');
	include('header.php');
	

?>

<section>
	<h4 style="text-align:center">Bid(s) pending approval by you </h4>
	<div class="panel panel-default">

	  <!-- Table -->
	  <table class="table">
		<tr>
			<th>Item<th>
			<th>Amount</th>
			<th></th>
			<th></th>
		</tr>
		
		<?php
			$user = $_SESSION['username'];
			$sql = 'CALL getListOfBidsMoneySellerWithMoreInfo(:dce)';
			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':dce',$user);
			$stmt->execute();
			$count = $stmt->rowCount();
			$result = $stmt->fetchAll();
		
			//print_r($result);
			$stmt->closeCursor();
			
			
			foreach($result as $row)
			{
				//organizing the data
				$title = $row['title'];
				$amount = $row['bid_amount'];
				$buyer = $row['student_dce'];
				$posting_id = $row['posting_id'];
				
				echo '
						<tr>
							<td>'.$title.'</td>
							<td></td>
							<td>'.$amount.'</td>
							<td>
								<div class="dropdown">
								  <button class="btn alert-danger  dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
									Action
									<span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
									<li role="presentation"><a style="color:white" class="alert-success approve"  post="'.$posting_id.'" buyer="'.$buyer.'" style role="menuitem" tabindex="-1" href="#">Approve</a></li>
									<li role="presentation"><a style="color:white" class="alert-danger reject"   post="'.$posting_id.'" buyer="'.$buyer.'" role="menuitem" tabindex="-1" href="#">Reject</a></li>
								  </ul>
								</div>
							</td>
						</tr>';
				
			}
			
			
		
		?>
		<!--php code was here -->
	  </table>
	  <?php
		if($count==0)
		{
			echo '<br/><div style="text-align:center" class="alert alert-info" role="alert"><strong>No items pending action(s)</strong></div><br/>';
		}
	  ?>
	</div>
	<!--hidden form use for submission-->
	<div style="display:none">
		<form method="post" class="tranForm" action="updateBid.php" >
			<input type="text" class="post"  name="post"/>
			<input type="text" class="buyer" name="buyer"/>
			<input type="text" class="action" name="action"/>
			<input class="submitBid" type="submit" name="submitBid" value="submit"/>
		
		</form>
	</div>
	
</section>
<br/>
<br/>

<?php
	include('footer.php');
?>

<script>

	//accepting an offer
	$('.approve').click(function()
	{
		var post = $(this).attr('post');
		var buyer = $(this).attr('buyer');
		
		$('.post').val(post);
		$('.action').val('approve');
		$('.buyer').val(buyer);
		
		$('.submitBid').click();
	});
	
		//accepting an offer
	$('.reject').click(function()
	{
		var post = $(this).attr('post');
		var buyer = $(this).attr('buyer');
		
		$('.post').val(post);
		$('.action').val('reject');
		$('.buyer').val(buyer);
		
		$('.submitBid').click();
	});
</script>