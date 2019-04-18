<?php
include("connection.php");
include("all_functions.php");
session_start();
	
//only for faculty
   if (!$_SESSION['username']){
	  header('location:signin.php');
   } 
   else{
	   
	$username = $_SESSION['username'];
	$query = "SELECT * FROM user_credentials WHERE username = '$username'";
    $result = make_query($conn,$query);
	$total = num_of_rows($result);
    $data = fetch_data($result);
	
	if ($total == 1 && $data['account_type'] !== 'faculty')
        header('location:home.php');
	 
	else{

?>

<html>
<head>
	<title>Collect fine</title>
	<link rel="stylesheet" type="text/css" href="style_collect_fine3.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
</head>
<body>
 

	<div id="mySidenav2" class="sidenav2">
  <a href="javascript:void(0)" class="closebtn2" onclick="closeNav()">&times;</a>
  <a href="admin.php"> Dashboard</a>
  <a href="all_books.php"> Books</a>
  <a href="all_users.php"> Students</a>
  <a href="collect_fine.php"> Fine</a>
  <a href="add_books.php"> Add Books</a>
  <a href="logout.php"> Logout</a>
</div>
<br>
<span style="font-size:25px;color: #fff;border-radius: 3px;margin-left: 15px;border: 2px solid white;cursor:pointer" onclick="openNav()">&#9776;
</span>

<script>
function openNav() {
  document.getElementById("mySidenav2").style.width = "100%";
}

function closeNav() {
  document.getElementById("mySidenav2").style.width = "0";
}
</script>
	
	<h1 data-title="Collect Fine">Collect Fine</h1>

	<div class = "box">
	<form id = "a" action = "collect_fine.php" method = "POST">
	<br><br><br><br>
		<div class = "inputbox">
		    <select id = "username" name = "username">
			<option>SELECT USERNAME</option>
			<?php
			$query = "SELECT * FROM user_credentials order by username";
            $result = make_query($conn,$query);
             while ($rows = fetch_data($result)){?>
			   <option><?php echo $rows['username'];
			   ?>
			   </option>
			   <?php
			   }
			   ?>
			</select>
		</div>
		<br>
		<input type = "submit" id = "submit" class="btn" value = "Show Fine" name = "submit" required = ""></input>
	</form>
	</div>
	<span id = "show"></span>
	</body>
	<script type="text/javascript" src="ajax.min.js"> </script>
 <script type="text/javascript">

 $(document).ready(function() { 
    var retval = "";
		//on clicking fine button we send an ajax request to show us the value of current fine
    $("#submit").click(function() {                
     var username = document.getElementById('username').value;
	 
	 $.ajax({    
        type: "GET",
        url: 'ajax_request.php',
		data: {name: username},
        dataType: "JSON",                   
        success: function(data){

		    retval = prompt('Users fine is ' + data, "Enter fine amount to be paid");
            if (retval == 'Enter fine amount to be paid' || retval == null)
				location.href='collect_fine.php';
			  //if the first function is true then second will run and update the fine amt paid by the user
            $.ajax({  
                type: "GET",
                url: "update_fine.php",
                data: {name: username,fine: retval,fine_amt: data},
				dataType: "JSON",
                success: function (data) {
				   alert(data);
				   location.href='collect_fine.php';
                }
            });       
	      }
		  
      });
	  document.write('');
   });

});

</script>
	</html>
 <?php
    }
  }
 ?>