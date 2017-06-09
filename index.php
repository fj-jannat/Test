<?php 
	session_start();
	////////////////////////////////////////////////////////////////
	require 'func/connect.php';
	$error = "";

	////////////////login/////////
	if(isset($_POST['login_email']) and isset($_POST['login_password'])){
	
		$email = test_input($_POST['login_email']);  
		$password = md5($_POST['login_password']);
		  
        $sql_login = "SELECT * FROM `login` 
                        WHERE email = '$email'
                                AND password = '$password'";
        $result_login = $conn->query($sql_login);
        $row = $result_login->fetch_assoc();
       
        if($result_login->num_rows == 1)
        {	$id=$row['Manager_id'];
			$_SESSION['sess_user']=$id;
		
			header("Location:Event-manager/event-manager.php?id=$id");
		
        }		
		else
		{
			 echo "<script type='text/javascript'>
					alert('Invalid!');
					window.location.href='http://localhost/event/index.php';
				</script>";	
		}		
          
    }
	
	//data filtering function
	function test_input($data) {
	   $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}
	//upcoming_events
	$date = date('Y-m-d');	
	
	$sql_upcoming_events = "SELECT * from event where Event_date >= $date ORDER BY Event_date DESC";
	$res_upcoming_events = $conn->query($sql_upcoming_events);
	
	// this code selects the unique category names fromt the db table and shows it to user on main page for query based search
	$sql_category_search= "SELECT DISTINCT(event_category) from event";
	$res_category_search= $conn->query($sql_category_search);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Event Management</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/main.css" />

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/style.css" />
	<link rel="stylesheet" href="jquery/jRating.jquery.css" />
	<link rel="stylesheet" href="assets/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/mystyle.css">
	
	<!-- Scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
	
	

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Event Management</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <!--
					<li>
                        <a href="#">About</a>
                    </li>
					-->
                    
                    <li>
                        <a href="loginregister/login.php"><i class="fa fa-user"> User Login</i></a>
                    </li>
					<li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	
    <!-- Page Content -->
    <div class="container">
	
		<!--slider of images at top of page -->
        <div class="row">
			<div class="col-md-12">
                <div id="carousel-example-generic" class="carousel slide " data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <img class="slide-image" style="height: 350px" src="image/slider1.jpg" alt="">
                        </div>
                        <div class="item">
							<img class="slide-image" style="height: 350px" src="image/slider2.jpg" alt="">
                        </div>
                        <div class="item">
                            <img class="slide-image" style="height: 350px" src="image/slider3.jpg" alt="">	<!-- src="http://placehold.it/800x300" -->
                        </div>
                    </div>
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>

        </div>

		<br>
		<br>
		<!--left side bar of the page containing the search by category option.-->
		<div class="col-md-3">
            <div class="list-group">
			<!--
			<form action="#" method="POST">
				<p class="lead list-group-item" style="background-color:powderblue;"><b> Search by Date  </b></p><br>
                <b>From:</b> <input class="list-group-item" name="Date_from" required="" type="date" /><br>
				<b>To:</b> <input class="list-group-item" name="Date_to" required="" type="date" /><br>
				<input class="btn btn-info btn-md special" type="submit" value="Search" />
			</form>
			-->
            </div>
 
            <div class="list-group">
				<p class="lead list-group-item" style="background-color:powderblue;"><b> Search by Categories  </b></p>
				<form method="post" action="">
                <?php
				while($row_category_search = $res_category_search->fetch_assoc()){
						
						$event_cat =$row_category_search['event_category'];
						

					?>
					
					<a href="index_cat.php?cat=<?php echo $event_cat;?>" class="list-group-item" > <?php echo $event_cat ?></a>
					
				
				<?php
				}
				
                ?></form>
				
				
            </div>
        </div>
		<!--Main part of the page  that displays the events on the main screen.-->
        <div class="col-md-9">
			<div class="">

                <div class="row">
				
					<?php 
						$count=0;
						while($row_upcoming_events = $res_upcoming_events->fetch_assoc()){
						$count=$count+1;
						$event_name =$row_upcoming_events['Event_name'];
						$event_category =$row_upcoming_events['event_category'];
						$event_date =$row_upcoming_events['Event_date'];
						$event_time_from =$row_upcoming_events['Event_time_from'];
						$event_time_to =$row_upcoming_events['Event_time_to'];
						$event_venue =$row_upcoming_events['Event_venue'];
						$event_organizer =$row_upcoming_events['Event_organizer'];
						$event_cost =$row_upcoming_events['Event_cost'];
						$event_image =$row_upcoming_events['Event_image'];

					?>
						<div class="col-sm-6 col-lg-6 col-md-6">
							<div class="thumbnail">
								<a href="loginregister/login.php"><img src="Event/<?php echo $event_image ?>" alt=""></a>
								<div class="caption">
									<h4 class="pull-right" style="color:blue;"><?php echo $event_date; ?></h4>
									<h4 style="color:blue;"><?php echo $event_name ?></h4>
									
										<style>
										 dummydeclaration {padding-left: 4em;}
										 tab  { padding-left: 4em;}
										 tab1 { padding-left: 6em;}
										 tab2 { padding-left: 3em;}

										</style>
										<strong>Category</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $event_category ?>
										
										<br>
										<strong>Time</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $event_time_from ." - ". $event_time_to ?>
	
										<br>
										<strong>Organizer</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $event_organizer ?>			
										
										<br>
										<strong>Venue</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $event_venue ?>
										
										<br>
										<strong>Dress Code</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										DRESS
										
										<br>
										<strong><font color= "green">Cost</font></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $event_cost ?>
										<br><br>
										<center> <a class="btn btn-info btn-md" target="" href="loginregister/login.php">Event Registration</a></center>
								
									
								</div>
			
								   
								</div>
						</div>
					<?php
						}
						if ($count==0)
						{
					?>
						<p>No upcoming events</p>
					<?php
						}
					?>


                </div>

            </div>

        </div>
		

    </div>
    <!-- /.container -->
<br> <br>
	<section id="four" class="wrapper style2 special">
		<div class="inner" id="go_contact">
					
			<form action="index.php" method="POST">
				<div class="container 75%">
					<div class="row uniform 50%">
						<div class="6u 12u$(xsmall)">
							<input name="login_email" placeholder="admin@email.com" type="email" required/>
						</div>
						<div class="6u$ 12u$(xsmall)">
							<input name="login_password" placeholder="Password" type="password" required />
						</div>
					</div>
				</div>
				<ul class="actions">
					<li><input type="submit" class="special" value="Admin Login" /></li>
					<li><input type="reset" class="alt" value="Reset" /></li>
				</ul>
			</form>
		
			<ul class="icons">
				<li><a href="#" class="icon fa-facebook">
					<span class="label">Facebook</span>
					</a></li>
				<li><a href="#" class="icon fa-twitter">
						<span class="label">Twitter</span>
					</a></li>
				<li><a href="#" class="icon fa-instagram">
						<span class="label">Instagram</span>
					</a></li>
				<li><a href="#" class="icon fa-linkedin">
						<span class="label">LinkedIn</span>
					</a></li>
			</ul>
			<ul class="copyright">
				<li> Copyright &copy;  2017</li>
			</ul>
			
		</div>
	</section>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/skel.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="jquery/jquery.js"></script>
	<script src="jquery/jRating.jquery.js"></script>
	

</body>

</html>
