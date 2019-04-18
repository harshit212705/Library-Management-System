<?php
include("connection.php");
include("all_functions.php");
session_start();
error_reporting(0);
//restricting unauthorized access
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
?>

<html>
<head>
<title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style_admin2.css">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
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
<span style="font-size:30px;color: #fff;border-radius: 3px;margin: -930px 0px 0px 200px;border: 2px solid white;cursor:pointer" onclick="openNav()">&#9776;
</span>


<div id="mySidenav" class="sidenav">
  <a href="admin2.php"><i class="fa fa-home"></i> DASHBOARD</a>
  <a href="all_users_admin.php"><i class="fa fa-male"></i> STUDENTS</a>
  <a href="all_faculty.php"><i class="fa fa-male"></i> FACULTY</a>
  <a href="logout.php"><i class="fa fa-external-link"></i> LOGOUT</a>
</div>


    <div class="container">
       <div class="box">
          <div class="content">
               <h2><i class="fa fa-home"></i></h2>
               <h3>BOOKS CATALOGUE</h3>
               <p>Check out all the books present in our database.</p>
               <a href="all_books_admin.php">BROWSE</a>
          </div>
       </div>
       <div class="box">
          <div class="content">
               <h2><i class="fa fa-male"></i></h2>
               <h3>CHANGE ACCOUNT TYPE</h3>
               <p>Change account_type from user to faculty.</p>
               <a href="change_account_type.php">MODIFY</a>
          </div>
       </div>
       <div class="box">
          <div class="content">
               <h2><i class="fa fa-male"></i></h2>
               <h3>DELETE USER</h3>
               <p>Delete user profile.</p>
               <a href="delete_users.php">DELETE</a>
          </div>
       </div>
       <div class="box">
          <div class="content">
               <h2><i class="fa fa-external-link"></i></h2>
               <h3>SEARCH BOOK</h3>
               <p>Search a particular book.</p>
               <a href="live_book_search_admin.php">SEARCH</a>
          </div>
       </div>   
    </div>
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

</body>
</html>