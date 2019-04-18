<?php
include("connection.php");
 include("all_functions.php");
 session_start();
 error_reporting(0);
 
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

?>
<html>
<head>
<title>All faculty</title>
<link rel="stylesheet" type="text/css" href="style_all_users.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>


  <div id="mySidenav2" class="sidenav2">
  <a href="javascript:void(0)" class="closebtn2" onclick="closeNav()">&times;</a>
  <a href="admin2.php"> DASHBOARD</a>
  <a href="all_users_admin.php"> STUDENTS</a>
  <a href="all_faculty.php"> FACULTY</a>
  <a href="logout.php"> LOGOUT</a>
  </div>

<br>
<span style="font-size:25px;color: #fff;border-radius: 3px;margin-left: 95%;border: 2px solid white;cursor:pointer" onclick="openNav()">&#9776;
</span>



<div style="overflow-x: auto;">
<h1 data-title="All Faculty">All Faculty</h1>

<table>
  <tr>
    <th>Serial No.</th> 
    <th>Username</th>
	  <th>Email Id</th>
	  <th>Mobile Number</th>
    <th>Gender</th>
  </tr>
  <?php
   //checking if some specific page the user wants to open
  if (isset($_GET["page"])) 
	  $page = $_GET["page"];
  else 
	  $page=1;
  $faculty = "faculty";
  $results_per_page = 20;
  $start_from = ($page-1) * $results_per_page;
  //using LIMIT to limit data on one page
  $sql = "SELECT * FROM user_credentials WHERE account_type = '$faculty' ORDER BY username LIMIT $start_from, ".$results_per_page;
  $result = make_query($conn,$sql);
  $total = num_of_rows($result); 

  if ($total){
	  $i = $start_from + 1;
	  while ($rows = fetch_data($result)){
		echo "<tr><td>".$i."</td><td>".$rows['username']."</td><td>".$rows['email_id'].    "</td><td>".$rows['mobile_number']."</td><td>".$rows['gender']."</td></tr>";
         $i = $i + 1;		
	  }
	  echo "</table>";
  
	 $request = "SELECT * FROM user_credentials WHERE account_type = '$faculty'";
     $retval = make_query($conn,$request);
     $total = num_of_rows($retval);
	 $total_pages = ceil($total / $results_per_page);  // calculate total pages with results
	 
	 echo "<br><br>";
	 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
            if ($i == $page){
              // creating link  for specific pages and linking them to numbers
			echo "<h2>";
			echo "<a href='all_faculty.php?page=".$i."'";
            echo ">".$i."&nbsp;&nbsp;&nbsp;&nbsp;"."</a>";
			echo "</h2>";
			}
			else{
			echo "<h3>";
			echo "<a href='all_faculty.php?page=".$i."'";
            echo ">".$i."&nbsp;&nbsp;&nbsp;&nbsp;"."</a>";
			echo "</h3>";
			}			
         } 
	 echo "<br><br>";
  }
  
  
  ?>
</table>
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