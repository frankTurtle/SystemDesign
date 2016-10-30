<?php
   include('Session.php');
   include("Config.php");
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
<<<<<<< HEAD
      if($_POST['hiddenButton'] == 0){
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
||||||| merged common ancestors
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
=======
      if($_POST['hiddenButton'] == 0){
         $firstName    = $_POST['firstNameInput'];
         $lastName     = $_POST['lastNameInput'];
         $emailAddress = $_POST['emailInput'];
         $phoneNumber  = $_POST['phoneInput'];
         $password1    = $_POST['password1Input'];
         $password2    = $_POST['password2Input'];
         $userType     = $_POST['userType'];
         $typeOfUser   = getCorrectUserType( $userType );

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

            case 1:
               if (mysqli_query($dataBase, $sql)) {
                  $sql = "INSERT INTO `Research`(`researchID`)
                           VALUES ( LAST_INSERT_ID() );";

                  if (mysqli_query($dataBase, $sql)) { echo "New record created successfully"; }
                  else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
               }
               break;

            case 2:
               $department = $_POST['departmentID'];

               if (mysqli_query($dataBase, $sql)) {
                  if( $userType == 0 ){
                     $sql = "INSERT INTO `Faculty`(`facultyID`, `officeLocation`, `departmentID`, `facultyType`)
                           VALUES ( LAST_INSERT_ID(), 100, $department, 1 );";

                     if (mysqli_query($dataBase, $sql)) {
                        $sql = "INSERT INTO `FullTimeFaculty`(`fullTimeFacultyID`)
                              VALUES ( LAST_INSERT_ID() );";

                        if (mysqli_query($dataBase, $sql)) { echo "New record created successfully"; }
                        else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
                     }
                     else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }   
                  }

                  if( $userType == 1 ){
                     $sql = "INSERT INTO `Faculty`(`facultyID`, `officeLocation`, `departmentID`, `facultyType`)
                           VALUES ( LAST_INSERT_ID(), 100, $department, 0 );";

                     if (mysqli_query($dataBase, $sql)) {
                        $sql = "INSERT INTO `PartTimeFaculty`(`partTimeFacultyID`)
                              VALUES ( LAST_INSERT_ID() );";

                        if (mysqli_query($dataBase, $sql)) { echo "New record created successfully"; }
                        else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
                     }
                     else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }   
                  }
               }
               break;

            case 3:
               if (mysqli_query($dataBase, $sql)) {
                  if( $userType == 2 ){
                     $sql = "INSERT INTO `Student`(`studentID`, `studentType` )
                           VALUES ( LAST_INSERT_ID(), 1 );";

                     if (mysqli_query($dataBase, $sql)) {
                        $sql = "INSERT INTO `FullTimeStudent`(`fullTimeStudentID`)
                              VALUES ( LAST_INSERT_ID() );";

                        if (mysqli_query($dataBase, $sql)) { echo "New record created successfully"; }
                        else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
                     }
                     else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }   
                  }

                  if( $userType == 1 ){
                     $sql = "INSERT INTO `Student`(`studentID`, `studentType` )
                           VALUES ( LAST_INSERT_ID(), 0 );";

                     if (mysqli_query($dataBase, $sql)) {
                        $sql = "INSERT INTO `PartTimeStudent`(`partTimeStudentID`)
                              VALUES ( LAST_INSERT_ID() );";

                        if (mysqli_query($dataBase, $sql)) { echo "New record created successfully"; }
                        else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
                     }
                     else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }   
                  }
               }
               break;

         }
>>>>>>> admin
      }
}

if($_POST['hiddenButton'] == 1){

      $department    = $_POST['departmentIDInput'];
      $creditHours     = $_POST['creditHoursInput'];
      $courseName = $_POST['courseNameInput'];
      $textbook  = $_POST['textbookInput'];
      $description    = $_POST['descriptionInput'];
      $courseCode    = $_POST['courseCodeInput'];
      
         $sql = "INSERT INTO `Course`(`departmentID`, `creditHours`, `courseName`, `description`, `textBook`, `courseCode`)
              VALUES ( '$department', '$creditHours', '$courseName', '$description', '$textbook', '$courseCode');";

         if (mysqli_query($dataBase, $sql)) { echo "New record created successfully"; }
            else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
   }

