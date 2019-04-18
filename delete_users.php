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
	
	if ($total == 1 && $data['account_type'] === 'user')
        header('location:home.php');
	else if ($total == 1 && $data['account_type'] === 'faculty')
        header('location:admin.php');
	}
else{
	header('location:signin.php');
} 
?>

<html>
<head>
<title>Delete Users</title>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="style_delete_users.css">
</head>
<body>
<div id="mySidenav2" class="sidenav2">
  <a href="javascript:void(0)" class="closebtn2" onclick="closeNav()">&times;</a>
  <a href="admin2.php"> DASHBOARD</a>
  <a href="all_users_admin.php"> STUDENTS</a>
  <a href="all_faculty.php"> FACULTY</a>
  <a href="logout.php"> LOGOUT</a>
</div>
<br>
<span style="font-size:25px;color: #fff;border-radius: 3px;margin-left: 15px;border: 2px solid white;cursor:pointer" onclick="openNav()">&#9776;
</span>


	
<h1 data-title="Delete Users">Delete Users</h1>

 <div class="testbox">
		<form action = "" method = "post" >
			<div class = "inputbox">
				<label id="icon" for="name"><i class="icon-user"></i></label>
				<input type = "text" name = "username" required = "" id = "username" placeholder = "Enter Username">
			</div>
			<button type = "submit" value = "Delete User" name = "submit" class = "btn">Delete User</button>
		</form>
</div>
</body>
<script>
function openNav() {
  document.getElementById("mySidenav2").style.width = "100%";
}

function closeNav() {
  document.getElementById("mySidenav2").style.width = "0";
}
</script>
</html>

<?php

if (isset($_POST['submit'])){
	if (!get_magic_quotes_gpc())
	  $username = addslashes($_POST['username']);
    else
	  $username = $_POST['username'];
    
	$query = "SELECT * FROM user_credentials WHERE username = '$username'";
    $result = make_query($conn,$query);
	$total = num_of_rows($result);
   if ($total){ 
		$_SESSION['deleting_user'] = $username;
		//redirecting to new page to show details
	 header("location:deleting_user_details.php");
    }
 else{
	 echo "*Invalid Username";
 }
}
?>