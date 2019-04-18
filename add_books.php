<?php
error_reporting(0);
session_start();
include("connection.php");
include("all_functions.php");

//restricting unauthorized access
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
//restricting code ends here
?>

<html>
<head>
	<title>Add Books</title>
	<link rel="stylesheet" type="text/css" href="style_add_book.css">
</head>
<body>
	<h1 data-title="Add Books">Add Books</h1>
    <div class = "testbox">
	<form id = "a" action = "add_books.php" method = "post" onsubmit = "return formValidation()">
		<div class = "inputbox">
			<input type = "text" name = "book_name" id = "bookname" required = "" placeholder = "Book Name">
			<span id = "booknameerror" style = "color:red;font-weight:bold;font-size:13px;"></span><br>
		</div>
		<br>
		<div class = "inputbox">
			<input type = "text" name = "isbn_number" id = "isbn_number" required = "" placeholder = "ISBN number">
			<span id = "isbnnumbererror" style = "color:red;font-weight:bold;font-size:13px;"></span><br>
		</div>
		<br>
		<div class = "inputbox">
			<input type = "text" name = "subject" id = "subject" required = "" placeholder = "Subject">
			<span id = "subjecterror" style = "color:red;font-weight:bold;font-size:13px;"></span><br>
		</div>
		<br>
		
		<div class = "inputbox">
			<input class = "inputbox" type = "text" name = "writer_name" id = "writer_name" required = "" placeholder = "Author Name">
			<span id = "writernameerror" style = "color:red;font-weight:bold;font-size:13px;"></span><br>
			
		</div>
		<br>
		<div class = "inputbox">
			<input class = "inputbox" type = "number" name = "quantity" id = "quantity" required = "" placeholder = "Quantity">
			<span id = "quantityerror" style = "color:red;font-weight:bold;font-size:13px;"></span><br>
			
		</div>
		<br>
	
		<input type = "submit" class="btn" value = "Save" name = "submit" required = ""></input>
	</form>
	</div>
	<script type = "text/javascript">

  // this function code helps in client side form validation and avoids unnecessary load on the server
		function formValidation(){
			
			var bookname = document.getElementById('bookname').value;
			var isbnnumbername = document.getElementById('isbn_number').value;
			var subject = document.getElementById('subject').value;
			var writer_name = document.getElementById('writer_name').value;
			var quantity = document.getElementById('quantity').value;
			
			//this is done using regular expressions to bound users to certain data
			var booknamecheck = /^[A-Za-z ]{3,50}$/;
			var isbnnumbercheck = /^[0-9]{13}$/;
			var subjectcheck = /^[A-Za-z ]{2,30}$/;
			var writer_namecheck = /^[A-Za-z ]{3,50}$/;
			var quantitycheck = /^[0-9]{1,1000}$/;
			
			
			
			if (!booknamecheck.test(bookname)){
				document.getElementById('booknameerror').innerHTML = "*Book name must be (3-50) characters long";
				return false;
			}
			else{
				document.getElementById('booknameerror').innerHTML = "";
			}
			if (!isbnnumbercheck.test(isbnnumber)){
				document.getElementById('isbnnumbererror').innerHTML = "*ISBN Number must be 13 digits long";
				return false;
			}
			else{
				document.getElementById('isbnnumbererror').innerHTML = "";
			}
			if (!subjectcheck.test(subject)){
				document.getElementById('subjecterror').innerHTML = "*Subject must be (2-30) characters long";
				return false;
			}
			else{
				document.getElementById('subjecterror').innerHTML = "";
			}
			if (!writer_namecheck.test(writer_name)){
				document.getElementById('writer_nameerror').innerHTML = "*Author Name must be (3-50) characters long";
				return false;
			}
			else{
				document.getElementById('writer_nameerror').innerHTML = "";
			}
			if (!quantitycheck.test(quantity)){
				document.getElementById('quantityerror').innerHTML = "*Quantity must be greater than or equal to 1";
				return false;
			}
			else{
				document.getElementById('quantityerror').innerHTML = "";
			}
			
			
		}

</script>
</body>
</html>

<?php

  if(isset($_POST['submit']))
 {   
	 //for avoiding mysql injection attacks by treating quotes as a part of string data 
     if (!get_magic_quotes_gpc()){
	  $bname = addslashes($_POST['book_name']);
	  $isbn_number = addslashes($_POST['isbn_number']);
	  $subject = addslashes($_POST['subject']);
	  $wname = addslashes($_POST['writer_name']);
	  $quantity = addslashes($_POST['quantity']);
	  }
	  else
	 {
	  $bname = $_POST['book_name'];
	  $isbn_number = $_POST['isbn_number'];
	  $subject = $_POST['subject'];
	  $wname = $_POST['writer_name'];
	  $quantity = $_POST['quantity'];
	  
	  }
	  
	  $bname = strtolower($bname);
	  $subject = strtolower($subject);
	  $wname = strtolower($wname);
	  
	  //checking if books are already there or not
	  $request = "SELECT * FROM books WHERE book_name = '$bname' && subject = '$subject' && writer_name = '$wname'";
	  $retval = make_query($conn,$request);
      $total = num_of_rows($retval);
	  $data = fetch_data($retval);
	  if (($total && $data['isbn_number'] === "$isbn_number") || $total == 0){
		
	  $flag = 0;
	  //inserting books data and creating as many entries as the quantity with increasing book id to identify it
	 for ($i = 0;$i < $quantity;$i++){
		 
	  $query = "INSERT INTO books (book_name,isbn_number,subject,writer_name) VALUES ('$bname','$isbn_number','$subject','$wname')";
	  $result = make_query($conn,$query);
	  $flag = 1;
	   } 
	   
		if (!$result)
	      echo "some error occured".error($conn);
        else if ($flag == 1)
		  echo "<script type='text/javascript'>alert('Book details added successfully!')</script>";
	      echo "<script> location.href='add_books.php'; </script>";	  
	  }
	  else{
		  echo "<br><br>"."ISBN number doesn't matches with the existing data of same book";
	  }
 }
 ?>