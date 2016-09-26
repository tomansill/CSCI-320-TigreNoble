<?php

	require_once('auth.php');
	include('library/force.php');
	include('header.php');
	
	//correct output_add_rewrite_var
	$status =  $_SESSION['status'];
	$type =  $_SESSION['type'];
	$msg="";
	$stat ="";
	if($status == "passed")
	{
		$stat ='alert-success';
		$msg = 'You have successful post your '.$type.' offer';
	}
	
	else
	{
		$stat = 'alert-danger';
		$msg = 'There was an error with your '.$type.' offer <br> go back and try again.';
	}
		
?>
<br/>
<br/>
<section>
	<div style="text-align:center">
		<div class="alert <?php echo $stat;?> " role="alert" style="width:50%; text-align:center">
		<strong><?php echo $msg;?></strong>
		</div>
	</div>

</section>

<?php include('footer.php');?>
