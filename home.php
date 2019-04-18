<?php
error_reporting(0);
session_start();
include("connection.php");
include("all_functions.php");

//restricting direct unauthorized access 
if ($_SESSION['username']){
	$username = $_SESSION['username'];
	$query = "SELECT * FROM user_credentials WHERE username = '$username'";
    $result = make_query($conn,$query);
	$total = num_of_rows($result);
    $data = fetch_data($result);
	
	if ($total == 1 && $data['account_type'] === 'faculty')
        header('location:admin.php');
	else if ($total == 1 && $data['account_type'] === 'admin')
	    header('location:admin2.php');
}
else{
	header('location:signin.php');
} 
?>


<html>
<head>
	<title>Home</title>
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style_home_dashboard4.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<section>
	<div id="mySidenav2" class="sidenav2">
  <a href="javascript:void(0)" class="closebtn2" onclick="closeNav()">&times;</a>
  <a href="main.php">HOME</a>
  <a href="logout.php">LOGOUT</a>
  <a href="team.php">TEAM</a>
</div>
<span style="font-size:30px;color: #fff;border-radius: 3px;margin: 0px 0px 0px 1050px;border: 2px solid white;cursor:pointer" onclick="openNav()">&#9776;
</span>


	<div class="container-fluid">


		
		

<div id="mySidenav" class="sidenav">
  <a href="home.php"><i class="fa fa-home"></i> Dashboard</a>
  <a href="logout.php"><i class="fa fa-external-link-square"></i> Logout</a>
</div>




			<div class="container" id="box">
				<div class="row">
					<div class="col-sm-4">
						<div class="card text-center">
							<div class="title">
								<i class="fa fa-address-book" aria-hidden="true"></i>
								<h2>Books_Catalogue</h2>
							</div>
							
		
							<a href="all_books_user.php">Browse</a>
						</div>	
					</div>
                    <div class="col-sm-4">
						<div class="card text-center">
							<div class="title">
								<i class="fa fa-money" aria-hidden="true"></i>
								<h2>Fine_Due</h2>
							</div>
							
							
							<a href="fine_user.php">Check</a>
						</div>	
					</div>
				   
					<div class="col-sm-4">
						<div class="card text-center">
							<div class="title">
								<i class="fa fa-folder-open" aria-hidden="true"></i>
								<h2>Find Books</h2>
							</div>
							
							
							<a href="live_book_search_user.php">Find Books</a>
						</div>	
					</div>
					<div class="col-sm-4">
						<div class="card text-center">
							<div class="title">
								<i class="fa fa-tasks" aria-hidden="true"></i>
								<h2>Issued Books</h2>
							</div>
							
							
							<a href="issued_books_user.php">Check</a>
						</div>	
					</div>
					 <div class="col-sm-4">
						<div class="card text-center">
							<div class="title">
								<i class="fa fa-external-link-square" aria-hidden="true"></i>
								<h2>Logout</h2>
							</div>
							
							
							<a href="logout.php">Exit</a>
						</div>	
					</div>

				</div>
			</div>
		</div>			
	</section>
</body>
<script>
function openNav() {
  document.getElementById("mySidenav2").style.width = "100%";
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById('box').style.visibility='hidden';

}

function closeNav() {
  document.getElementById("mySidenav2").style.width = "0";
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById('box').style.visibility='visible';

}
</script>
</html>