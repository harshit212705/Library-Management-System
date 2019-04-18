<?php
session_start();
error_reporting(0);
include("connection.php");
include("all_functions.php");


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
	else if ($total == 1)
		header('location:home.php');
  }

?>
<html>
<head>
	<title>Sign up page</title>
	<link rel="stylesheet" type="text/css" href="style_signup.css">
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
<div class="testbox">
  <h1>Registration</h1>

  <form id = "a"  onsubmit = "return formValidation()" action = "signup.php" method = "post" enctype = "multipart/form-data">
  <label id="icon" for="name"><i class="icon-user"></i></label>
  <input type="text" name="first_name" id="firstname" placeholder="First-Name" required = ""/>
  <span id = "firstnameerror" style = "color:red;font-weight:bold;font-size:13px;"></span><br>
  
  <label id="icon" for="name"><i class="icon-user"></i></label>
  <input type="text" name="last_name" id="lastname" placeholder="Last-Name" required = "" />
  <span id = "lastnameerror" style = "color:red;font-weight:bold;font-size:13px;"></span><br>
  
  <label id="icon" for="name"><i class="icon-shield"></i></label>
  <input type="text" name="user_name" id="user_name" placeholder="Username" required = "" />
  <span id = "usernameerror" style = "color:red;font-weight:bold;font-size:13px;"</span><br>
  
  <label id="icon" for="name"><i class="icon-shield"></i></label>
  <input type="password" name="password" id="password" placeholder="Password" required = "" />
  <span id = "passworderror" style = "color:red;font-weight:bold;font-size:13px;"></span><br>
  
  <label id="icon" for="name"><i class="icon-user"></i></label>
  <input type = "text" name = "mobile_number" id = "mobilenumber" placeholder="Mobile no." required = "" />
  <span id = "mobilenumbererror" style = "color:red;font-weight:bold;font-size:13px;"></span><br>
  
  <label id="icon" for="name"><i class="icon-envelope "></i></label>
  <input type="text" name="email" id="email" placeholder="Email" required = "" />
  <span id = "emailerror" style = "color:red;font-weight:bold;font-size:13px;"></span><br>
  
  <hr>
  <div class="gender">
    <input type="radio" value="Male" id="male" name="gender" />
    <label for="male" class="radio" style = "color:black;font-weight:500;">Male</label>
    <input type="radio" value="Female" id="female" name="gender" />	
    <label for="female" class="radio" style = "color:black;font-weight:500;">Female</label>
  </div>

  <input type = "file" name = "uploadfile" value = "" >		
  <button type = "submit" class="btn" value = "SignUp" name = "submit" required = "">Register</button>

  </form>
</div>
</body>
<script type = "text/javascript">
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
/*
function formValidation(){
	
	var firstname = document.getElementById('firstname').value;
	var lastname = document.getElementById('lastname').value;
	var username = document.getElementById('user_name').value;
	var password = document.getElementById('password').value;
	var mobilenumber = document.getElementById('mobilenumber').value;
	var email = document.getElementById('email').value;
	
	var firstnamecheck = /^[A-Za-z]{3,30}$/;
	var lastnamecheck = /^[A-Za-z]{3,30}$/;
	var usernamecheck = /^[A-Za-z0-9._]{3,30}$/;
	var passwordcheck = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@##$$%^&*]{8,20}$/;
	var mobilenumbercheck = /^[6789]{1}[0-9]{9}$/;
	var emailcheck = /^[A-Za-z_]{3,}@[A-Za-z]{3,}[.]{1}[A-Za-z.]{2,6}$/;
	
	
	if (!firstnamecheck.test(firstname)){
		document.getElementById('firstnameerror').innerHTML = "*First name must be (3-30) characters long";
		return false;
	}
	else{
		document.getElementById('firstnameerror').innerHTML = "";
	}
	if (!lastnamecheck.test(lastname)){
		document.getElementById('lastnameerror').innerHTML = "*Last name must be (3-30) characters long";
		return false;
	}
	else{
		document.getElementById('lastnameerror').innerHTML = "";
	}
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
	if (!mobilenumbercheck.test(mobilenumber)){
		document.getElementById('mobilenumbererror').innerHTML = "*Mobile Number must be 10 digit long and start with any of them (6,7,8,9)";
		return false;
	}
	else{
		document.getElementById('mobilenumbererrorerror').innerHTML = "";
	}
	if (!emailcheck.test(email)){
		document.getElementById('emailerror').innerHTML = "*Email is Invalid";
		return false;
	}
	else{
		document.getElementById('emailerror').innerHTML = "";
	}
	
}*/

</script>

</html>
<?php

     if(isset($_POST['submit']))
     {   
       if (!get_magic_quotes_gpc()){
	    $fname = addslashes($_POST['first_name']);
	    $lname = addslashes($_POST['last_name']);
	    $username = addslashes($_POST['user_name']);
	    $password = addslashes($_POST['password']);
	    $mob_number = addslashes($_POST['mobile_number']);
	    $email = addslashes($_POST['email']);
	    $gender = addslashes($_POST['gender']);
	  
	    }
	   else
	   {
		  $fname = $_POST['first_name'];
		  $lname = $_POST['last_name'];
		  $username = $_POST['user_name'];
		  $password = $_POST['password'];
		  $mob_number = $_POST['mobile_number'];
		  $email = $_POST['email'];
		  $gender = $_POST['gender'];
		  }
		  
		  $salt = "sgkkgbguislhnbngjuibjcvnbkhg";
		  $password = $password.$salt;
		  $password = sha1($password);
		   
		  $request = "SELECT * FROM user_credentials WHERE username = '$username'";
		  $retval = make_query($conn,$request);
		  $total = num_of_rows($retval);
	   
		  if ($total == 1){
		   
		   echo "<script>
		   document.getElementById('usernameerror').innerHTML = '**Username already exists!';
		   </script>";
		   
		  }
		  else{
    $query = "INSERT INTO user_credentials (first_name,last_name,username,password,email_id,mobile_number,gender) VALUES ('$fname','$lname','$username','$password','$email','$mob_number','$gender')";
			$query = make_query($conn,$query);
			
			  $_SESSION['username'] = $username;
			  $username = $_SESSION['username'];
			  $query = "SELECT * FROM user_credentials WHERE username = '$username'";
			  $result = make_query($conn,$query);
			  $total = num_of_rows($result);
			  $data = fetch_data($result);
				
				//uploading images by the name of users id
			  $filename = $_FILES["uploadfile"]["name"];
			  $filename = $data['Id'].".jpg";
			  $tempname = $_FILES["uploadfile"]["tmp_name"];
			  $folder = "uploaded_images/".$filename;
			  move_uploaded_file($tempname,$folder);
			  
              echo "<script>location.href='signup.php';</script>";			  
			  }
          }	  
       
   
 ?>