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

$username = $_GET['name']; 
  $sql="SELECT fine_due FROM user_credentials where username='$username'" ;
  $result=make_query($conn,$sql);
  $row=fetch_data($result);
  
  $curr_date = date('Y-m-d');
  $sql="SELECT * FROM issued_books where username='$username'" ;
  $result=make_query($conn,$sql);
  $total = num_of_rows($result);
  
  //calculating users fine dynamically including the issued books fine upto current date + previous fine
  if ($total > 0){
	 $days = 0;
	  while ($data = fetch_data($result)){
	   $diff = strtotime($curr_date) - strtotime($data['due_date']);
	   if ($diff > 0)
        $days += floor(($diff / (60*60*24)));  
		 
	    }
	//returning fine to tha ajax request made by collect_fine file
  echo json_encode($row['fine_due'] + $days); 
  }
 
 else{
	 echo json_encode($row['fine_due']);
 } 
  
?>