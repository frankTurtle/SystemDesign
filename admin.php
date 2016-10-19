<?php
   include('Session.php');
   include("Config.php");
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $firstName    = $_POST['firstNameInput'];
      $lastName     = $_POST['lastNameInput'];
      $emailAddress = $_POST['emailInput'];
      $phoneNumber  = $_POST['phoneInput'];
      $password1    = $_POST['password1Input'];
      $password2    = $_POST['password2Input'];
      $typeOfUser   = getCorrectUserType( $_POST['userType'] );

      $sql = "INSERT INTO `User`(`firstName`, `lastName`, `email`, `phoneNumber`, `typeOfUser`, `password`)
      		  VALUES ( '$firstName', '$lastName', '$emailAddress', '$phoneNumber', $typeOfUser, '$password1');";

      switch ($typeOfUser) {
      	case 0:
      		if (mysqli_query($dataBase, $sql)) {
	  			$sql = "INSERT INTO `Admin`(`adminID`)
      		  				VALUES ( LAST_INSERT_ID() );";

				if (mysqli_query($dataBase, $sql)) { echo "New record created successfully"; }
				else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
			}
      		break;

  		case 2:
  			$department   = $_POST['departmentID'];

  			if (mysqli_query($dataBase, $sql)) {
	  			$sql = "INSERT INTO `Faculty`(`facultyID`, `officeLocation`, `departmentID`, `facultyType`)
						VALUES ( LAST_INSERT_ID(), 100, $department, 1 );";

				if (mysqli_query($dataBase, $sql)) {
					$sql = "INSERT INTO `FullTimeFaculty`(`fullTimeFacultyID`)
							VALUES ( LAST_INSERT_ID() );";

					if (mysqli_query($dataBase, $sql)) { echo "New record created successfully"; }
					else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
				}
			}
			
  			break;
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

   function getCorrectUserType( $formType ){
   		$ftFaculty = 0;
   		$ptFaculty = 1;
   		$ftStudent = 2;
   		$ptStudent = 3;
   		$admin     = 4;
   		$research  = 5;

   		switch ($formType) {
   			case $ftFaculty:
   			case $ptFaculty:
   				return 2;
   				break;
   			
   			case $ftStudent:
   			case $ptStudent:
   				return 3;
   				break;

   			case $admin:
   				return 0;
   				break;

   			case $research:
   				return 1;
   				break;
   		}
   }



?>
<html>
   
   <head>
	  <link rel="stylesheet" type="text/css" href="css/admin.css">
	  <script src="javascript/admin.js"></script>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <title>Admin Page</title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $login_session; ?></h1> 

     	<ul>
		  <li><a class="active" href="Admin.php">Home</a></li>

		  <li class="dropdown">
		    <a href="#" class="dropbtn">Menu</a>
		    <div class="dropdown-content">
			  <a href=# onclick="javascript:generateNewUserForm()">Add New User</a>
                          <a href=# onclick="javascript:createCourse()">Add New Course</a>
			  <a href=# onclick="javascript:createSection()">Add New Section</a>

		    </div>
		  </li>

		  <li><a class = "active" href = "Logout.php">Sign Out</a></li>
		</ul>
      
      <div id="menuSelect"></div>
      <div id="success">
      		<?php
      			echo $typeOfUser;
      		?>
      </div>
   </body>
   
</html>