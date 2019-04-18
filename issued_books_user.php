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
<title>Issued Books</title>
<link rel="stylesheet" type="text/css" href="style_issued_books_user.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div id="mySidenav2" class="sidenav2">
  <a href="javascript:void(0)" class="closebtn2" onclick="closeNav()">&times;</a>
  <a href="home.php"> DASHBOARD</a>
  <a href="all_books_user.php"> BOOKS CATALOGUE</a>
  <a href="fine_user.php"> FINE DUE</a>
  <a href="logout.php"> LOGOUT</a>
</div>
<span style="font-size:30px;color: #fff;border-radius: 3px;margin: 0px 0px 0px 1500px;border: 2px solid white;cursor:pointer" onclick="openNav()">&#9776;
</span>


<div style="overflow-x: auto;">

<h1 data-title="ISSUED BOOKS">ISSUED BOOKS</h1>

<table>
  <tr>
  <th>Serial No.</th> 
  <th>Book Name</th>
	<th>Book Id</th>
	<th>ISBN Number</th>
  <th>Subject</th>
  <th>Writer Name</th>
	<th>Issue Date</th>
	<th>Due Date</th>
  </tr>
  <?php

  $username = $_SESSION['username'];

  $request = "SELECT * FROM issued_books WHERE username = '$username' ";
  $retval = make_query($conn,$request);
  $total = num_of_rows($retval);
  

  //shows the books issued to the logged in user
  if ($total){
	  $i = 1;
	  while ($rows = fetch_data($retval)){
		  $book_id = $rows['book_id'];
		  $query = "SELECT * FROM books WHERE book_id = '$book_id'";
		  $result = make_query($conn,$query);
		  $data = fetch_data($result);
			echo "<tr><td>".$i."</td><td>".$data['book_name']."</td><td>".$data['book_id'].
			"</td><td>".$data['isbn_number']."</td><td>".$data['subject']."</td><td>".$data['writer_name']."</td><td>".$rows['issue_date']."</td><td>".$rows['due_date']."</td></tr>";
			 $i = $i + 1;		
		  }
     	  echo "</table>";
  }

  ?>
</table>
</body>
<script>
function openNav() {
  document.getElementById("mySidenav2").style.width = "100%";
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById('form').style.visibility='hidden';
}

function closeNav() {
  document.getElementById("mySidenav2").style.width = "0";
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById('form').style.visibility='visible';
}
</script>
</html>