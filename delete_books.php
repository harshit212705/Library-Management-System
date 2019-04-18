<?php
error_reporting(0);
session_start();
include("connection.php");
include("all_functions.php");

//only for faculty
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
?>

<html>
<head>
<title>Delete Books</title>
<script type="text/javascript" src="ajax.min.js"> </script>
 
 <script type="text/javascript">

    var retval = prompt('Delete book by Book Id ', "Enter Book Id");                
	 //sending ajax request to delete book by book id
	 $.ajax({    
        type: "GET",
        url: 'delete_request.php',
		data: {bookid: retval},
        dataType: "JSON",                   
        success: function(data){
		    alert(data);
			location.href='admin.php';
	      }
      });
	  document.write('');
</script>
</head>
</html>