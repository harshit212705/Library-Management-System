<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="style_signin.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div> 
	<p id = "user_exist"></p>
</div>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="main.php">HOME</a>
  <a href="signin.php">LOGIN</a>
  <a href="signup.php">REGISTER</a>
  <a href="team.php">TEAM</a>
</div>

<div id="main">
  <span style="border:2px solid white;border-radius: 3px;padding:10px;color: white;font-size:30px;cursor:pointer" onclick="openNav()">&#9776; </span>
</div>


	<div class = "testbox">
		<h1><u>Login</u></h1>
		<form action = "" method = "post" onsubmit = "return formValidation()">
			<div class = "inputbox">
				<label id="icon" for="name"><i class="icon-user"></i></label>
				<input type = "text" name = "username" required = "" id = "username" placeholder = "Username">
				<span id = "usernameerror" style = "color:red;font-weight:bold;font-size:13px;"></span><br>
			</div>
			<div class = "inputbox">
				<label id="icon" for="name"><i class="icon-shield"></i></label>
				<input type = "password" name = "password" required = "" id = "password" placeholder = "password">
				<span id = "passworderror" style = "color:red;font-weight:bold;font-size:13px;"></span><br>
			</div>
			<button type = "submit" value = "SignIn" name = "submit" class = "btn">Submit</button>
		</form>
	<div class="forget">
	<a href = "sending_email/reset_password.php">Forgot password</a>
    </div>
</div>
</body>
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}

function formValidation(){
	//client side form validation
	
	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;
	
	var usernamecheck = /^[A-Za-z0-9._]{3,30}$/;
	var passwordcheck = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@##$$%^&*]{8,20}$/;

	if (!usernamecheck.test(username)){
		document.getElementById('usernameerror').innerHTML = "*User name must be (3-30) characters long and can also have (0-9 or _ or .)";
		return false;
	}
	else{
		document.getElementById('usernameerror').innerHTML = "";
	}
    if (!passwordcheck.test(password)){
		document.getElementById('passworderror').innerHTML = "*Password atleast have one special symbol,0-9 and of length 8-20";
		return false;
	}
	else{
		document.getElementById('passworderrorerror').innerHTML = "";
	}
	
}

</script>	

</html>
	
<?php
include("connection.php");
include("all_functions.php");
session_start();
error_reporting(0);

// restricting unauthorized access
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
	else
		header('location:home.php');
}

if(isset($_POST['submit'])){
      if (!get_magic_quotes_gpc()){
	  $user = addslashes($_POST['username']);
	  $pass = addslashes($_POST['password']);
	  }
	  else
	 {
	  $user = $_POST['username'];
	  $pass = $_POST['password'];
		}
		
		//using sha1
 	$salt = "sgkkgbguislhnbngjuibjcvnbkhg";
	$pass = $pass.$salt;
	$pass = sha1($pass);
	
   $query = "SELECT * FROM user_credentials WHERE username = '$user' && password = '$pass'";
   $result = make_query($conn,$query);
   $total = num_of_rows($result);
   $data = fetch_data($result);
		
	 
	 //redirecting on the basis of account type
    if ($total == 1 && $data['account_type'] === 'admin'){
	 $_SESSION['username'] = $user;
	 header('location:admin2.php');   
   }
   else if ($total == 1 && $data['account_type'] === 'faculty'){
	 $_SESSION['username'] = $user;
	 header('location:admin.php');   
   }
   else if ($total == 1){
	 $_SESSION['username'] = $user;
	 header('location:home.php');   
   }
   else{
	   echo "<p style = 'color:red;margin-left:630px;font-size:20px;'>Login failed</p>";
   }
  
 }

?>