if($_POST['hiddenButton'] == 2){

      $course    = $_POST['courseIDInput'];
      $term     = $_POST['termIDInput'];
      $timeslot = $_POST['timeslotInput'];
      $room  = $_POST['roomIDInput'];
      $faculty    = $_POST['facultyIDInput'];
      $sectionNum    = $_POST['sectionNumInput'];
      

      $sqler ="SELECT buildingID FROM `Room` WHERE `roomID`= 1";

      if($building =   mysqli_query($dataBase, $sqler)){ echo "Building was found"; }
            else { echo "Error: " . $sqler . "<br>" . mysqli_error($dataBase); }
            
            $row = mysqli_fetch_assoc($building);
            
         $sql = "INSERT INTO `Section`(`courseID`, `sectionNum`, `timeslotID`, `termID`, `buildingID`, `roomID`, `facultyID`)
              VALUES ( '$course', '$sectionNum', '$timeslot', '$term', '$row[0]', '$room' , '$faculty');";

<<<<<<< HEAD
         if (mysqli_query($dataBase, $sql)) { echo "New record created successfully"; }
            else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
   }     
      // $count = mysqli_num_rows( $result );
||||||| merged common ancestors
	  
      // $count = mysqli_num_rows( $result );
=======
      if($_POST['hiddenButton'] == 1){
         $department  = $_POST['departmentID'];
         $creditHours = $_POST['creditHoursInput'];
         $courseName  = $_POST['courseNameInput'];
         $textbook    = $_POST['textbookInput'];
         $description = $_POST['descriptionInput'];
         $courseCode  = $_POST['courseCodeInput'];

         $printSuccess = False;
         
         $sql = "INSERT INTO `Course`(`departmentID`, `creditHours`, `courseName`, `description`, `textBook`, `courseCode`)
                 VALUES ( '$department', '$creditHours', '$courseName', '$description', '$textbook', '$courseCode');";

         if (mysqli_query($dataBase, $sql)) {
            $courseID1 = $_POST['prerequisite1'];
            $courseID2 = $_POST['prerequisite2'];
            $courseID3 = $_POST['prerequisite3'];
            $lastID = mysqli_insert_id($dataBase);

            if ($courseID1 != 'Prerequisite One'){
               $sql = "INSERT INTO `Prerequisites`(`prerequisiteID`, `courseID`)
                        VALUES ( '$courseID1', '$lastID' );";

               if (!mysqli_query($dataBase, $sql)) {  
                  echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); 
                  $printSuccess = False;
               }
               else{ $printSuccess = True; }
            }

            if ($courseID2 != 'Prerequisite Two'){
               $sql = "INSERT INTO `Prerequisites`(`prerequisiteID`, `courseID`)
                        VALUES ( '$courseID2', '$lastID' );";

               if (!mysqli_query($dataBase, $sql)) {  
                  echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); 
                  $printSuccess = False;
               }
               else{ $printSuccess = True; }
            }
>>>>>>> admin

            if ($courseID3 != 'Prerequisite Three'){
               $sql = "INSERT INTO `Prerequisites`(`prerequisiteID`, `courseID`)
                        VALUES ( '$courseID3', '$lastID' );";

               if (!mysqli_query($dataBase, $sql)) {  echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
               else{ $printSuccess = True; }
            }
         }

         if ( $printSuccess ) { echo "New record created successfully"; }
         else { echo "Error: Record not created, try again later"; }
      }

      if($_POST['hiddenButton'] == 2){
         $course     = $_POST['courseIDInput'];
         $term       = $_POST['termIDInput'];
         $timeslot   = $_POST['timeSlotInput'];
         $room       = $_POST['roomIDInput'];
         $faculty    = $_POST['facultyIDInput'];
         $sectionNum = $_POST['sectionNumInput'];
         
        // $sqler ="SELECT buildingID FROM `Room` WHERE `roomID`= 1";

        // if($building =   mysqli_query($dataBase, $sqler)){ echo "Building was found"; }
        // else { echo "Error: " . $sqler . "<br>" . mysqli_error($dataBase); }
               
         //$row = mysqli_fetch_assoc($building);
               
         $sql = "INSERT INTO `Section`(`courseID`, `sectionNum`, `timeslotID`, `termID`, `roomID`, `facultyID`)
                 VALUES ( '$course', '$sectionNum', '$timeslot', '$term', '$room' , '$faculty');";

         if (mysqli_query($dataBase, $sql)) { echo "New record created successfully"; }
         else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
      }
   }

   function getCorrectUserType( $formType ){
<<<<<<< HEAD
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
||||||| merged common ancestors
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
=======
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
>>>>>>> admin
   }
