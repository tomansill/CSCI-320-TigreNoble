<?php
	include('../auth.php');
	$path = dirname(dirname(__FILE__))."/library/force.php";
	include($path);
	
	//If there was any errors with input, this variable will be used to inform the user
$error = array( 	
	"isbn" => null,
	"condition" => null,
	"quantity" => null,
	"price" => null,
	"description" =>null,
	"edition"=>null
);
$fail = array(
	"general" => false,
	"isbn" => false,
	"condition" => false,
	"quantity" => false,
	"price" => false,
	"description"=>false,
	"edition"=>false
);
if($_POST != null)
{
	//the post have been submitted, handle the input and validate it 
	//and decide to navigate to other page or not
	
	//validate description
	if(!array_key_exists('description', $_POST))
	{
		$fail = true;	
		$error['description'] = 'No description of the book is provided';
	}
	else
	{
		$description = $_POST['description'];
	}
	
	//edition
	if(!array_key_exists('edition', $_POST))
	{
		$fail = true;	
		$error['edition'] = 'No edition supplied!!';
	}
	else
	{
		$edition = $_POST['edition'];
	}

	//Validate ISBN
	if(!array_key_exists('isbn', $_POST))
	{
		$fail = true;	
		$error['isbn'] = 'Very bad error going on in back-end';
	}
	$isbn = trim(str_replace('-', '', $_POST['isbn']));
	
	if(!$fail['isbn'] && strlen($isbn) != 10 && strlen($isbn) != 13)
	{
		$fail['general'] = true;
		$fail['isbn'] = true;
		$error['isbn'] = 'ISBN number is not properly formatted';
	}
	if(!$fail['isbn'] && !ctype_digit($isbn)){
		$fail['general'] = true;
		$fail['isbn'] = true;
		$error['isbn'] = 'ISBN number is not properly formatted';
	}

	//Check if ISBN refers to a valid book
	if(!$fail['isbn']){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $isbn;
		curl_setopt($ch, CURLOPT_URL,$url);
		$bookJSON = json_decode(curl_exec($ch), true);	
		curl_close($ch);
		if(!$fail['isbn'] && $bookJSON == null){
			$fail['general'] = true;
			$fail['isbn'] = true;
			$error['isbn'] = 'Something went wrong with our book look-up database';	
		}
		if(!$fail['isbn'] && !array_key_exists('totalItems', $bookJSON)){
			$fail['general'] = true;
			$fail['isbn'] = true;
			$error['isbn'] = 'Something went wrong with our book look-up database';	
		}
		if(!$fail['isbn'] && $bookJSON['totalItems'] == 0){
			$fail['general'] = true;
			$fail['isbn'] = true;
			$error['isbn'] = 'There are no records matching that ISBN, try again';	
		}
	}

	//Validate Condition
	if(!array_key_exists('condition', $_POST)){
		$fail['general'] = true;
		$fail['condition'] = true;
		$error['condition'] = 'Please select the condition of the book';
	}else $condition = trim($_POST['condition']);
	if(!$fail['condition'] && !(strcmp($condition,'new') == 0 || strcmp($condition, 'good') == 0 || strcmp($condition, 'fair') == 0 || strcmp($condition, 'poor') == 0)){
		$fail['general'] = true;
		$fail['condition'] = true;
		$error['condition'] = 'Please select the condition of the book';
	}

	//Validate Quantity
	if(!array_key_exists('quantity', $_POST)){
		$fail['general'] = true;
		$fail['quantity'] = true;
		$error['quantity'] = 'Very bad error going on in back-end';
	}else $quantity = trim($_POST['quantity']);
	if(!$fail['quantity'] && strlen($quantity) == 0){
		$fail['general'] = true;
		$fail['quantity'] = true;
		$error['quantity'] = 'Quantity value cannot be empty';
	}
	if(!$fail['quantity'] && !ctype_digit($quantity)){
		$fail['general'] = true;
		$fail['quantity'] = true;
		$error['quantity'] = 'Quantity value must be positive integer';
	}
	if(!$fail['quantity'] && intval($quantity) <= 0){
		$fail['general'] = true;
		$fail['quantity'] = true;
		$error['quantity'] = 'Quantity value must be positive integer above 0';
	}

	//Validate Price
	if(!array_key_exists('price', $_POST)){
		$fail['general'] = true;
		$fail['price'] = true;
		$error['price'] = 'Very bad error';
	}else $price = trim($_POST['price']);
	if(!$fail['price'] && strlen($price) == 0){
		$fail['general'] = true;
		$fail['price'] = true;
		$error['price'] = 'Price value cannot be empty';
	}
	if(!$fail['price'] && !is_numeric($price)){
		$fail['general'] = true;
		$fail['price'] = true;
		$error['price'] = 'Price value must be a positive number';
	}
	if(!$fail['price'] && floatval($price) < 0){
		$fail['general'] = true;
		$fail['price'] = true;
		$error['price'] = 'Price value cannot be negative';
	}
	if(!$fail['price'] && !(strpos(($price*100),'.')===false)){
		$fail['general'] = true;
		$fail['price'] = true;
		$error['price'] = 'Price value cannot have a fraction of a cent!';
	}
	
	//check if there is no error then post the book
	$error = array_filter($error);
	if (empty($error) )
	{	$imageFinalUploadedPath="";
		//ensure that the variable exist
		if(isset($_FILES['picture']))
		{
			//check if the file was uploaded
			if(is_uploaded_file($_FILES['picture']['tmp_name']) && getimagesize($_FILES['picture']['tmp_name']) != false)
			{
				$imageName = $_FILES['picture']['name'];
				$user = $_SESSION['username'];
				$tempImage= $_FILES['picture']['tmp_name'];
				
				//check if a directory for this particular user exist
				$directory = '../bookImages/'.$user;
				
				//if a directory with dce for this particular doesnt exist then make it
				if( !file_exists ($directory ) )
				{
					//echo "Making the directory ";
					mkdir($directory,0777,true);
				}
				
				//make the directory for the isbn inside the dce if it doesnt exist
				$directory = $directory.'/'.$isbn;
				if(!file_exists ( $directory ) )
				{
					//echo "Directory does exit ";
					mkdir($directory,0777,true);	
				}//end of if isbn exist	
				
				//upload the images to the directory.. image are rename with time stamp to prevent any over write of an file
				$extension = end(explode(".",$imageName));
				$imageName = time() .".".$extension;
				$directory = $directory.'/'.$imageName;
				move_uploaded_file($tempImage,$directory);
				
				//assign the path of the final uploaded 
				$imageFinalUploadedPath = substr($directory,3);
				
				echo "Image path : ".$imageFinalUploadedPath;
				
			}
		}//end of adding book image
		
		
		$retrivedArray = $bookJSON['items'][0]['volumeInfo'];
		
		//retrive authors
		$authors="";
		foreach($retrivedArray['authors'] as $single)
		{
			$authors.=$single;
		}
		
		$publisher = $retrivedArray['publisher'];
		$bookYear = $retrivedArray['publishedDate'];
		$title = $retrivedArray['title'];
		$desc = $retrivedArray['description'];
		
		$_SESSION['author'] = $authors;
		$_SESSION['title'] = $title;
		$_SESSION['description'] = $description;
		$_SESSION['img'] = $imageFinalUploadedPath;
		$_SESSION['edition']= $edition;
		$_SESSION['posted']= "posted" ;
		$_SESSION['condition']=$condition;
		
		
		/*-----------------------------------------------------------------------------
		*
		*
		*INSERTING THE DATA IN THE BOOK TABLE
		*
		*
		*
		*-------------------------------------------------------------------------------*/
		//check to see if isbn data for this particular book exist
		$sql = 'CALL getBook(:book_isbn)';
		$stmt = $connection->prepare($sql);
		$stmt->bindParam(':book_isbn',$isbn,PDO::PARAM_INT);
		$getBookStatus = $stmt->execute(); //get the status of the stored procedure
		$result = $stmt->rowCount();
		$stmt->closeCursor();
		
		$hasError = false;
		if($result==0 && $getBookStatus==true)
		{
			echo "BOOK DOESNT EXIST";
			$parameters = ':book_isbn,:book_title,:book_author,:book_publisher,:book_edition,:book_description,:book_written';
			$sql = 'CALL insertBook('.$parameters.')';
			
			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':book_isbn',$isbn,PDO::PARAM_INT);
			$stmt->bindParam(':book_title',$title,PDO::PARAM_STR);
			$stmt->bindParam(':book_author',$authors,PDO::PARAM_STR);
			$stmt->bindParam(':book_publisher',$publisher,PDO::PARAM_STR);
			$stmt->bindParam(':book_edition',$edition,PDO::PARAM_INT);
			$stmt->bindParam(':book_description',$desc,PDO::PARAM_STR);
			$stmt->bindParam(':book_written',$bookYear,PDO::PARAM_INT);
			
			$stat =  $stmt->execute();
			if($stat==false)
			{
				$hasError = true;
			}
			$stmt->closeCursor();
		}
			
		/*-----------------------------------------------------------------------
		*
		*INSERT  DATA IN POST
		*
		*-----------------------------------------------------------------------*/
		//seller, bookid, bookcondition, bookprice, now(), bookdescription, posttype, bookquantity,'A',imgPath
		
		if($hasError == false && $getBookStatus==true)
		{
			echo "stored procedure successful called";
		
			$parameters = ':seller,:bookid,:bookcondition,:bookprice,:posttype,:bookdescription,:bookquantity,:imgPath';
			$sql = 'CALL insertPost('.$parameters.')';
			$stmt = $connection->prepare($sql);
			
			
			$postType = 'sell';
			
			$stmt->bindParam(':seller',$_SESSION['username'],PDO::PARAM_STR);
			$stmt->bindParam(':bookid',$isbn,PDO::PARAM_INT);
			$stmt->bindParam(':bookcondition',$condition,PDO::PARAM_STR);
			$stmt->bindParam(':bookprice',$price,PDO::PARAM_INT);
			$stmt->bindParam(':posttype',$postType,PDO::PARAM_STR);
			$stmt->bindParam(':bookdescription',$description,PDO::PARAM_STR);
			$stmt->bindParam(':bookquantity',$quantity,PDO::PARAM_INT);
			$stmt->bindParam(':imgPath',$imageFinalUploadedPath,PDO::PARAM_STR);
			
			$insertPostStatus = $stmt->execute();
			$stmt->closeCursor();
		}//end of posting in post table
		
		//this has errors
		if($hasError == true || $insertPostStatus==false || $getBookStatus == false)
		{
			Echo " There is an error with adding your post data to the database";
		}
		
		//no error redirect to success page 
		else
		{
			header('location:../successPostBook.php');
		}
		
		
	}
	
	else
	{
		foreach($error as $type)
		{
			echo $type;
			echo"<br/>";
		}
	}
	
}// end of if post is not null

?>