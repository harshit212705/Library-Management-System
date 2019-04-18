<?php
error_reporting(0);
session_start();
include("connection.php");
include("all_functions.php");
//restricting unauthorized access
//faculty dashboard
if ($_SESSION['username']){
	$username = $_SESSION['username'];
	$query = "SELECT * FROM user_credentials WHERE username = '$username'";
    $result = make_query($conn,$query);
	$total = num_of_rows($result);
    $data = fetch_data($result);
	
	if ($total == 1 && $data['account_type'] === 'user')
        header('location:home.php');
	else if ($total == 1 && $data['account_type'] === 'admin')
	    header('location:admin2.php');
}
else{
	header('location:signin.php');
} 
?>



<html>
<head>
	<title>Faculty Dashboard</title>
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style_admin_dashboard.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div id="mySidenav2" class="sidenav2">
  <a href="javascript:void(0)" class="closebtn2" onclick="closeNav()">&times;</a>
  <a href="main.php">HOME</a>
  <a href="logout.php">LOGOUT</a>
</div>
<span style="font-size:30px;color: #fff;border-radius: 3px;margin: 0px 0px 0px 1500px;border: 2px solid white;cursor:pointer" onclick="openNav()">&#9776;
</span>

<div id="mySidenav" class="sidenav">
  <a href="admin.php"><i class="fa fa-home"></i> DASHBOARD</a>
  <a href="all_users.php"><i class="fa fa-male"></i> STUDENTS</a>
  <a href="add_books.php"><i class="fa fa-server"></i> ADD BOOKS</a>
  <a href="delete_books.php"><i class="fa fa-book"></i>DELETE BOOK</a>
  <a href="live_book_search.php"><i class="fa fa-server"></i> FIND BOOKS</a>
  <a href="logout.php"><i class="fa fa-external-link"></i> LOGOUT</a>
</div>

	<div class="container">
		<div class="box">
			<div class="thumb">
				<img src="4.jpg">
			</div>
			<div class="details">
				<div class="content">
					<i class="fa fa-list-alt"></i>
					<h3>BOOK_CATALOGUE</h3>
					<a href="all_books.php">Browse</a>
				</div>
			</div>
		</div>	
		<div class="box">
			<div class="thumb">
				<img src="5.jpg">
			</div>
			<div class="details">
				<div class="content">
					<i class="fa fa-dropbox"></i>
					<h3>Issue Books</h3>
					<a href="issue_books.php">Proceed</a>
				</div>
			</div>
		</div>
		<div class="box">
			<div class="thumb">
				<img src="6.jpg">
			</div>
			<div class="details">
				<div class="content">
					<i class="fa fa-telegram"></i>
					<h3>Return Books</h3>
					<a href="return_books.php">Proceed</a>
				</div>
			</div>
		</div>	
		<div class="box">
			<div class="thumb">
				<img src="7.jpg">
			</div>
			<div class="details">
				<div class="content">
					<i class="fa fa-credit-card"></i>
					<h3>Collect fine</h3>
					<a href="collect_fine.php">Proceed</a>
				</div>
			</div>
		</div>

	</div>
	
</body>
<script>
function openNav() {
  document.getElementById("mySidenav2").style.width = "100%";
  document.getElementById("mySidenav").style.width = "0";
}

function closeNav() {
  document.getElementById("mySidenav2").style.width = "0";
  document.getElementById("mySidenav").style.width = "250px";
}
</script>
</html>