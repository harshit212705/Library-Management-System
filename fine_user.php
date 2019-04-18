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
	<title>Fine Due</title>
<script type="text/javascript" src="ajax.min.js"> </script>

 
 <script type="text/javascript">
//calling fine_due file by ajax request               
	 $.ajax({    
        type: "GET",
        url: 'fine_due.php',
        dataType: "JSON",                   
        success: function(data){
		    alert(data);
			location.href='home.php';
	      }
      });
	  document.write('');
</script>
</head>
</html>