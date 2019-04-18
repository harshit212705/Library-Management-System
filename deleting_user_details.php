<html>
	<head><title>User Details</title>
	<style>
	table,th,td{
	margin: auto;
	color: #000;
	text-align: center;
	font-family: sans-serif;
	margin-left:0;
	border: 3px solid black;
	font-size: 20px;
	padding: 17px;
	}
	</style>
<link rel="stylesheet" type="text/css" href="style_delete_users.css">
</head>
<body>
</body>
</html>
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
	else if ($total == 1 && $data['account_type'] === 'faculty')
	    header('location:admin.php');
}
else{
	header('location:signin.php');
} 
	$username = $_SESSION['deleting_user'];//receiving username from delete user by session

	$query = "SELECT * FROM user_credentials WHERE username = '$username'";
    $result = make_query($conn,$query);
	$total = num_of_rows($result);
	$data = fetch_data($result);
	
	$file = $data['Id'].'.jpg';
	$dir = "uploaded_images/".$file;
	
		echo "<img src = '$dir' height = '100' width = '100' />";
		echo "<br><br>";
		echo "<h2><i><u>"; 
    echo "Username: ".$username."<br>Email-Id: ".$data['email_id']."<br>Mobile Number: ".$data['mobile_number']."<br>Gender: ".$data['gender']."<br>Account type: ".$data['account_type']."<br>";
		echo "</u></i></h2>";
		echo "<br><br>";
	
	$query = "SELECT * FROM issued_books WHERE username = '$username'";
    $result = make_query($conn,$query);
	$total = num_of_rows($result);
	
	
   if ($total > 0){
	 echo "<table>
  <tr>
    <th style='border: 3px solid black;'>Serial No.</th>
    <th style='border: 3px solid black;'>Book Name</th>
	  <th style='border: 3px solid black;'>Issue Date</th>
	  <th style='border: 3px solid black;'>Due Date</th>
  </tr>";
   $i = 1;
   $curr_date = date('Y-m-d');
	 $days = 0;
	 while ($rows = fetch_data($result)){
		 $book_id = $rows['book_id'];
		 $query = "SELECT * FROM books WHERE book_id = '$book_id'";
		$retval = make_query($conn,$query);
		$data = fetch_data($retval);
			
		echo "<tr><td>".$i."</td><td>".$data['book_name']."</td><td>".$rows['issue_date']."</td><td>".$rows['due_date']."</td></tr>";
         $i = $i + 1;

		 $diff = strtotime($curr_date) - strtotime($rows['due_date']);
	   if ($diff > 0)
        $days += floor(($diff / (60*60*24)));  
		 
		}

	  echo "</table>";
	  
	$sql="SELECT fine_due FROM user_credentials where username='$username'" ;
        $result=make_query($conn,$sql);
        $rows=fetch_data($result);
       
	   $fine = $rows['fine_due'] + $days;
	   
   }
   else
	   $fine = $rows['fine_due'];
   
	 echo "<h2><i><u>";
   echo "Users fine:".$fine."<br>";
	 echo "</u></i></h2>";
	 
   echo "<form method = 'post'><input type = 'submit' class='btn' id = 'confirmation' name = 'confirmation' value = 'Confirm'></form>";
   if (isset($_POST['confirmation'])){
	$query = "SELECT * FROM issued_books WHERE username = '$username'";
    $result = make_query($conn,$query);
	$total = num_of_rows($result);
	while($rows = fetch_data($result)){
	  $book_id = $rows['book_id'];
	$retval = make_query($conn,"UPDATE books SET issue_status = 0 WHERE book_id = '$book_id'");
	 }
	 //deleting user
	 $result = make_query($conn,"DELETE FROM user_credentials WHERE username ='$username'");
   echo "<script>alert('User deleted successfully!')</script>";
   echo "<script>location.href='admin2.php'</script>";
  }
  

?>