?>


<html>
   
   <head>
<<<<<<< HEAD
     <link rel="stylesheet" type="text/css" href="css/admin.css">
     <script src="javascript/admin.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
||||||| merged common ancestors
	  <link rel="stylesheet" type="text/css" href="css/admin.css">
	  <script src="javascript/admin.js"></script>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
=======
     <link rel="stylesheet" type="text/css" href="css/admin.css">
     <script src="javascript/admin.js" type="text/javascript"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
>>>>>>> admin
      <title>Admin Page</title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $login_session; ?></h1> 

<<<<<<< HEAD
      <ul>
        <li><a class="active" href="Admin.php">Home</a></li>
||||||| merged common ancestors
     	<ul>
		  <li><a class="active" href="Admin.php">Home</a></li>
=======
      <ul>
        <li><a class="active" href="Admin.php">Home</a></li>

        <!-- <li class="dropdown">
          <a href="#" class="dropbtn">Menu</a>
          <div class="dropdown-content">
           <a href=# onclick="javascript:generateNewUserForm()">Add New User</a>
           <a href=# onclick="createCourse();">Add New Course</a>
           <a href=# onclick="createSection();">Add New Section</a>
          </div>
        </li> -->

        <li><a class = "active" href = "Logout.php">Sign Out</a></li>
      </ul>

      <button class="accordion">User</button> 
      <div class="panel">
         <!-- <button class="button" onclick="move()" id="newUserButton">Add New User</button> -->

        <form method="post" action=" " id="newUserForm">
            <input type="text" name="firstNameInput" placeholder="First Name" required="true"><br>
            <input type="text" name="lastNameInput" placeholder="Last Name" required="true"><br>
            <input type="text" name="emailInput" placeholder="Email Address" required="true"><br>
            <input type="text" placeholder="Phone Number" name="phoneInput"><br>
            <input type="text" name="password1Input" placeholder="Password" required="true"><br>
            <input type="text" name="password2Input" placeholder="Confirm Password" required="true"><br>

            <select name="userType" required="true" onchange="unhideDepartmentList()" id="selectTypeOfUser">
               <option selected="selected">Type of User</option>
               <option value="0">Full Time Faculty</option>
               <option value="1">Part Time Faculty</option>
               <option value="2">Full Time Student</option>
               <option value="3">Part Time Student</option>
               <option value="4">Administrator</option>
               <option value="5">Research Office</option>
            </select>

            <select id = 'departments' style='display:none;' name='departmentID'>
               <option selected="selected">Choose A Department</option>
               <?
                  $sql = "SELECT * FROM Department";
                  $result = mysqli_query($dataBase, $sql);

                  while ($row = mysqli_fetch_array($result)) { $rows[] = $row; }
                  foreach ($rows as $row) { 
                     print "<option value='" . $row['departmentID'] . "'>" . $row['deptName'] . "</option>";
                  }
               ?>
            </select>

            <input type="hidden" value="0" name="hiddenButton" id="hiddenButton">
            <input type="submit" value="Submit" id="submitButton">
         </form>
      </div>

      <button class="accordion">Add New Course</button>
      <div class="panel">
        <form method="post" action=" " id="createCourseForm">
            <select id = 'departments' name='departmentID'>
               <option selected="selected">Choose A Department</option>
               <?
                  $sql = "SELECT * FROM Department";
                  $result = mysqli_query($dataBase, $sql);

                  while ($row = mysqli_fetch_array($result)) { $rows[] = $row; }
                  foreach ($rows as $row) { 
                     print "<option value='" . $row['departmentID'] . "'>" . $row['deptName'] . "</option>";
                  }
               ?>
            </select>

            <input type="text" name="creditHoursInput" placeholder="Credit Hours" required="true"><br>
            <input type="text" name="courseNameInput" placeholder="Course Name" required="true"><br>
            <input type="text" name="textbookInput" placeholder="Textbook"><br>
            <input type="textarea" name="descriptionInput" placeholder="Description" required="true"><br>
            <input type="text" name="courseCodeInput" placeholder="Course Code" required="true"><br>

            <select id='prerequisite1' name='prerequisite1' style='display:none;'>
               <option selected="selected">Prerequisite One</option>
               <?
                  $sql = "SELECT courseID, courseName FROM Course";
                  $result = mysqli_query($dataBase, $sql);

                  while ($row = mysqli_fetch_array($result)) { $rows[] = $row; }
                  foreach ($rows as $row) { 
                     print "<option value='" . $row['courseID'] . "'>" . $row['courseName'] . "</option>";
                  }
               ?>
            </select>

            <select id='prerequisite2' name='prerequisite2' style='display:none;'>
               <option selected="selected">Prerequisite Two</option>
               <?
                  $sql = "SELECT courseID, courseName FROM Course";
                  $result = mysqli_query($dataBase, $sql);

                  while ($row = mysqli_fetch_array($result)) { $rows[] = $row; }
                  foreach ($rows as $row) { 
                     print "<option value='" . $row['courseID'] . "'>" . $row['courseName'] . "</option>";
                  }
               ?>
            </select>
