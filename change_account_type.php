<html>
<head>
<title>Change account type</title>
<link rel="stylesheet" type="text/css" href="style_change_account_type.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div id="mySidenav2" class="sidenav2">
  <a href="javascript:void(0)" class="closebtn2" onclick="closeNav()">&times;</a>
  <a href="admin2.php"> DASHBOARD</a>
  <a href="all_books_admin.php"> BOOKS</a>
  <a href="logout.php"> LOGOUT</a>
</div>
<br>
<span style="font-size:25px;color: #fff;border-radius: 3px;margin-left: 15px;border: 2px solid white;cursor:pointer" onclick="openNav()">&#9776;
</span>


	
<h1 data-title="Change account type">Change account type</h1>
<div class="testbox">
		<form action = "" method = "post" >
			<div class = "inputbox">
			    <label id="icon" for="name"><i class="icon-user"></i></label>
				<input type = "text" name = "username" required = "" id = "username" placeholder = "Enter Username">
			</div>
			<div class = "inputbox">
			    <label id="icon" for="name"><i class="icon-user"></i></label>
				<input type = "text" name = "acc_type" required = "" id = "acc_type" placeholder = "Account type (faculty or user)">
			</div>
			<button type = "submit" class="btn" value = "Update account type" name = "submit">update account type</button>
		</form>
		<br>
		<div>
		<span style = "color:red;text-align:center;" id = "update_done" ></span>
		</div>
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
include("all_functions.php");
include("connection.php");
session_start();
error_reporting(0);

//only for admin
if ($_SESSION['username']){
	$username = $_SESSION['username'];
	$query = "SELECT * FROM user_credentials WHERE username = '$username'";
    $result = make_query($conn,$query);
	$total = num_of_rows($result);
    $data = fetch_data($result);
	
	if ($total == 1 && $data['account_type'] === 'faculty')
        header('location:admin.php');
	else if ($total == 1 && $data['account_type'] === 'user')
	    header('location:home.php');
}
else{
	 header('location:signin.php');
}

if (isset($_POST['submit'])){
	if (!get_magic_quotes_gpc()){
	$username = addslashes($_POST['username']);
	$acc_type = addslashes($_POST['acc_type']);
	}
    else{
	  $username = $_POST['username'];
	  $acc_type = $_POST['acc_type'];
	 } 
	 //changing username account type
$query = "UPDATE user_credentials SET account_type = '$acc_type' WHERE username = '$username'";
$result = make_query($conn,$query);
echo "<script>
		   document.getElementById('update_done').innerHTML = '*User account type updated!';
		   </script>";

}
?>