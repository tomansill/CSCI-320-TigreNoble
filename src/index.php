<?php
	require_once('auth.php');
	require_once('dbAuth.php');
	include_once('library/force.php');
	include('header.php');
?>
 <!-- Portfolio Grid Section -->
    <section>
        <div class="container">
			<div class="row" style="display:flex; flex-wrap: wrap;" >
			
			<?php
				
				//query for random books
				$sql = 'CALL getRandomListOfPosts()';
				$stmt = $connection->prepare($sql);
				$stmt->execute();
				$result = $stmt->fetchAll();
				$stmt->closeCursor();
				
				foreach($result as $row)
				{
					if($row['book_price']==0)
					{
						$price = 'FREE';
					}
					
					else
					{
						$price = $row['book_price'];
					}
					echo '
							<div class="col-sm-6 col-md-4">
								<form  class="form" id="form" action="bid_trade_buy.php" method="post">
									<div class="thumbnail">
										<div class="caption">
											<img src="'.$row['imagePath'].'" style="width:250px; height:322px" style="text-align:center">
											<h6 title="Item">Title: '.$row['title'].' </h6>
											<h6 title="Item">Author: '.$row['author'].' </h6>
											<h6 title="Item">Edition: '.$row['edition'].'</h6>
											<h6 title="Item">Condition: '.$row['book_condition'].' </h6>
											<h6 title="Item">Price: '.$price.' </h6>
											<p> Additional info: '.$row['post_description'].'</p>
										</div>
										<div class="userOptions text-center" >
										<!-- Cart Button -->
										<input type="submit" name="fromIndex" class="btn btn-primary fa fa-shopping-cart" id="bid" offer="bid" value="bid|buy"/>
										<input type="submit" name="fromIndex" class="btn btn-primary fa fa-shopping-cart" id="trade" offer="trade" value="trade"/>
										<input type="hidden" name="posting_id"  value="'.$row['id'].'"/>
										<input type="hidden" name="transcatType" class="tranScationType"  value=""/>
									</div>
									</div>
								</form>
							</div>';
				
				}
			
			?>

		</div>
        </div>
    </section>
	


   <?php
	include("footer.php");
   ?>
   
 <script>
	
	//figure out which of the form button was clicked
	var which;

	$('input[type="submit"]').click(function(e){
	   which = $(this).val();
	});
	
	
	$(".form").submit(function (e) 
	{
		$('.tranScationType').val(which);
	});
 </script>
	
