<?php
error_reporting(0);
session_start();
include("connection.php");
include("all_functions.php");

//restricting direct unauthorized access 
if (!$_SESSION['username']){
	header('location:signin.php');
} 
?>
<html>
 <head>
  <title>Book Search</title>
  <link rel="stylesheet" type="text/css" href="style_find_books.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
 </head>
 <body>

 <div id="mySidenav2" class="sidenav2">
  <a href="javascript:void(0)" class="closebtn2" onclick="closeNav()">&times;</a>
  <a href="admin.php"> DASHBOARD</a>
  <a href="all_books.php"> BOOKS</a>
  <a href="all_users.php"> STUDENTS</a>
  <a href="collect_fine.php"> FINE</a>
  <a href="add_books.php"> ADD BOOKS</a>
  <a href="logout.php"> LOGOUT</a>
</div>
<span style="font-size:30px;color: #fff;border-radius: 3px;margin: 0px 0px 0px 1500px;border: 2px solid white;cursor:pointer" onclick="openNav()">&#9776;
</span>



<h1 data-title="BOOK SEARCH">BOOK SEARCH</h1>

  <div class="testbox">
   <br>
   <form id="form">
    <div>
    <label id="icon" for="name"><i class="icon-arrow-right"></i></label>

     <input type="text" oninput = "pass_data()" name="search_bookname" id="search_bookname" placeholder="Search by Bookname" class="form-control" >
    </div>
	<div>
    <label id="icon" for="name"><i class="icon-arrow-right"></i></label>

     <input type="text" oninput = "pass_data()" name="search_isbn_number" id="search_isbn_number" placeholder="Search by ISBN number" class="form-control" >
    </div>
	<div>
    <label id="icon" for="name"><i class="icon-arrow-right"></i></label>

     <input type="text" oninput = "pass_data()" name="search_subject" id="search_subject" placeholder="Search by Subject" class="form-control" >
    </div>
	<div>
    <label id="icon" for="name"><i class="icon-arrow-right"></i></label>

	 <input type="text" oninput = "pass_data()" name="search_writer_name" id="search_writer_name" placeholder="Search by Author name" class="form-control" >
    </div>
   </form>
   <br>
   <div id="result"></div>
  </div>
 </body>
 <script>
function openNav() {
  document.getElementById("mySidenav2").style.width = "100%";
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById('form').style.visibility='hidden';
}

function closeNav() {
  document.getElementById("mySidenav2").style.width = "0";
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById('form').style.visibility='visible';
}
</script>
</html>


<script>
  //pass data is called everytime there is some change in any input field by using oninput event listener
 function pass_data(){

    var book_name = document.getElementById('search_bookname').value;  
    var isbn_number = document.getElementById('search_isbn_number').value;  
    var subject = document.getElementById('search_subject').value;  
    var writer_name = document.getElementById('search_writer_name').value; 
	load_data(book_name,isbn_number,subject,writer_name); //calling load data by passing values
 } 
 
 function load_data(book_name,isbn_number,subject,writer_name)
 {
  //sending ajax request
  $.ajax({
   type:"GET",	  
   url:"find_book.php",
   data:{book_name:book_name,isbn_number:isbn_number,subject:subject,writer_name:writer_name},
   success:function(data)
   {
    $('#result').html(data);
   }
  });
 }

</script>