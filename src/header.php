<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Freelancer - Start Bootstrap Theme</title>

    <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/freelancer.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
		/* STYLE FOR DROP DOWN */
		ul.nav li.dropdown:hover > ul.dropdown-menu 
		{
			display: block !important;    
		}
	
		.dropdown-menu li > a:hover, .dropdown-menu li > a:focus, .dropdown-submenu:hover > a
		{
			background:white !importnat;
		}
		
		/*STYLE FOR UPLOAD BUTTON */
		.btn-file {
			position: relative;
			overflow: hidden;
		}
		.btn-file input[type=file] {
			position: absolute;
			top: 0;
			right: 0;
			min-width: 100%;
			min-height: 100%;
			font-size: 100px;
			text-align: right;
			filter: alpha(opacity=0);
			opacity: 0;
			outline: none;
			background: white;
			cursor: inherit;
			display: block;
		}
	</style>

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top">TigreNoble</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
					<li class="page-scroll">
                        <a href="index.php">Book</a>
                    </li>
                    <li class="page-scroll">
                        <a href="postBook.php">Post a book</a>
                    </li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Message<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="inbox.php">Inbox</a></li>
							<!--<li><a href="#">Outbox</a></li>-->
		
						</ul>
					</li>
					
					
                   <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">History<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="bid.php">Bid</a></li>
							<li><a href="trade.php">Trade</a></li>
		
						</ul>
					</li>
					
					<!--<li class="page-scroll">
                        <a href="#portfolio">Notification</a>
                    </li>-->
					
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Approve <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="bidApprovePending.php">Bid</a></li>
							<li><a href="tradeApprovePending.php">Trade</a></li>
		
						</ul>
					</li>
					
					<li class="page-scroll">
                        <a href="logout.php">Logout</a>
                    </li>
                </ul>
				<!--The login on the navbar-->
				<form method="post" action="search.php" class="navbar-form navbar-right" >
                    <div class="form-group">
                        <input type="text" class="form-control" name="searchBook" placeholder="search book">
                    </div>
                </form>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header class ="header-introIndex">
    </header>