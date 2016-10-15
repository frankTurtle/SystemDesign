<?php
   include('Session.php');
   include("Config.php");
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $firstName = $_POST['firstNameInput'];
      $lastName = $_POST['lastNameInput'];
      $emailAddress = $_POST['emailInput'];
      $phoneNumber = $_POST['phoneInput'];
      $password = $_POST['password1Input'];
      $confirmPassword = $_POST['password2Input'];
      $typeOfUser = $_POST['userType'];

  //     INSERT INTO `User`(`firstName`, `lastName`, `email`, `phoneNumber`, `typeOfUser`, `password`) 
		// VALUES ('admin','admin','admin@email.com','1155783456',0,'admin');
		// INSERT INTO `Admin`(`adminID`)
		// VALUES( LAST_INSERT_ID() );

      $sql = "INSERT INTO `User`(`firstName`, `lastName`, `email`, `phoneNumber`, `typeOfUser`, `password`)
      		  VALUES ( '$firstName', '$lastName', '$emailAddress', '$phoneNumber', 0, '$password');";

	  if (mysqli_query($dataBase, $sql)) {
	  		$adminSql = "INSERT INTO `Admin`(`adminID`)
      		  			VALUES ( LAST_INSERT_ID() );";

			if (mysqli_query($dataBase, $adminSql)) {
		    	echo "New record created successfully";
			}
			else {
		    	echo "Error: " . $sql . "<br>" . mysqli_error($dataBase);
			}
		}
      // $count = mysqli_num_rows( $result );

      // // If result matched $myusername and $mypassword, table row must be 1 row
      // if($count == 1) {
      //   session_start();
      //    $_SESSION['login_user'] = $myusername;

      //    $typeOfUser = getUserType(mysqli_fetch_row($result));
         
      //    navigate( $typeOfUser );
      // }else {
      //    $error = "Your Login Name or Password is invalid";
      // }
   }

   // function navigate( $typeOfUser ){
   //  switch ( $typeOfUser ) {
   //      case 0:
   //          header( 'Location: Admin.php' );
   //          break;

   //      case 1:
   //          header( 'Location: Research.php' );
   //          break;

   //      case 2:
   //          header( 'Location: Faculty.php' );
   //          break;

   //      case 3:
   //          header( 'Location: Student.php' );
   //          break;
   //  }
   // }

   // function getUserType( $result ){
   //      $typeOfUserIndex = 5;
   //      return $result[ $typeOfUserIndex ];
   // }

   // function debug_to_console( $data ) {
   //     if ( is_array( $data ) )
   //         $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
   //     else
   //         $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

   //     echo $output;
   // }

?>
<html">
   
   <head>
	  <link rel="stylesheet" type="text/css" href="css/admin.css">
	  <script src="javascript/admin.js"></script>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $login_session; ?></h1> 

     	<ul>
		  <li><a class="active" href="Admin.php">Home</a></li>

		  <li class="dropdown">
		    <a href="#" class="dropbtn">Menu</a>
		    <div class="dropdown-content">
			  <button type="button" name="searchButton" onclick="javascript:generateNewUserForm()">Add new User</button>

			<!-- 
		      <form action="" method = "post">
			    <input type="submit" name="addUser" />
				</form> -->
		    </div>
		  </li>

		  <li><a class = "active" href = "Logout.php">Sign Out</a></li>
		</ul>
      
      <div id="menuSelect"></div>
      <div id="success">
      		<?php
      			echo $sql;
      		?>
      </div>
   </body>
   
</html>