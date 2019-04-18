<?php
include("connection.php");
include("all_functions.php");
error_reporting(0);
session_start();

//restricting direct unauthorized access 
if (!$_SESSION['username']){
	header('location:signin.php');
}

//getting ajax call from live_book_search file
$output = '';
$book_name = $_GET['book_name'];
$isbn_number = $_GET['isbn_number'];
$subject = $_GET['subject'];
$writer_name = $_GET['writer_name'];

//query if something matches the users requirements in the field entered
if($book_name !== '' || $isbn_number !== '' || $subject !== '' || $writer_name !=='')
{
 $query = "SELECT * FROM books WHERE book_name LIKE '%".$book_name."%' AND isbn_number LIKE '%".$isbn_number."%' AND subject LIKE '%".$subject."%' AND writer_name LIKE '%".$writer_name."%' AND issue_status = 0";
}

$result = make_query($conn, $query);
$total = num_of_rows($result);
if($total)
{
 $output .= '
  <div class="table-responsive">
   <table class="table table bordered">
    <tr>
     <th>Book Name</th>
     <th>Book Id</th>
     <th>ISBN number</th>
     <th>Subject</th>
     <th>Author Name</th>
    </tr>';
    //appending data into output variable
 while($row = fetch_data($result))
 {
  $output .= '
   <tr>
    <td>'.$row["book_name"].'</td>
    <td>'.$row["book_id"].'</td>	
    <td>'.$row["isbn_number"].'</td>
    <td>'.$row["subject"].'</td>
    <td>'.$row["writer_name"].'</td>
   </tr>';
 }
 //returning data
 echo $output;
}
else
{
echo "<h3>"; echo 'Data Not Found'; echo "</h3>";
}

?>