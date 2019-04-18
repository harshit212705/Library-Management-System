<html>
<head>
	<title>Issue Books</title>
	<link rel="stylesheet" type="text/css" href="style_issue_books.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
 <div id="mySidenav2" class="sidenav2">
  <a href="javascript:void(0)" class="closebtn2" onclick="closeNav()">&times;</a>
  <a href="admin.php"> DASHBOARD</a>
  <a href="all_books.php"> BOOKS</a>
  <a href="all_users.php"> STUDENTS</a>
  <a href="collect_fine.php"> FINE</a>
  <a href="add_books.php"> ADD BOOKS</a>
  <a href="logout.php"> LOGOUT</a>
</div>
<br>
<span style="font-size:30px;color: #fff;border-radius: 4px;margin-left: 15px;border: 2px solid white;cursor:pointer" onclick="openNav()">&#9776;
</span>


	
	<h1 data-title="ISSUE BOOK">ISSUE BOOK</h1>

	<div class = "testbox">
	<form id = "a" action = "issue_books.php" method = "POST">
		<div class = "inputbox">
			<label id="icon" for="name"><i class="icon-user"></i></label>
			<input type = "text" name = "username" id = "b" required = "" placeholder = "USERNAME">
		</div>
		<br>
		<div class = "inputbox">
			<label id="icon" for="name"><i class="icon-shield"></i></label>
			<input type = "text" name = "book_id" id = "c" required = "" placeholder = "BOOK ID">
		</div>
		<br>
		<input type = "submit" class="btn" value = "Issue Book" name = "submit" required = ""></input>
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
 error_reporting(0);
	
 //restricting direct unauthorized access 
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
		 //issuing book to user by username and book id of the book
		 if (!get_magic_quotes_gpc()){
		  $username = addslashes($_POST['username']);
		  $book_id = addslashes($_POST['book_id']);
		  }
		  else
		 {
		  $username = $_POST['username'];
		  $book_id = $_POST['book_id'];
	   }
	   $query = "SELECT * FROM user_credentials WHERE username = '$username'";
	   $result1 = make_query($conn,$query);
	   $row1 = num_of_rows($result1);
	   $data = fetch_data($result1);
	   $user_id = $data['Id'];
	   
	   $query = "SELECT * FROM books WHERE book_id = '$book_id' && issue_status = '0'";
	   $result2 = make_query($conn,$query);
	   $row2 = num_of_rows($result2);
	   
	   $query = "SELECT * FROM issued_books WHERE username = '$username'";
	   $result3 = make_query($conn,$query);
	   $row3 = num_of_rows($result3);

	   
	   if ($row1 && $row2 && $row3 < 4){
		   $issue_date = date('Y-m-d');
		   $due_date = date('Y-m-d', time() + 15*86400);
		

			 //inserting issued books details in table issued_books
		   $query = "INSERT INTO issued_books (user_id,username,book_id,issue_date,due_date) VALUES ('$user_id','$username','$book_id','$issue_date','$due_date')";
		   $result = make_query($conn,$query);
		   $result = make_query($conn,"UPDATE books SET issue_status = 1 WHERE book_id = '$book_id'");
		   
		   echo "<script type='text/javascript'>alert('Book issued successfully!')</script>";
		   
		   //book issue mail sending
		   $query = "SELECT email_id FROM user_credentials WHERE username = '$username'";
		   $result = make_query($conn,$query);
		   $data = fetch_data($result);
		   $email_id = $data['email_id'];
		   
		   $query = "SELECT * FROM books WHERE book_id = '$book_id'";
		   $result = make_query($conn,$query);
		   $data = fetch_data($result);
		   
		   $subject = "Books Issue Confirmation Mail";
		   $val = "Issued book details :- <br>"."Book name : ".$data['book_name']."<br>"."Book Id : ".$book_id."<br>"."ISBN Number : ".$data['isbn_number']."<br>"."Subject : ".$data['subject']."<br>"."Writer name : ".$data['writer_name']."<br>"."Issue date : ".$issue_date."<br>"."Due date : ".$due_date."<br>";
				  
			sendmail($email_id,$username,$subject,$val);  	  
			
		   //mail sent
			  
	   }
	   else if (!$row1)
		   echo "<script type='text/javascript'>alert('Invalid username')</script>";
	   else if (!$row2)
		   echo "<script type='text/javascript'>alert('Either this book is already issued or the book is not in library')</script>";   
	   else if ($row3 == 4)
		   echo "<script type='text/javascript'>alert('Four books are already issued to this username')</script>";
	   
		echo "<script> location.href='issue_books.php'; </script>";	 
	   } 
 
    } 
  
 }
  
 ?>