>>>>>>> admin

<<<<<<< HEAD
        <li class="dropdown">
          <a href="#" class="dropbtn">Menu</a>
          <div class="dropdown-content">
           <a href=# onclick="javascript:generateNewUserForm()">Add New User</a>
           <a href=# onclick="javascript:createCourse()">Add New Course</a>
           <a href=# onclick="javascript:createSection()">Add New Section</a>
          </div>
        </li>
||||||| merged common ancestors
		  <li class="dropdown">
		    <a href="#" class="dropbtn">Menu</a>
		    <div class="dropdown-content">
			  <a href=# onclick="javascript:generateNewUserForm()">Add New User</a>
		    </div>
		  </li>
=======
            <select id='prerequisite3' name='prerequisite3' style='display:none;'>
               <option selected="selected">Prerequisite Three</option>
               <?
                  $sql = "SELECT courseID, courseName FROM Course";
                  $result = mysqli_query($dataBase, $sql);

                  while ($row = mysqli_fetch_array($result)) { $rows[] = $row; }
                  foreach ($rows as $row) { 
                     print "<option value='" . $row['courseID'] . "'>" . $row['courseName'] . "</option>";
                  }
               ?>
            </select>
            

            <input type="button" value="Add a Prerequisite" onClick="addPrerequisite('appendToMe');" id="prerequisiteButton">

            <input type="hidden" value="1" name="hiddenButton" id="hiddenButton">
            <input type="submit" value="Submit" id="submitButton">
         </form>
      </div>

      <button class="accordion">Add New Section</button>
      <div class="panel">
        <form method="post" action=" " id="createSectionForm">
            <label id="courseIDLabel" class="formLabel">Course ID 
               <input type="text" name="courseIDInput" required="true"><br>
            </label>

            <label id="sectionNumLabel" class="formLabel">Section Num 
               <input type="text" name="sectionNumInput" required="true"><br>
            </label>

            <label id="termIDLabel" class="formLabel">Term 
               <input type="text" name="termIDInput" required="true"><br>
            </label>

            <label id="timeSlotLabel" class="formLabel">Timeslot 
               <input type="text" name="timeSlotInput" required="true"><br>
            </label>

            <label id="roomIDLabel" class="formLabel">Room ID 
               <input type="text" name="roomIDInput" required="true"><br>
            </label>

            <label id="facultyIDLabel" class="formLabel">Faculty ID 
               <input type="text" name="facultyIDInput" required="true"><br>
            </label>

            <input type="hidden" value="2" name="hiddenButton" id="hiddenButton">
            <input type="submit" value="Submit" id="submitButton">
         </form>
      </div>

      <script>
         var acc = document.getElementsByClassName("accordion");
         var i;

         for (i = 0; i < acc.length; i++) {
             acc[i].onclick = function(){
                 this.classList.toggle("active");
                 this.nextElementSibling.classList.toggle("show");
           }
         }
      </script>
>>>>>>> admin

<<<<<<< HEAD
        <li><a class = "active" href = "Logout.php">Sign Out</a></li>
      </ul>
      
      <div id="menuSelect"></div>
||||||| merged common ancestors
		  <li><a class = "active" href = "Logout.php">Sign Out</a></li>
		</ul>
      
      <div id="menuSelect"></div>
=======
>>>>>>> admin
      <div id="success">
<<<<<<< HEAD
            <?php
               echo $typeOfUser;
            ?>
||||||| merged common ancestors
      		<?php
      			echo $typeOfUser;
      		?>
=======
            <?php
               echo $typeOfUser;
            ?>
      </div>

      <div>
         <?php
            echo $id;
         ?>
>>>>>>> admin
      </div>

   </body>
   
</html>