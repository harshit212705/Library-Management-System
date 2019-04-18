<?php
  include("connection.php");
  include("all_functions.php");
  session_start();
  error_reporting(0);
  
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

  $username = $_SESSION['username'];
  $sql = "SELECT * FROM user_credentials WHERE username = '$username'";
  $result = make_query($conn,$sql);
  $row = fetch_data($result);
  
  //calculating users due fine
  $curr_date = date('Y-m-d');
  $sql="SELECT * FROM issued_books where username='$username'" ;
  $result=make_query($conn,$sql);
  $total = num_of_rows($result);
   $days = 0;
  if ($total > 0){
	
	  while ($data = fetch_data($result)){
	   $diff = strtotime($curr_date) - strtotime($data['due_date']);
	   if ($diff > 0)
       $days += floor(($diff / (60*60*24)));  
	    }
	}
  echo json_encode('Your due fine is '.($row['fine_due'] + $days));

?> 