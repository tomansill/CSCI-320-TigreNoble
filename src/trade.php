<?php
	require_once('auth.php');
	include('library/force.php');
	include('header.php');
	

?>

<section>
	<h4 style="text-align:center">Trade History</h4>
	<div class="panel panel-default">

	  <!-- Table -->
	  <table class="table">
		<tr>
			<th>Item<th>
			<th>Offer Message</th>
			<th>Finalized ? </th>
		</tr>
		<?php
			//getting a list of bids that the user made
			$user = $_SESSION['username'];
			//$user="tly787";
			$sql = 'CALL getListOfBidsTrade(:buyer)';
			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':buyer',$user);
			$stmt->execute();
			$fetch = $stmt->fetchAll();
			$stmt->closeCursor();
			
			$color = 'brown';
			
			foreach($fetch as $row )
			{
				//get the book id from post
				$sql = 'CALL getPost(:post_id)';
				$stmt = $connection->prepare($sql);
				$stmt->bindParam(':post_id',$row['posting_id']);
				$stmt->execute();
				$bookId = $stmt->fetch();
				$stmt->closeCursor();
				
				$bookName = $bookId['title'];
				$amount = $row['offer_message'];
				
				if($row['trade_accept']=='P')
				{
					$final = 'Negotiating';
				}
				
				else if($row['trade_accept']=='A')
				{
					$final = 'Offer accepted... Please contact buyer to meet up';
				}
				
				else
				{
					$final = 'If the book is still for sell you may submit a new offer';
				}
				
				echo "<tr style='background:".$color.";color:white'>
							<td>$bookName</td>
							<td></td>
							<td>$amount</td>
							<td>$final</td>
				      </tr>";
					  
					   //switch color
					  if($color=='#f36e21')
					  {
						$color = 'brown';
					  }
					  
					  else
					  {
						$color='#f36e21';
					  }
			}
		
		?>
	  </table>
	</div>
	
</section>
<br/>
<br/>

<?php
	include('footer.php');
?>