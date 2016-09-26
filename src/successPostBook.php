<?php

	//prevent 
	require_once('auth.php');
	include('library/force.php');
	include('header.php');
	
	$author = $_SESSION['author'];
	$title = $_SESSION['title'];
	$description = $_SESSION['description'];
	$img = $_SESSION['img'];
	$edition = $_SESSION['edition'];
	$condition = $_SESSION['condition'];
	

?>

<section>
	<div style="text-align:center">
		<div class="alert alert-success " role="alert" style="width:50%; text-align:center">
		<strong>Successful Post </strong>
		</div>
	</div>
	<form  class="form" id="form" action="bid_trade_buy.php" method="post">
		<div class="col-sm-4 col-lg-4 col-md-4">
			<div class="thumbnail">
			   <img src="<?php echo $img;?>"/>
				 <div class="caption" style="text-align:left">
					<h6 title="Item">Author:<?php echo $author;?> </h6>
					<h6 title="Item">Edition: <?php echo $edition;?></h6>
					<h6 title="Item">Condition: <?php echo $condition;?> </h6>
					<h6 title="Item">Description: <?php echo $description;?> </h6>
				</div>
			</div>
		</div>
	</form>
</section>