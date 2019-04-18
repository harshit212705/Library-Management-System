<?php
//setting up connection with mysql and database library manager
  $conn = mysqli_connect("localhost:3306","root","","library_manager"); 
    if (!$conn){
	  die('not conneted'.error());
  }
  else{
	  echo "";
  }
 
?>