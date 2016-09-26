<style>
	.dataResult:hover
	{
		background:black !important;
		color:white;
		
	}
	
	.dataResult
	{
		text-align:center;
		background:white;
		width:50%;
		border-radius:5px;
		border-bottom: 1px solid;
	}
</style>

<?php
	include('library/force.php');
	
	//keyword from the POST
	$search = $_POST['search'];
	
	$string='%'.$search.'%';
	//set up query
	$query = 'SELECT name,email from student where name like :query or email like :query order by name LIMIT 5';
	$binding = array(":query"=>$string);
	
	$stmt = $library->advanceQuery($query, $binding,$connection);
	
	$result = $stmt->fetchAll();
	
	foreach($result as $row)
	{
		$name = $row['name'];
		$email = $row['email'];
		
		$b_username='<strong>'.$query.'</strong>';
		$b_email='<strong>'.$query.'</strong>';
		
		$final_username = str_ireplace($query, $b_username, $name);
		$final_email = str_ireplace($query, $b_email, $email);
		
	echo'
			<div class="dataResult">
				<span class="name">'.$final_username.'</span>&nbsp;<br/><span class="email">'.$final_email.'</span>
			</div>
		';
	}

?>