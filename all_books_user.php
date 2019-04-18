<?php
error_reporting(0);
session_start();
include("connection.php");
include("all_functions.php");

if (!$_SESSION['username']){
	header('location:signin.php');
} 
?>

<html>
<head>
<title>All Books</title>
<link rel="stylesheet" type="text/css" href="style_all_books2.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
 
    
  <div id="mySidenav2" class="sidenav2">
  <a href="javascript:void(0)" class="closebtn2" onclick="closeNav()">&times;</a>
  <a href="admin.php"> Dashboard</a>
  <a href="all_books_user.php"> Books Catalogue</a>
  <a href="fine_due.php"> Fine Due</a>
  <a href="logout.php"> Logout</a>
  </div>

<br>
<span style="font-size:25px;color: #fff;border-radius: 3px;margin-left: 95%;border: 2px solid white;cursor:pointer" onclick="openNav()">&#9776;
</span>


 
<div style="overflow-x: auto;">
 
<h1 data-title="Books Catalogue">Books Catalogue</h1>

<table>
  <tr>
    <th>Serial No.</th>
    <th>Book Name</th>
	  <th>Book Id</th>
	  <th>ISBN Number</th>
    <th>Subject</th>
    <th>Writer Name</th>
  </tr>
  <?php
   //checking if some specific page the user wants to open
  if (isset($_GET["page"])) 
	  $page  = $_GET["page"];
	   
  else 
	  $page=1;
	  
  $results_per_page = 20;
  $start_from = ($page-1) * $results_per_page;
  //using LIMIT to limit data on one page
  $sql = "SELECT * FROM books ORDER BY book_id ASC LIMIT $start_from, ".$results_per_page;
  $result = make_query($conn,$sql);
  $total = num_of_rows($result);  

  if ($total > 0){
	  $i = $start_from + 1;
	  while ($rows = fetch_data($result)){
		echo "<tr><td>".$i."</td><td>".$rows['book_name']."</td><td>".$rows['book_id'].    "</td><td>".$rows['isbn_number']."</td><td>".$rows['subject']."</td><td>".$rows['writer_name'].
		"</td></tr>";
         $i = $i + 1;		
	  }
	  echo "</table>";
	  
	 $request = "SELECT * FROM books";
     $retval = make_query($conn,$request);
     $total = num_of_rows($retval);
	 $total_pages = ceil($total / $results_per_page);  // calculate total pages with results
	 
   echo "<br><br>";
   for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
      if ($i == $page){
     // creating link  for specific pages and linking them to numbers
        echo "<h2>";
            echo "<a href='all_books.php?page=".$i."'";
            echo ">".$i.".&nbsp;&nbsp;&nbsp;&nbsp;"."</a>";
            echo "</h2>";
            }
            else{
              echo "<h3>";
              echo "<a href='all_books.php?page=".$i."'";
              echo ">".$i.".&nbsp;&nbsp;&nbsp;&nbsp;"."</a>";
              echo "</h3>";
            } 
      
         } 
   echo "<br><br>";
  }
  else {
	  //echo "No books in the library";
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