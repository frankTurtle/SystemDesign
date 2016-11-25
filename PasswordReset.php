<?php
   include('Session.php');

   if($_SERVER["REQUEST_METHOD"] == "POST") {
		$newPassword = $_POST['newPass1'];
		$sql = "UPDATE User SET `password` = '$newPassword' WHERE `userID` = '$userID'";


        if (mysqli_query($dataBase, $sql)) { 
        	echo "<script type='text/javascript'>alert('Password updated');</script>";
        	echo "<script type='text/javascript'>location.href = 'Login.php';</script>";
        }
        else { echo "<script type='text/javascript'>alert('Daniel broke something, Try again.');</script>"; }
   }
?>
<html>

	<head>
     <link rel="stylesheet" type="text/css" href="css/student.css">
     <script src="javascript/admin.js" type="text/javascript"></script>
     <script src="javascript/student.js" type="text/javascript"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <title>Password Reset Page</title>
   </head>
   
   <body>
      	<h1>Welcome <?php echo $login_session; ?></h1>

      	<ul>
        	<li><a class="active" href="javascript:history.go(-1)">Home</a></li>
        	<li><a class="active" href = "Logout.php">Sign Out</a></li>
      	</ul>

      	<form method="post" action="" id="resetPassword">

      		<label>Current Password: <input type = "password" name = "currentPassword"/></label><br /><br />
      		<label>New Password:<input type = "password" name = "newPass1" id="newPass1"/></label><br /><br />
          	<label>Confirm Password:<input type = "password" name = "newPass2" id="newPass2"/></label><br/><br />

           	<input type="submit" value="Reset Password" id="submitButton">

		</form>


		<script>
			$("#submitButton").on('click',  
				function(e){
					e.preventDefault(); 

				    var pass1 = $("#newPass1").val();
				    var pass2 = $("#newPass2").val();

				    if (pass1 != pass2){
				    	$( "#resetPassword" ).trigger( "reset" );
				        alert("Passwords do not match");
				        return false;
				    }
				    else{
				        $("#resetPassword").submit();
				    }
				}
			);
		</script>

	</body>
   
</html>