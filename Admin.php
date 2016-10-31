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
         $course     = $_POST['courseID'];
         $term       = $_POST['termID'];
         $timeslot   = $_POST['timeSlotID'];
         $room       = $_POST['roomID'];
         $faculty    = $_POST['facultyID'];
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
      
      if($_POST['hiddenButton'] == 3){
         $course2ID  = $_POST['course2ID'];
         $department2  = $_POST['department2ID'];
         $creditHours2 = $_POST['creditHours2Input'];
         $courseName2  = $_POST['courseName2Input'];
         $textbook2    = $_POST['textbook2Input'];
         $description2 = $_POST['description2Input'];
         $courseCode2  = $_POST['courseCode2Input'];

         
        
               
         $sql = "UPDATE `Course` SET `departmentID` = '$department2', `creditHours`='$creditHours2', `courseName`='$courseName2', `description`='$description2', `textBook`='$textbook2',`courseCode`='$courseCode2'
                 WHERE `courseID` = '$course2ID';";

         if (mysqli_query($dataBase, $sql)) { echo "New record created successfully"; }
         else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
      }
      
       if($_POST['hiddenButton'] == 4){
         $course3ID  = $_POST['course3ID'];
         
         
        
               
         $sql = "DELETE FROM `Course` WHERE `courseID` = '$course3ID';";

         if (mysqli_query($dataBase, $sql)) { echo "New record created successfully"; }
         else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
      }
      
       if($_POST['hiddenButton'] == 5){
         $section2    = $_POST['section2ID'];
         $course2     = $_POST['course5ID'];
         $term2       = $_POST['term2ID'];
         $timeslot2   = $_POST['timeSlot2ID'];
         $room2       = $_POST['room2ID'];
         $faculty2    = $_POST['faculty2ID'];
         $sectionNum2 = $_POST['sectionNum2Input'];
         
     
               
         $section2Sql = "UPDATE `Section` SET `courseID` = '$course2'  , `sectionNum` = '$sectionNum2' , `timeslotID` = '$timeslot2' , `termID`= '$term2', `roomID` ='$room2', `facultyID` = '$faculty2'
                 WHERE `sectionID` = '$section2' ;";

         if (mysqli_query($dataBase, $section2Sql)) { echo "New record created successfully"; }
         else { echo "Error: " . $section2Sql . "<br>" . mysqli_error($dataBase); }
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

      <button class="accordion">Course</button>
      <div class="panel">
         <div class="buttonBlock" id="buttonBlock2">
            <button class="button" onclick="toggleElement( 'buttonBlock2', 'newCourseDiv' );" id="addNewCourseButton">Add New Course</button>
            <button class="button" onclick="toggleElement( 'buttonBlock2', 'editCourseDiv' );" id="editCourseButton">Edit Course</button>
            <button class="button" onclick="toggleElement( 'buttonBlock2', 'deleteCourseDiv' );" id="deleteCourseButton">Delete Course</button>
         </div>
      <div id ="newCourseDiv" style="display:none">
        <form method="post" action=" " id="createCourseForm">
            <select id = 'departments' name='departmentID'>
               <option selected="selected">Choose A Department</option>
               <?
                  $depart1Sql = "SELECT * FROM Department";
                  $depart1Result = mysqli_query($dataBase, $depart1Sql);

                  while ($depart1Row = mysqli_fetch_array($depart1Result)) { $depart1Rows[] = $depart1Row; }
                  foreach ($depart1Rows as $depart1Row) { 
                     print "<option value='" . $depart1Row['departmentID'] . "'>" . $depart1Row['deptName'] . "</option>";
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
                  $pre1Sql = "SELECT courseID, courseName FROM Course";
                  $pre1Result = mysqli_query($dataBase, $pre1Sql);

                  while ($pre1Row = mysqli_fetch_array($pre1Result)) { $pre1Rows[] = $pre1Row; }
                  foreach ($pre1Rows as $pre1Row) { 
                     print "<option value='" . $pre1Row['courseID'] . "'>" . $pre1Row['courseName'] . "</option>";
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
            

            <input type="button" value="Add a Prerequisite" onClick="addPrerequisite('appendToMe');" id="prerequisiteButton" style="display:display">

            <input type="hidden" value="1" name="hiddenButton" id="hiddenButton">
            <input type="submit" value="Submit" id="submitButton">
         </form>
         <button id="doneButton" class="button" onclick="toggleElement( 'newCourseDiv', 'buttonBlock2' );">Done</button>
         </div>
          <div id ="editCourseDiv" style="display:none">
         <form method="post" action=" " id="editClassForm">
          <select id = 'course2ID'  name='course2ID'>
               <option selected="selected">Choose A Course</option>
               <?
                  $course2Sql = "SELECT * FROM Course";
                  $course2Result = mysqli_query($dataBase, $course2Sql);
                  $courseTestRow =  array();

                  while ($course2Row = mysqli_fetch_array($course2Result)) { $course2Rows[] = $course2Row; }
                  foreach ($course2Rows as $course2Row) { 
                     
                     print "<option value='" . $course2Row['courseID'] . "'>" . $course2Row['courseName'] . "</option>";
                     $courseTestRow[] = $course2Row;
                     
                 
                  }
                  $courseJsonArray =json_encode($courseTestRow);

               ?>
            </select><br>
            
                   
            
            
             <select id = 'department2ID' name='department2ID'>
               <option selected="selected">Choose A Department</option>
               <?
                  $depart2Sql = "SELECT * FROM Department";
                  $depart2Result = mysqli_query($dataBase, $depart2Sql);

                  while ($depart2Row = mysqli_fetch_array($depart2Result)) { $depart2Rows[] = $depart2Row; }
                  foreach ($depart2Rows as $depart2Row) { 
                     print "<option value='" . $depart2Row['departmentID'] . "'>" . $depart2Row['deptName'] . "</option>";
                  }
               ?>
            </select><br>

            
             
             <input type="text" name="creditHours2Input" placeholder="Credit Hours" required="true"><br>
            <input type="text" name="courseName2Input" placeholder="Course Name" required="true"><br>
            <input type="text" name="textbook2Input" placeholder="Textbook"><br>
            <input type="textarea" name="description2Input" placeholder="Description" required="true"><br>
            <input type="text" name="courseCode2Input" placeholder="Course Code" required="true"><br>
            <input type="hidden" value="3" name="hiddenButton" id="hiddenButton">
            <input type="submit" value="Submit" id="submitButton">
         </form>
         <button id="doneButton" class="button" onclick="toggleElement( 'editCourseDiv', 'buttonBlock2' );">Done</button>
         </div>
          <div id ="deleteCourseDiv" style="display:none">
         <form method="post" action=" " id="deleteClassForm">
          <select id = 'course3ID' name='course3ID'>
               <option selected="selected">Choose A Course to delete</option>
               <?
                  $course3Sql = "SELECT * FROM Course";
                  $course3Result = mysqli_query($dataBase, $course3Sql);
                  

                  while ($course3Row = mysqli_fetch_array($course3Result)) { $course3Rows[] = $course3Row; }
                  foreach ($course3Rows as $course3Row) { 
                     
                     print "<option value='" . $course3Row['courseID'] . "'>" . $course3Row['courseName'] . "</option>";
                     

                  }
                 

               ?>
            </select><br>
            
            <input type="submit" value="Submit" id="submitButton">       
            <input type="hidden" value="4" name="hiddenButton" id="hiddenButton">
    
         </form>
         <button id="doneButton" class="button" onclick="toggleElement( 'deleteCourseDiv', 'buttonBlock2' );">Done</button>
      </div>
      
</div>
      <button class="accordion">Section</button>
      <div class="panel">
        <form method="post" action=" " id="createSectionForm">
            <select id = 'courseID' name='courseID'>
               <option selected="selected">Choose A Course</option>
               <?
                  $courseSql = "SELECT * FROM Course";
                  $courseResult = mysqli_query($dataBase, $courseSql);

                  while ($courseRow = mysqli_fetch_array($courseResult)) { $courseRows[] = $courseRow; }
                  foreach ($courseRows as $courseRow) { 
                     print "<option value='" . $courseRow['courseID'] . "'>" . $courseRow['courseName'] . "</option>";
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
            
              <select id = 'facultyID' name='facultyID'>
                       <option selected="selected">Choose A Faculty</option>
                  <?
                      $facultySql = "SELECT * FROM Faculty INNER JOIN User ON Faculty.facultyID=User.userID";
                  $facultyResult = mysqli_query($dataBase, $facultySql);

                  while ($facultyRow = mysqli_fetch_array($facultyResult)) { $facultyRows[] = $facultyRow; }
                  foreach ($facultyRows as $facultyRow) { 
                     print "<option value='" . $facultyRow['facultyID'] . "'>" ."Faculty ID: ". $facultyRow['facultyID'] . " " . $facultyRow['firstName'] . " ". $facultyRow['lastName']  ."</option>";
                  }
               ?>
            </select>
        
           

            <input type="hidden" value="2" name="hiddenButton" id="hiddenButton">
            <input type="submit" value="Submit" id="submitButton">
         </form>
      </div>
      
      <form method="post" action=" " id="EditSectionForm">
            <select id = 'section2ID' name='section2ID'>
               <option selected="selected">Choose A Section</option>
               <?
                  $sectionSql = "SELECT * FROM Section INNER JOIN Course ON Section.courseID=Course.courseID";
                  $sectionResult = mysqli_query($dataBase, $sectionSql);

                  while ($sectionRow = mysqli_fetch_array($sectionResult)) { $sectionRows[] = $sectionRow; }
                  foreach ($sectionRows as $sectionRow) { 
                     print "<option value='" . $sectionRow['sectionID'] . "'>" . $sectionRow['courseName'] . " ". $sectionRow['sectionNum'] ."</option>";
                  }
               ?>
            </select>
            
            <select id = 'course5ID' name='course5ID'>
               <option selected="selected">Choose A Course</option>
               <?
                  $course5Sql = "SELECT * FROM Course";
                  $course5Result = mysqli_query($dataBase, $course5Sql);

                  while ($course5Row = mysqli_fetch_array($course5Result)) { $course5Rows[] = $course5Row; }
                  foreach ($course5Rows as $course5Row) { 
                     print "<option value='" . $course5Row['courseID'] . "'>" . $course5Row['courseName'] . "</option>";
                  }
               ?>
            </select>
                <input type="text" name="sectionNum2Input" placeholder="Section Number" required="true"><br>
                   
               <select id = 'term2ID' name='term2ID'>
                       <option selected="selected">Choose A Term</option>
                  <?
                      $term2Sql = "SELECT * FROM Term";
                  $term2Result = mysqli_query($dataBase, $term2Sql);

                  while ($term2Row = mysqli_fetch_array($term2Result)) { $term2Rows[] = $term2Row; }
                  foreach ($term2Rows as $row2Term) { 
                     print "<option value='" . $row2Term['termID'] . "'>" . $row2Term['semester'] . " " . $row2Term['year'] . "</option>";
                  }
               ?>
            </select>
                  
            
             <select id = 'timeSlot2ID' name='timeSlot2ID'>
                       <option selected="selected">Choose A Timeslot </option>
                  <?
                      $timeSlot2sql = "SELECT * FROM Timeslot INNER JOIN Time ON Timeslot.timeID=Time.timeID INNER JOIN Day ON Timeslot.dayID=Day.DayID";
                  $timeSlot2result = mysqli_query($dataBase, $timeSlot2sql);
                  
                  
                  while ($timeSlot2row = mysqli_fetch_array($timeSlot2result)) { $timeSlot2rows[] = $timeSlot2row; }
                  foreach ($timeSlot2rows as $timeSlot2row) { 
                     print "<option value='" . $timeSlot2row['timeslotID'] . "'>" . $timeSlot2row['timeStart'] . "-" . $timeSlot2row['timeEnd'] . " " . $timeSlot2row['days'] ."</option>";
                  }
               ?>
            </select><br>

             <select id = 'room2ID' name='room2ID'>
                       <option selected="selected">Choose A Room</option>
                  <?
                      $room2Sql = "SELECT * FROM Room INNER JOIN Building ON Room.buildingID=Building.buildingID";
                  $room2Result = mysqli_query($dataBase, $room2Sql);

                  while ($room2Row = mysqli_fetch_array($room2Result)) { $room2Rows[] = $room2Row; }
                  foreach ($room2Rows as $room2Row) { 
                     print "<option value='" . $room2Row['roomID'] . "'>" . $room2Row['roomNum'] . " " . $room2Row['buildingName'] . "</option>";
                  }
               ?>
            </select><br>
            
              <select id = 'faculty2ID' name='faculty2ID'>
                       <option selected="selected">Choose A Faculty</option>
                  <?
                      $faculty2Sql = "SELECT * FROM Faculty INNER JOIN User ON Faculty.facultyID=User.userID";
                  $faculty2Result = mysqli_query($dataBase, $facultySql);

                  while ($faculty2Row = mysqli_fetch_array($faculty2Result)) { $faculty2Rows[] = $faculty2Row; }
                  foreach ($faculty2Rows as $faculty2Row) { 
                     print "<option value='" . $faculty2Row['facultyID'] . "'>" ."Faculty ID: ". $faculty2Row['facultyID'] . " " . $faculty2Row['firstName'] . " ". $faculty2Row['lastName']  ."</option>";
                  }
               ?>
            </select><br>
        
           

            <input type="hidden" value="5" name="hiddenButton" id="hiddenButton">
            <input type="submit" value="Submit" id="submitButton">
         </form>

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