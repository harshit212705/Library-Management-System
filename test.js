<!DOCTYPE html>
<html>
<head>
	<title>Collect fine</title>
	<!--<link rel="stylesheet" type="text/css" href="style_signup.css">-->
 
 <script type="text/javascript" src="ajax.min.js"> </script>
 
 <script type="text/javascript" >

 $(document).ready(function() {
    
    $("#submit").click(function() {                
     var username = document.getElementById('username').value;
	 $.ajax({    //create an ajax request
        type: "GET",
        url: 'ajax_request.php',
        data: {name: username},		
        dataType: "xml",
        complete: function(){
        alert(this.data)
          },		                
        success: function(xml){
			/*if (!data){
				document.write('sorry');
			}
			else{
				document.write('hurray');
			}
            console.log(data);
			alert(data);*/
        }

    });
document.write("good trial");	 
});

});

</script>
</head>
<body>
	<div class = "box">
	<h2><b>Collect fine</b></h2>
	<form id = "a" action = "collect_fine.php" method = "POST">
		<div class = "inputbox">
		    <select id = "username" name = "username">
			<option>Select username</option>
			<?php
			include("connection.php");
			$query = "SELECT * FROM user_credentials order by username";
            $result = mysqli_query($conn,$query);
             while ($rows = mysqli_fetch_assoc($result)){?>
			   <option><?php echo $rows['username'];
			   ?>
			   </option>
			   <?php
			   }
			   ?>
			</select>
		</div>
		<br>
		<input type = "submit" id = "submit" value = "Show Fine" name = "submit" required = ""></input>
	</form>
	</div>
</body>
</html>

 