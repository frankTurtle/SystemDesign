<?php
   include('Session.php');
   include("Config.php");
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
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
      }

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
               
         $sql = "INSERT INTO `Section`(`courseID`, `sectionNum`, `timeslotID`, `termID`, `roomID`, `facultyID`)
                 VALUES ( '$course', '$sectionNum', '$timeslot', '$term', '$room' , '$faculty');";

         if (mysqli_query($dataBase, $sql)) { echo "New record created successfully"; }
         else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
      }

      if($_POST['hiddenButton'] == 5){
         echo "here";
      }
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

   function searchUser(){
      $formValuesDictionary = [
         "firstName"   => ( isset($_POST['firstNameInput']) ? $_POST['firstNameInput'] : NULL ),
         "lastName"    => ( isset($_POST['lastNameInput']) ? $_POST['lastNameInput'] : NULL ),
         "email"       => ( isset($_POST['emailInput']) ? $_POST['emailInput'] : NULL ),
         "phoneNumber" => ( isset($_POST['phoneInput']) ? $_POST['phoneInput'] : NULL ),
         "typeOfUser"  => ( ($_POST['userType'] != "Type of User") ? getCorrectUserType($_POST['userType']) : NULL )
      ];

      $finalSql;
      $searchSql = "SELECT * FROM User ";

      foreach ($formValuesDictionary as $key => $value) {
         if( $value != NULL ){
               if( strpos($searchSql, 'WHERE') === false ){ $searchSql .= "WHERE "; }
               $searchSql .= "'$key' LIKE '%" . $value . "%' AND ";
         }
      }

      $finalSql = ( strpos($searchSql, 'AND') == true ) ? substr($searchSql, 0, -4) : $searchSql;
   }
?>


<html>
   
   <head>
     <link rel="stylesheet" type="text/css" href="css/admin.css">
     <script src="javascript/admin.js" type="text/javascript"></script>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <title>Admin Page</title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $login_session; ?></h1> 

      <ul>
        <li><a class="active" href="Search.php">Home</a></li>

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
         <div class="buttonBlock" id="buttonBlock">
            <button class="button" onclick="toggleElement( 'buttonBlock', 'newUserDiv' );" id="addNewUserButton">Add New User</button>
            <button class="button" onclick="toggleElement( 'buttonBlock', 'searchUserDiv' );" id="searchUserButton">Search User</button>
            <button class="button" onclick="toggleElement( 'buttonBlock', 'newUserForm', 'doneButton' );" id="editUserButton">Edit User</button>
         </div>

         <div id="newUserDiv" style="display:none">
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

            <button id="doneButton" class="button" onclick="toggleElement( 'newUserDiv', 'buttonBlock' );">Done</button>
         </div>
        
         <div id="searchUserDiv" style="display:none">
            <form method="post" action="SearchUser.php" id="searchUserForm">
               <input name="firstNameInput" placeholder="First Name" id="firstName"><br>
               <input type="text" name="lastNameInput" placeholder="Last Name"><br>
               <input type="text" name="emailInput" placeholder="Email Address"><br>
               <input type="text" placeholder="Phone Number" name="phoneInput"><br>

               <select name="userType" required="true" id="selectTypeOfUser">
                  <option selected="selected">Type of User</option>
                  <option value="0">Full Time Faculty</option>
                  <option value="1">Part Time Faculty</option>
                  <option value="2">Full Time Student</option>
                  <option value="3">Part Time Student</option>
                  <option value="4">Administrator</option>
                  <option value="5">Research Office</option>
               </select>

               <input type="hidden" value="5" name="hiddenButton" id="hiddenButton">
               <input type="submit" value="Search" id="submitButton">
            </form>

            <button id="doneButton" class="button" onclick="toggleElement( 'searchUserDiv', 'buttonBlock' );">Done</button>
         </div>

         
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
            <select id = 'courseID' name='courseID'>
               <option selected="selected">Choose A Course</option>
               <?
                  $sql = "SELECT * FROM Course";
                  $result = mysqli_query($dataBase, $sql);

                  while ($row = mysqli_fetch_array($result)) { $rows[] = $row; }
                  foreach ($rows as $row) { 
                     print "<option value='" . $row['courseID'] . "'>" . $row['courseName'] . "</option>";
                  }
               ?>
            </select>
                <input type="text" name="sectionNumInput" placeholder="Section Number" required="true"><br>
           
        
                   <select id = 'termID' name='termID'>
                       <option selected="selected">Choose A Term</option>
                  <?
                      $termSql = "SELECT * FROM Term";
                  $termResult = mysqli_query($dataBase, $termSql);

                  while ($termRow = mysqli_fetch_array($termResult)) { $termRows[] = $termRow; }
                  foreach ($termRows as $rowTerm) { 
                     print "<option value='" . $rowTerm['termID'] . "'>" . $rowTerm['semester'] . " " . $rowTerm['year'] . "</option>";
                  }
               ?>
            </select>
            
             <select id = 'timeSlotID' name='timeSlotID'>
                       <option selected="selected">Choose A Timeslot </option>
                  <?
                      $timeSlotsql = "SELECT * FROM Timeslot INNER JOIN Time ON Timeslot.timeID=Time.timeID INNER JOIN Day ON Timeslot.dayID=Day.DayID";
                  $timeSlotresult = mysqli_query($dataBase, $timeSlotsql);
                  
                  
                  while ($timeSlotrow = mysqli_fetch_array($timeSlotresult)) { $timeSlotrows[] = $timeSlotrow; }
                  foreach ($timeSlotrows as $timeSlotrow) { 
                     print "<option value='" . $timeSlotrow['timeslotID'] . "'>" . $timeSlotrow['timeStart'] . "-" . $timeSlotrow['timeEnd'] . " " . $timeSlotrow['days'] ."</option>";
                  }
               ?>
            </select>

             <select id = 'roomID' name='roomID'>
                       <option selected="selected">Choose A Room</option>
                  <?
                      $roomSql = "SELECT * FROM Room INNER JOIN Building ON Room.buildingID=Building.buildingID";
                  $roomResult = mysqli_query($dataBase, $roomSql);

                  while ($roomRow = mysqli_fetch_array($roomResult)) { $roomRows[] = $roomRow; }
                  foreach ($roomRows as $roomRow) { 
                     print "<option value='" . $roomRow['roomID'] . "'>" . $roomRow['roomNum'] . " " . $roomRow['buildingName'] . "</option>";
                  }
               ?>
            </select>
            
        
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

      <div id="success">
            <?php
               echo $typeOfUser;
            ?>
      </div>

      <div>
         <?php
            echo $id;
         ?>
      </div>

   </body>
   
</html>