<html>
<head>
	<title>Return Books</title>
	<link rel="stylesheet" type="text/css" href="style_return_books.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

  
  <div id="mySidenav2" class="sidenav2">
  <a href="javascript:void(0)" class="closebtn2" onclick="closeNav()">&times;</a>
  <a href="admin.php"> Dashboard</a>
  <a href="all_books.php"> Books</a>
  <a href="all_users.php"> Students</a>
  <a href="collect_fine.php"> Fine</a>
  <a href="add_books.php"> Add Books</a>
  <a href="logout.php"> Logout</a>
  </div>

<br>
<span style="font-size:25px;color: #fff;border-radius: 3px;margin-left: 95%;border: 2px solid white;cursor:pointer" onclick="openNav()">&#9776;
</span>


 
<div style="overflow-x: auto;">

<h1 data-title="RETURN BOOK">RETURN BOOK</h1>

	<div class = "testbox">
	<form id = "a" action = "return_books.php" method = "POST">
		<div class = "inputbox">
      <label id="icon" for="name"><i class="icon-shield"></i></label>
			<input type = "text" name = "book_id" id = "c" required = "" placeholder = "BOOK ID">
		</div>
		<br>
		<input type = "submit" class="btn" value = "Return Book" name = "submit" required = ""></input>
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
 include("connection.php");
 include("all_functions.php");
 include('sending_email/mail_function.php');
 date_default_timezone_set("Asia/Kolkata");

 session_start();
	
   //restricting unauthorized access
   if (!$_SESSION['username']){
	  header('location:signin.php');
   } 
   else{
	   
	$username = $_SESSION['username'];
	$query = "SELECT * FROM user_credentials WHERE username = '$username'";
    $result = make_query($conn,$query);
	$total = num_of_rows($result);
    $data = fetch_data($result);
	
	if ($total == 1 && $data['account_type'] !== 'faculty')
        header('location:home.php');
	 
	else{
	  if(isset($_POST['submit']))
	 {   
		 if (!get_magic_quotes_gpc())
		  $book_id = addslashes($_POST['book_id']);
		 else
		  $book_id = $_POST['book_id'];
		 
			//returning books by book id
	   $query = "SELECT * FROM issued_books WHERE book_id = '$book_id'";
	   $result = make_query($conn,$query);
	   $rows = num_of_rows($result);
	   if ($rows){
	   $data = fetch_data($result);
	   $username = $data['username'];
		 $due_date = $data['due_date'];
		 
		 //updating issue status of that book
	   $result = make_query($conn,"UPDATE books SET issue_status = 0 WHERE book_id = '$book_id'");
	   
	   $query = "SELECT * FROM user_credentials WHERE username = '$username'";
	   $result = make_query($conn,$query);
	   $data = fetch_data($result);
	   $fine_due = $data['fine_due'];
	   $email_id = $data['email_id'];
	   
	   $return_date = date('Y-m-d');
	   $diff = strtotime($return_date) - strtotime($due_date);
	   $days = floor(($diff / (60*60*24)));
	   
	   if ($days > 0){
		 $fine_due = $fine_due + $days*1;
		 //updating users fine 	   
	   $result = make_query($conn,"UPDATE user_credentials SET fine_due = '$fine_due' WHERE username = '$username'"); 
	   } 
	   else{
		   $days = 0;
	   }   
		
		 //deleting from issue books table
	   $query = "DELETE FROM issued_books WHERE book_id = '$book_id'";
	   $result = make_query($conn,$query);
	   
	   echo "<script type='text/javascript'>alert('Done.')</script>";
	   
		   //book return mail sending
		   
		   $query = "SELECT * FROM books WHERE book_id = '$book_id'";
		   $result = make_query($conn,$query);
		   $data = fetch_data($result);
		   
		   $subject = "Books Return Confirmation Mail";
		   $val = "Return book details :- <br>"."Book name : ".$data['book_name']."<br>"."Book Id : ".$book_id."<br>"."ISBN Number : ".$data['isbn_number']."<br>"."Subject : ".$data['subject']."<br>"."Writer name : ".$data['writer_name']."<br>"."Due date : ".$due_date."<br>"."Return date : ".$return_date."<br>"."Fine for book : ".$days."<br>";
				  
			sendmail($email_id,$username,$subject,$val);  	  
			
		   //mail sent
	   
	   }
	   else{
		echo "<script type='text/javascript'>alert('This book is not of our library.')</script>";  
	   
	   }
	   
		echo "<script> location.href='return_books.php'; </script>";	 
	 } 
   
   }
 
 }
	 
 ?>