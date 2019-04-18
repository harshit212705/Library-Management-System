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
	else if ($total == 1 && $data['account_type'] === 'admin')
	    header('location:admin2.php');
}
else{
	header('location:signin.php');
} 
//receiving an ajax request from delete_book file
$bookid = $_GET['bookid'];
  $sql="SELECT * FROM books WHERE book_id='$bookid'" ;
  $result=make_query($conn,$sql);
  $total = num_of_rows($result);
  $row=fetch_data($result);
 
  //answering ajax calls
  if ($total == 0){
	  echo json_encode("This book doesn't exist in the library!");
  }
  else{
	  if ($row['issue_status']){
		 echo json_encode("Presently this book is issued to someone! Try deleting later");
	  }
	  else{
		 
	  $result = make_query($conn," DELETE FROM books WHERE book_id='$bookid'");
		
		 echo json_encode("Book deleted successfully!"); 
	  }
  }  
    
?>