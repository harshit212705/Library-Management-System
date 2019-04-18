<?php
error_reporting(0);
session_start();
include("connection.php");
include("all_functions.php");

// restricting unauthorized access
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

//getting ajax request
  $username = $_GET['name'];
  $fine_paid = $_GET['fine'];
  $fine_amt = $_GET['fine_amt'];
  $sql="SELECT fine_due FROM user_credentials WHERE username='$username'" ;
  $result=make_query($conn,$sql);
  $total = num_of_rows($result);
  $row=fetch_data($result);
  $updated_fine = $row['fine_due'] - $fine_paid;  
  
  //updating users fine
  $result = make_query($conn,"UPDATE user_credentials SET fine_due = '$updated_fine' WHERE username = '$username'");
   if ($username === 'Enter fine amount to be paid')
	  echo json_encode("No fine amount is entered");
   else
     echo json_encode("Users fine updated successfully");
  
?>