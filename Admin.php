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

         if (mysqli_query($dataBase, $sql)) { echo "record updated successfully"; }
         else { echo "Error: " . $sql . "<br>" . mysqli_error($dataBase); }
      }
      
       if($_POST['hiddenButton'] == 4){
         $course3ID  = $_POST['course3ID'];
         
         
        
               
         $sql = "DELETE FROM `Course` WHERE `courseID` = '$course3ID';";

         if (mysqli_query($dataBase, $sql)) { echo "record deleted successfully"; }
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

         if (mysqli_query($dataBase, $section2Sql)) { echo "record Edited successfully"; }
         else { echo "Error: " . $section2Sql . "<br>" . mysqli_error($dataBase); }
      }
      
      if($_POST['hiddenButton'] == 6){
         $section3ID  = $_POST['section3ID'];
         
         
        
               
         $section3sql = "DELETE FROM `Section` WHERE `sectionID` = '$section3ID';";

         if (mysqli_query($dataBase, $section3sql)) { echo "record Deleted successfully"; }
         else { echo "Error: " . $section3sql . "<br>" . mysqli_error($dataBase); }
      }
      
      if($_POST['hiddenButton'] == 7){
         $student  = $_POST['studentID'];
         $faculty3 = $_POST['faculty3ID'];
         $date     = $_POST['studAdvDateButton'];
         $convertedDate = date("Y-m-d", strtotime($_POST['studAdvDateButton']));

 
         
         $advisorSql = "INSERT INTO `StudentAdviser`(`studentID`, `facultyID`, `dateAssigned`)
                 VALUES ( '$student', '$faculty3' , '$convertedDate');";
         
          if (mysqli_query($dataBase, $advisorSql)) { echo "New record created successfully"; }
         else { echo "Error: " . $advisorSql . "<br>" . mysqli_error($dataBase); }
         
      
      }
      
      if($_POST['hiddenButton'] == 8){
         $student2  = $_POST['studAdvID'];
         $faculty4 = $_POST['faculty4ID'];
         $date2     = $_POST['studAdvDate2Button'];
         $date2 = date('Y-m-d', strtotime($date2));
         
         $advisor2Sql = "UPDATE `StudentAdviser` SET `facultyID` = '$faculty4' , `dateAssigned` = '$date2' 
                 WHERE `studentID` = '$student2' ;";
         
          if (mysqli_query($dataBase, $advisor2Sql)) { echo "record updated successfully"; }
         else { echo "Error: " . $advisor2Sql . "<br>" . mysqli_error($dataBase); }
         
      
      }
      
      if($_POST['hiddenButton'] == 9){
         $student3  = $_POST['studAdv2ID'];
        
         
         $advisor3Sql = "DELETE FROM `StudentAdviser` WHERE `studentID` = '$student3';";
         
          if (mysqli_query($dataBase, $advisor3Sql)) { echo "record deleted successfully"; }
         else { echo "Error: " . $advisor3Sql . "<br>" . mysqli_error($dataBase); }
         
      
      }
      
      
      if($_POST['hiddenButton'] ==10){
         $buildID  = $_POST['buildID'];
         $roomType = $_POST['roomType'];
         $roomNum = $_POST['roomNumInput'];
         $roomCapacity =$_POST['roomCapacityInput'];
         
        
         
         $addRoomSql = "INSERT INTO `Room`(`buildingID`, `roomNum`, `roomType`, `capacity` )
         VALUES ('$buildID', '$roomNum' , '$roomType' , '$roomCapacity');";
         
          if (mysqli_query($dataBase, $addRoomSql)) {
          if( $roomType == 0 ){
          $addRoomSql = "INSERT INTO `Lab`(`labID`, `buildingID`)
         VALUES (LAST_INSERT_ID() ,'$buildID');";
                 
                 if (mysqli_query($dataBase, $addRoomSql)) { echo "record created successfully"; }
         else { echo "Error: " . $addRoomSql . "<br>" . mysqli_error($dataBase); }
          }
          if( $roomType == 1 ){
          $addRoomSql = "INSERT INTO `Classroom`(`classroomID`, `buildingID`)
         VALUES (LAST_INSERT_ID() ,'$buildID');";
         if (mysqli_query($dataBase, $addRoomSql)) { echo "record created successfully"; }
         else { echo "Error: " . $addRoomSql . "<br>" . mysqli_error($dataBase); }
         
          }
          if( $roomType == 2 ){
          $addRoomSql = "INSERT INTO `Office`(`officeID`, `buildingID`)
         VALUES (LAST_INSERT_ID() ,'$buildID');";
         if (mysqli_query($dataBase, $addRoomSql)) { echo "record created successfully"; }
         else { echo "Error: " . $addRoomSql . "<br>" . mysqli_error($dataBase); }
          }
          }
         else { echo "Error: " . $addRoomSql . "<br>" . mysqli_error($dataBase); }
         
         
         
      
      }
      if($_POST['hiddenButton'] ==11){
         $editRoomID =  $_POST['room3ID'];
         $buildID  = $_POST['build2ID'];
         $roomType2 = $_POST['roomType2'];
         $roomNum2 = $_POST['roomNum2Input'];
         $roomCapacity2 =$_POST['roomCapacity2Input'];
         
          $editRoomSql = "UPDATE `Room` SET `buildingID` = '$buildID', `roomType`='$roomType2',`roomNum` = '$roomNum2',`capacity` = '$roomCapacity2' 
          WHERE `roomID` = '$editRoomID';";
         
          if (mysqli_query($dataBase, $editRoomSql)) { echo "record deleted successfully"; }
         else { echo "Error: " . $editRoomSql . "<br>" . mysqli_error($dataBase); }
         
         }
         
         if($_POST['hiddenButton'] ==12){
         $deleteRoomID =  $_POST['room4ID'];
         
         $deleteRoomSql = "DELETE FROM `Room` WHERE `roomID` = '$deleteRoomID';";
         
          if (mysqli_query($dataBase, $deleteRoomSql)) { echo "record deleted successfully"; }
         else { echo "Error: " . $deleteRoomSql . "<br>" . mysqli_error($dataBase); }
         }
         
         if($_POST['hiddenButton']==13){
         $addBuildName = $_POST['buildNameInput'];
         
         $addBuildingSql = "INSERT INTO `Building` (`buildingName`)
         VALUES ('$addBuildName');";
         
         if(mysqli_query($dataBase,$addBuildingSql)) { echo "Record created successfully"; }
         else { echo "Error: " . $addBuildingSql . "<br>" . mysqli_error($dataBase);}
                
         }
         if($_POST['hiddenButton'] == 14){
         $editBuildId      = $_POST['editBuilding'];
         $editBuildingName = $_POST['buildName2Input'];
         
         $editBuildingSql = "UPDATE `Building` SET `buildingName` = '$editBuildingName'
         WHERE `buildingID` = '$editBuildID';";
         
         if(mysqli_query($dataBase, $editBuildingSql)) { echo "Record updated successfully"; }
         else {echo "Error: " . $editBuildingSql . "<br>" . mysqli_error($dataBase);}
         
         }
         
         if($_POST['hiddenButton'] == 15){
         $deleteBuildID    = $_Post['deleteBuilding'];
         
         $deleteBuildingSql = "DELETE FROM `Building` WHERE `buildingID` = '$deleteBuildID' ;"; 
         
         if(mysqli_query($dataBase, $deleteBuildingSql)) { echo "Record deleted successfully"; }
         else {echo "Error: " . $deleteBuildingSql . "<br>" . mysqli_error($dataBase);}
         
         }
             if($_POST['hiddenButton']==16){
         $addStudMajor = $_POST['newStudentMajSel'];
         $addMajor     = $_POST['newMajorSel'];
         $addDate      = $_POST['newMajMinButton'];
         $addDate = date('Y-m-d', strtotime($addDate));
         
         
         $addStudMajorSql = "INSERT INTO `StudentMajor` (`studentID`, `majorID`,`dateDeclared`)
         VALUES ('$addStudMajor','$addMajor','$addDate');";
         
         if(mysqli_query($dataBase, $addStudMajorSql)) { echo "Record created successfully"; }
         else { echo "Error: " . $addStudMajorSql . "<br>" . mysqli_error($dataBase);}
                
         }
         
         if($_POST['hiddenButton']==17){
         $editStudMajor = $_POST['editStudentMajSel'];
         $editMajor     = $_POST['editStudentMajSel'];
         $editDate      = $_POST['editMajDateButton'];
         $editDate = date('Y-m-d', strtotime($editDate));
         
         
         $editStudMajorSql = "UPDATE `StudentMajor` SET `majorID` = '$editMajor',`dateDeclared`='$editDate'
         WHERE `studentID` = '$editStudMajor';";
         
         if(mysqli_query($dataBase, $editStudMajorSql)) { echo "Record Updated successfully"; }
         else { echo "Error: " . $editStudMajorSql . "<br>" . mysqli_error($dataBase);}
                
         }
         
         if($_POST['hiddenButton']==18){
         $deleteStudMajor = $_POST['deleteStudentMajSel'];
     
         
         $deleteStudMajorSql = "DELETE FROM `StudentMajor` WHERE `studentID` = '$deleteStudMajor';";
         
         if(mysqli_query($dataBase, $deleteStudMajorSql)) { echo "Record created successfully"; }
         else { echo "Error: " . $deleteStudMajorSql . "<br>" . mysqli_error($dataBase);}
                
         }
              if($_POST['hiddenButton']==19){
         $addStudMinor = $_POST['newStudentMinSel'];
         $addMinor     = $_POST['newMinorSel'];
         $addDate      = $_POST['newMinButton'];
         $addDate = date('Y-m-d', strtotime($addDate));
         
         
         $addStudMinorSql = "INSERT INTO `StudentMinor` (`studentID`, `MinorID`,`dateDeclared`)
         VALUES ('$addStudMinor','$addMinor','$addDate');";
         
         if(mysqli_query($dataBase, $addStudMinorSql)) { echo "Record created successfully"; }
         else { echo "Error: " . $addStudMinorSql . "<br>" . mysqli_error($dataBase);}
                
         }
         
         if($_POST['hiddenButton']==20){
         $editStudMinor = $_POST['editStudentMinSel'];
         $editMinor     = $_POST['editMinorSel'];
         $editDate      = $_POST['editMinDateButton'];
         $editDate = date('Y-m-d', strtotime($editDate));
         
         
         $editStudMinorSql = "UPDATE `StudentMinor` SET `MinorID` = '$editMinor',`dateDeclared`='$editDate'
         WHERE `studentID` = '$editStudMinor';";
         
         if(mysqli_query($dataBase, $editStudMinorSql)) { echo "Record Updated successfully"; }
         else { echo "Error: " . $editStudMinorSql . "<br>" . mysqli_error($dataBase);}
                
         }
         
         if($_POST['hiddenButton']==21){
         $deleteStudMinor = $_POST['deleteStudentMinSel'];
     
         
         $deleteStudMinorSql = "DELETE FROM `StudentMinor` WHERE `studentID` = '$deleteStudMinor';";
         
         if(mysqli_query($dataBase, $deleteStudMinorSql)) { echo "Record created successfully"; }
         else { echo "Error: " . $deleteStudMinorSql . "<br>" . mysqli_error($dataBase);}
                
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
         <div class="buttonBlock" id="buttonBlock">
            <button class="button" onclick="toggleElement( 'buttonBlock', 'newUserDiv' );" id="addNewUserButton">New User</button>
            <button class="button" onclick="toggleElement( 'buttonBlock', 'searchUserDiv' );" id="searchUserButton">Search User</button>
            <button class="button" onclick="toggleElement( 'buttonBlock', 'searchUserDiv' );" id="editUserButton">Edit User</button>
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

      <button class="accordion">Course Catalog</button>
      <div class="panel">
         <div class="buttonBlock" id="buttonBlock2">
            <button class="button" onclick="toggleElement( 'buttonBlock2', 'newCourseDiv' );" id="addNewCourseButton">New Course</button>
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
                  $pre2sql = "SELECT courseID, courseName FROM Course";
                  $pre2result = mysqli_query($dataBase, $pre2sql);

                  while ($pre2row = mysqli_fetch_array($pre2result)) { $pre2rows[] = $pre2row; }
                  foreach ($pre2rows as $pre2row) { 
                     print "<option value='" . $pre2row['courseID'] . "'>" . $pre2row['courseName'] . "</option>";
                  }
               ?>
            </select>

            <select id='prerequisite3' name='prerequisite3' style='display:none;'>
               <option selected="selected">Prerequisite Three</option>
               <?
                  $pre3sql = "SELECT courseID, courseName FROM Course";
                  $pre3result = mysqli_query($dataBase, $pre3sql);

                  while ($pre3row = mysqli_fetch_array($pre3result)) { $pre3rows[] = $pre3row; }
                  foreach ($pre3rows as $pre3row) { 
                     print "<option value='" . $pre3row['courseID'] . "'>" . $pre3row['courseName'] . "</option>";
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
         <div class="buttonBlock" id="buttonBlock3">
            <button class="button" onclick="toggleElement( 'buttonBlock3', 'newSectionDiv' );" id="addNewSectionButton">New Section</button>
            <button class="button" onclick="toggleElement( 'buttonBlock3', 'editSectionDiv' );" id="editSectionButton">Edit Section</button>
            <button class="button" onclick="toggleElement( 'buttonBlock3', 'deleteSectionDiv' );" id="deleteSectionButton">Delete Section</button>
         </div>
         <div id ="newSectionDiv" style="display:none">
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
            </select><br>
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
            </select><br>
            
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
            </select><br>

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
            </select><br>
            
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
            </select><br>
        
           

            <input type="hidden" value="2" name="hiddenButton" id="hiddenButton">
            <input type="submit" value="Submit" id="submitButton">
         </form>
         <button id="doneButton" class="button" onclick="toggleElement( 'newSectionDiv', 'buttonBlock3' );">Done</button>
      </div>
      <div id ="editSectionDiv" style="display:none">
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
            </select><br>
            
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
            </select><br>
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
            </select><br>
                  
            
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
         <button id="doneButton" class="button" onclick="toggleElement( 'editSectionDiv', 'buttonBlock3' );">Done</button>
         </div>
         <div id ="deleteSectionDiv" style="display:none">
         <form method="post" action=" " id="deleteSectionForm">
            <select id = 'section3ID' name='section3ID'>
               <option selected="selected">Choose A Section</option>
               <?
                  $section2Sql = "SELECT * FROM Section INNER JOIN Course ON Section.courseID=Course.courseID";
                  $section2Result = mysqli_query($dataBase, $section2Sql);

                  while ($section2Row = mysqli_fetch_array($section2Result)) { $section2Rows[] = $section2Row; }
                  foreach ($section2Rows as $section2Row) { 
                     print "<option value='" . $section2Row['sectionID'] . "'>" . $section2Row['courseName'] . " ". $section2Row['sectionNum'] ."</option>";
                  }
               ?>
            </select><br>
            
             <input type="hidden" value="6" name="hiddenButton" id="hiddenButton">
            <input type="submit" value="Submit" id="submitButton">
         </form>
         <button id="doneButton" class="button" onclick="toggleElement( 'deleteSectionDiv', 'buttonBlock3' );">Done</button>
         </div>
         </div>
         
          <button class="accordion">Advisor</button>
      <div class="panel">
         <div class="buttonBlock" id="buttonBlock4">
            <button class="button" onclick="toggleElement( 'buttonBlock4', 'newStudentAdvisorDiv' );" id="addNewStudAdvButton">New Advisor</button>
            <button class="button" onclick="toggleElement( 'buttonBlock4', 'editStudentAdvisorDiv' );" id="editStudAdvButton">Edit Advisor</button>
            <button class="button" onclick="toggleElement( 'buttonBlock4', 'deleteStudentAdvisorDiv' );" id="deleteStudAdvButton">Delete Advisor</button>
         </div>
         <div id ="newStudentAdvisorDiv" style="display:none">
        <form method="post" action=" " id="createStudentAdvisorForm">
        
        
        <input type="hidden" value="7" name="hiddenButton" id="hiddenButton">
        <input type="date" value="" id="studAdvDateButton" name="studAdvDateButton"><br>
       
        <select id = 'studentID' name='studentID'>
               <option selected="selected">Choose A Student</option>
               <?
                  $studentSql = "SELECT * FROM Student INNER JOIN User ON Student.studentID = User.userID";
                  $studentResult = mysqli_query($dataBase, $studentSql);

                  while ($studentRow = mysqli_fetch_array($studentResult)) { $studentRows[] = $studentRow; }
                  foreach ($studentRows as $studentRow) { 
                     print "<option value='" . $studentRow['studentID'] . "'>". $studentRow['studentID']. " " . $studentRow['firstName'] ." ". $studentRow['lastName']  ."</option>";
                  }
               ?>
            </select><br>
            
            <select id = 'faculty3ID' name='faculty3ID'>
               <option selected="selected">Choose A Faculty</option>
               <?
                  $faculty3Sql = "SELECT * FROM Faculty INNER JOIN User ON Faculty.facultyID = User.userID";
                  $faculty3Result = mysqli_query($dataBase, $faculty3Sql);

                  while ($faculty3Row = mysqli_fetch_array($faculty3Result)) { $faculty3Rows[] = $faculty3Row; }
                  foreach ($faculty3Rows as $faculty3Row) { 
                     print "<option value='" . $faculty3Row['facultyID'] . "'>". $faculty3Row['facultyID']. " " . $faculty3Row['firstName'] ." ". $faculty3Row['lastName']  ."</option>";
                  }
               ?>
            </select><br>
            <input type="submit" value="Submit" id="submitButton">
            
            </form>
            <button id="doneButton" class="button" onclick="toggleElement( 'newStudentAdvisorDiv', 'buttonBlock4' );">Done</button>
         </div>
         
          <div id ="editStudentAdvisorDiv" style="display:none">
        <form method="post" action=" " id="editStudentAdvisorForm">
        
        
        <input type="hidden" value="8" name="hiddenButton" id="hiddenButton">
        <input type="date" value="" id="studAdvDate2Button"><br>
        
        <select id = 'studAdvID' name='studAdvID'>
               <option selected="selected">Choose A student Advisor</option>
               <?
                  $studentAdvSql = "SELECT * FROM StudentAdviser INNER JOIN User ON StudentAdviser.studentID = User.userID ";
                  $studentAdvResult = mysqli_query($dataBase, $studentAdvSql);

                  while ($studentAdvRow = mysqli_fetch_array($studentAdvResult)) { $studentAdvRows[] = $studentAdvRow; }
                  foreach ($studentAdvRows as $studentAdvRow) { 
                     print "<option value='" . $studentAdvRow['studentID'] . "'>". $studentAdvRow['studentID']. " " . $studentAdvRow['firstName'] ." ". $studentAdvRow['lastName']  ."</option>";
                  }
               ?>
            </select><br>
        
   
             <select id = 'faculty4ID' name='faculty4ID'>
               <option selected="selected">Choose A Faculty</option>
               <?
                  $faculty3Sql = "SELECT * FROM Faculty INNER JOIN User ON Faculty.facultyID = User.userID";
                  $faculty3Result = mysqli_query($dataBase, $faculty3Sql);

                  while ($faculty3Row = mysqli_fetch_array($faculty3Result)) { $faculty3Rows[] = $faculty3Row; }
                  foreach ($faculty3Rows as $faculty3Row) { 
                     print "<option value='" . $faculty3Row['facultyID'] . "'>". $faculty3Row['facultyID']. " " . $faculty3Row['firstName'] ." ". $faculty3Row['lastName']  ."</option>";
                  }
               ?>
            </select><br>
             <input type="submit" value="Submit" id="submitButton">
         </form>
         <button id="doneButton" class="button" onclick="toggleElement( 'editStudentAdvisorDiv', 'buttonBlock4' );">Done</button>
         </div>
          <div id ="deleteStudentAdvisorDiv" style="display:none">
        <form method="post" action=" " id="deleteStudentAdvisorForm">
        
        
        <input type="hidden" value="9" name="hiddenButton" id="hiddenButton">
        
        <select id = 'studAdv2ID' name='studAdv2ID'>
               <option selected="selected">Choose A student</option>
               <?
                  $studentAdv2Sql = "SELECT * FROM StudentAdviser INNER JOIN User ON StudentAdviser.studentID = User.userID ";
                  $studentAdv2Result = mysqli_query($dataBase, $studentAdv2Sql);

                  while ($studentAdv2Row = mysqli_fetch_array($studentAdv2Result)) { $studentAdv2Rows[] = $studentAdv2Row; }
                  foreach ($studentAdv2Rows as $studentAdv2Row) { 
                     print "<option value='" . $studentAdv2Row['studentID'] . "'>". $studentAdv2Row['studentID']. " " . $studentAdv2Row['firstName'] ." ". $studentAdv2Row['lastName']  ."</option>";
                  }
               ?>
            </select><br>
                  <input type="submit" value="Submit" id="submitButton">
            </form>
            <button id="doneButton" class="button" onclick="toggleElement( 'deleteStudentAdvisorDiv', 'buttonBlock4' );">Done</button>
            </div>
         
         </div>
          <button class="accordion">Room</button>
      <div class="panel">
         <div class="buttonBlock" id="buttonBlock5">
            <button class="button" onclick="toggleElement( 'buttonBlock5', 'newRoomDiv' );" id="addRoomButton">New Room</button>
            <button class="button" onclick="toggleElement( 'buttonBlock5', 'editRoomDiv' );" id="editRoomButton">Edit Room</button>
            <button class="button" onclick="toggleElement( 'buttonBlock5', 'deleteRoomDiv' );" id="deleteRoomButton">Delete Room</button>
         </div>
         <div id ="newRoomDiv" style="display:none">
        <form method="post" action=" " id="createRoomForm">
        <input type="hidden" value="10" name="hiddenButton" id="hiddenButton">
          <input type="text" name="roomNumInput" placeholder="Room Number" required="true"><br>
          <input type="text" name="roomCapacityInput" placeholder="Room Capacity" required="true"><br>

          <select id = 'buildID' name='buildID'>
               <option selected="selected">Choose A building</option>
               <?
                  $buildSql = "SELECT * FROM Building";
                  $buildResult = mysqli_query($dataBase, $buildSql);

                  while ($buildRow = mysqli_fetch_array($buildResult)) { $buildRows[] = $buildRow; }
                  foreach ($buildRows as $buildRow) { 
                     print "<option value='" . $buildRow['buildingID'] . "'>" . $buildRow['buildingName'] ."</option>";
                  }
               ?>
            </select><br>
             <select name="roomType" required="true" id="roomType">
                  <option selected="selected">Type of Room</option>
                  <option value="0">lab</option>
                  <option value="1">classroom</option>
                  <option value="2">office</option>
               </select><br>
               <input type="submit" value="Submit" id="submitButton">
           </form>
           <button id="doneButton" class="button" onclick="toggleElement( 'newRoomDiv', 'buttonBlock5' );">Done</button>
       </div>
       <div id ="editRoomDiv" style="display:none">
        <form method="post" action=" " id="editRoomForm">
        <input type="hidden" value="11" name="hiddenButton" id="hiddenButton">

          <select id = 'room3ID' name='room3ID'>
               <option selected="selected">Choose A Room</option>
               <?
                  $editRoomSql = "SELECT * FROM Room Inner Join Building ON Room.buildingID = Building.buildingID";
                  $editRoomResult = mysqli_query($dataBase, $editRoomSql);

                  while ($editRoomRow = mysqli_fetch_array($editRoomResult)) { $editRoomRows[] = $editRoomRow; }
                  foreach ($editRoomRows as $editRoomRow) { 
                     print "<option value='" . $editRoomRow['roomID'] . "'>" . $editRoomRow['roomNum'] ." " . $editRoomRow['buildingName'] . "</option>";
                  }
               ?>
            </select><br>
          <input type="text" name="roomNum2Input" placeholder="Room Number" required="true"><br>
          <input type="text" name="roomCapacity2Input" placeholder="Room Capacity" required="true"><br>
          <select id = 'build2ID' name='build2ID'>
               <option selected="selected">Choose A building</option>
               <?
                  $build2Sql = "SELECT * FROM Building";
                  $build2Result = mysqli_query($dataBase, $build2Sql);

                  while ($build2Row = mysqli_fetch_array($build2Result)) { $build2Rows[] = $build2Row; }
                  foreach ($build2Rows as $build2Row) { 
                     print "<option value='" . $build2Row['buildingID'] . "'>" . $build2Row['buildingName'] ."</option>";
                  }
               ?>
            </select><br>
            <select name="roomType2" required="true" id="roomType2">
                  <option selected="selected">Type of Room</option>
                  <option value="0">lab</option>
                  <option value="1">classroom</option>
                  <option value="2">office</option>
               </select><br>
                <input type="submit" value="Submit" id="submitButton">
           </form>
            <button id="doneButton" class="button" onclick="toggleElement( 'editRoomDiv', 'buttonBlock5' );">Done</button>
       </div>
       <div id ="deleteRoomDiv" style="display:none">>
         <form method="post" action=" " id="deleteRoomForm">
         <input type="hidden" value="12" name="hiddenButton" id="hiddenButton">

          <select id = 'room4ID' name='room4ID'>
               <option selected="selected">Choose A Room</option>
               <?
                  $deleteRoomSql = "SELECT * FROM Room Inner Join Building ON Room.buildingID = Building.buildingID";
                  $deleteRoomResult = mysqli_query($dataBase, $deleteRoomSql);

                  while ($deleteRoomRow = mysqli_fetch_array($deleteRoomResult)) { $deleteRoomRows[] = $deleteRoomRow; }
                  foreach ($deleteRoomRows as $deleteRoomRow) { 
                     print "<option value='" . $deleteRoomRow['roomID'] . "'>" . $deleteRoomRow['roomNum'] ." " . $deleteRoomRow['buildingName'] . "</option>";
                  }
               ?>
            </select><br>
            <input type="submit" value="Submit" id="submitButton">

         </form>
         <button id="doneButton" class="button" onclick="toggleElement( 'deleteRoomDiv', 'buttonBlock5' );">Done</button>

       </div>
     </div>
       <button class="accordion">Building</button>
      <div class="panel">
         <div class="buttonBlock" id="buttonBlock6">
            <button class="button" onclick="toggleElement( 'buttonBlock6', 'newBuildingDiv' );" id="addBuildingButton">New Building</button>
            <button class="button" onclick="toggleElement( 'buttonBlock6', 'editBuildingDiv' );" id="editBuildingButton">Edit Building</button>
            <button class="button" onclick="toggleElement( 'buttonBlock6', 'deleteBuildingDiv' );" id="deleteBuildingButton">Delete Building</button>
         </div>
         <div id ="newBuildingDiv" style="display:none">
        <form method="post" action=" " id="createBuildingForm">
        <input type="hidden" value="13" name="hiddenButton" id="hiddenButton">
          <input type="text" name="buildNameInput" placeholder="Building Name" required="true"><br>
        <input type="submit" value="Submit" id="submitButton">
        </form>
        <button id="doneButton" class="button" onclick="toggleElement( 'newBuildingDiv', 'buttonBlock6' );">Done</button>
 </div>
 <div id = "editBuildingDiv" style="display:none">
 <form method="post" action=" " id="editBuildingForm">
 <select id='editBuilding' name="editBuilding">
 <option selected = "selected">Choose a Building</option>
 <?
  $build3Sql = "SELECT * FROM Building";
                  $build3Result = mysqli_query($dataBase, $build3Sql);

                  while ($build3Row = mysqli_fetch_array($build3Result)) { $build3Rows[] = $build3Row; }
                  foreach ($build3Rows as $build3Row) { 
                     print "<option value='" . $build3Row['buildingID'] . "'>" . $build3Row['buildingName'] ."</option>";
                  }
               ?>
</select><br>
<input type ="text" name="buildName2Input" placeholder="Building Name" required="true"><br>
<input type="hidden" value="14" name="hiddenButton" id="hiddenButton">
<input type="submit" value="Submit" id="submitButton">
</form>
 <button id="doneButton" class="button" onclick="toggleElement( 'editBuildingDiv', 'buttonBlock6' );">Done</button>
 </div>
<div id ="deleteBuildingDiv" style="display:none">
<form method ="post" action=" " id="deleteBuildingForm">
<select id="deleteBuilding" name="deleteBuilding">
<?
  $build4Sql = "SELECT * FROM Building";
                  $build4Result = mysqli_query($dataBase, $build4Sql);

                  while ($build4Row = mysqli_fetch_array($build4Result)) { $build4Rows[] = $build4Row; }
                  foreach ($build4Rows as $build4Row) { 
                     print "<option value='" . $build4Row['buildingID'] . "'>" . $build4Row['buildingName'] ."</option>";
                  }
               ?>
</select><br>
<input type="hidden" value="15" name="hiddenButton" id="hiddenButton">
<input type="submit" value = "Submit" id="submitButton">
</form>
 <button id="doneButton" class="button" onclick="toggleElement( 'deleteBuildingDiv', 'buttonBlock6' );">Done</button>
 </div>
</div>


 <button class="accordion">Assign Major</button>
      <div class="panel">
         <div class="buttonBlock" id="buttonBlock7">
            <button class="button" onclick="toggleElement( 'buttonBlock7', 'newMajorDiv' );" id="addMajorButton">New Major</button>
            <button class="button" onclick="toggleElement( 'buttonBlock7', 'editMajorDiv' );" id="editMajorButton">Edit Major</button>
            <button class="button" onclick="toggleElement( 'buttonBlock7', 'deleteMajorDiv' );" id="deleteMajorButton">Delete Major</button>
         </div>
         <div id ="newMajorDiv" style="display:none">
        <form method="post" action=" " id="createMajorMinorForm">
        <input type ="hidden" value="16" name="hiddenButton" id="hiddenButton">
        <select id="newStudentMajSel" name="newStudentMajSel">
        <?
        $newMajMinSql = "SELECT * FROM Student INNER JOIN User ON Student.studentID = User.userID ";
                  $newMajMinSqlResult = mysqli_query($dataBase, $newMajMinSql);

                  while ($newMajMinSqlRow = mysqli_fetch_array($newMajMinSqlResult)) { $newMajMinSqlRows[] = $newMajMinSqlRow; }
                  foreach ($newMajMinSqlRows as $newMajMinSqlRow) { 
                     print "<option value='" . $newMajMinSqlRow['studentID'] . "'>". $newMajMinSqlRow['studentID']. " " . $newMajMinSqlRow['firstName'] ." ". $newMajMinSqlRow['lastName']  ."</option>";
                  }
               ?>
            </select><br>
        <select id="newMajorSel" name="newMajorSel">
       <?
                  $newMajSelectSql = "SELECT * FROM Major";
                  $newMajSelectSqlResult = mysqli_query($dataBase, $newMajSelectSql);

                  while ($newMajSelectSqlRow = mysqli_fetch_array($newMajSelectSqlResult)) { $newMajSelectSqlRows[] = $newMajSelectSqlRow; }
                  foreach ($newMajSelectSqlRows as $newMajSelectSqlRow) { 
                     print "<option value='" . $newMajSelectSqlRow['majorID'] . "'>". $newMajSelectSqlRow['majorName']."</option>";
                  }
               ?>
            </select><br>
        

                    <input type="date" value="" id="newMajMinButton" name="newMajMinButton"><br>
                    <input type ="submit" value="submit" id="submitButton" name="submitButton"><br>
                    </form>
                    <button id="doneButton" class="button" onclick="toggleElement( 'newMajorDiv', 'buttonBlock7' );">Done</button>
 </div>
   <div id ="editMajorDiv" style="display:none">
        <form method="post" action=" " id="editMajorForm">
        <input type ="hidden" value="17" name="hiddenButton" id="hiddenButton">
        <select id="editStudentMajSel" name="editStudentMajSel">
        <?
        $editMajMinSql = "SELECT * FROM StudentMajor INNER JOIN User ON StudentMajor.studentID = User.userID";
        $editMajMinResult = mysqli_query($dataBase, $editMajMinSql);

              while ($editMajMinRow = mysqli_fetch_array($editMajMinResult)) { $editMajMinRows[] = $editMajMinRow; }
                  foreach ($editMajMinRows as $editMajMinRow) { 
                     print "<option value='" . $editMajMinRow['studentID'] . "'>". $editMajMinRow['studentID']. " " . $editMajMinRow['firstName'] ." ". $editMajMinRow['lastName']  ."</option>";
                  }
               ?>
            </select><br>
        <select id="editMajorSel" name="editMajorSel">
       <?
        $editMajSelectSql = "SELECT * FROM Major";
                  $editMajSelectSqlResult = mysqli_query($dataBase, $editMajSelectSql);

                  while ($editMajSelectSqlRow = mysqli_fetch_array($editMajSelectSqlResult)) { $editMajSelectSqlRows[] = $editMajSelectSqlRow; }
                  foreach ($editMajSelectSqlRows as $editMajSelectSqlRow) { 
                     print "<option value='" . $editMajSelectSqlRow['majorID'] . "'>". $editMajSelectSqlRow['majorName']."</option>";
                  }
               ?>
            </select><br>
        

                    <input type="date" value="" id="editMajDateButton" name="editMajDateButton"><br>
                    <input type ="submit" value="submit" id="submitButton" name="submitButton"><br>
                    </form>
                    <button id="doneButton" class="button" onclick="toggleElement( 'editMajorDiv', 'buttonBlock7' );">Done</button>
 </div>
  <div id ="deleteMajorDiv" style="display:none">
        <form method="post" action=" " id="deleteMajorForm">
        <input type ="hidden" value="18" name="hiddenButton" id="hiddenButton">
        <select id="deleteStudentMajSel" name="deleteStudentMajSel">
        <?
        $deleteMajSql = "SELECT * FROM StudentMajor INNER JOIN User ON StudentMajor.studentID = User.userID";
        $deleteMajResult = mysqli_query($dataBase, $deleteMajSql);

              while ($deleteMajRow = mysqli_fetch_array($deleteMajResult)) { $deleteMajRows[] = $deleteMajRow; }
                  foreach ($deleteMajRows as $deleteMajRow) { 
                     print "<option value='" . $deleteMajRow['studentID'] . "'>". $deleteMajRow['studentID']. " " . $deleteMajRow['firstName'] ." ". $deleteMajRow['lastName']  ." " .$deleteMajRow['majorName'] . "</option>";
                  }
               ?>
            </select><br>
        

                   
                    <input type ="submit" value="submit" id="submitButton" name="submitButton"><br>
                    </form>
                    <button id="doneButton" class="button" onclick="toggleElement( 'deleteMajorDiv', 'buttonBlock7' );">Done</button>
 </div>
</div>
<button class="accordion">Assign Minor</button>
      <div class="panel">
         <div class="buttonBlock" id="buttonBlock8">
            <button class="button" onclick="toggleElement( 'buttonBlock8', 'newMinorDiv' );" id="addMinorButton">New Minor</button>
            <button class="button" onclick="toggleElement( 'buttonBlock8', 'editMinorDiv' );" id="editMinorButton">Edit Minor</button>
            <button class="button" onclick="toggleElement( 'buttonBlock8', 'deleteMinorDiv' );" id="deleteMinorButton">Delete Minor</button>
         </div>
         <div id ="newMinorDiv" style="display:none">
        <form method="post" action=" " id="createMinorForm">
        <input type ="hidden" value="19" name="hiddenButton" id="hiddenButton">
        <select id="newStudentMinSel" name="newStudentMinSel">
        <?
        $newMinSql = "SELECT * FROM Student INNER JOIN User ON Student.studentID = User.userID ";
                  $newMinSqlResult = mysqli_query($dataBase, $newMinSql);

                  while ($newMinSqlRow = mysqli_fetch_array($newMinSqlResult)) { $newMinSqlRows[] = $newMinSqlRow; }
                  foreach ($newMinSqlRows as $newMinSqlRow) { 
                     print "<option value='" . $newMinSqlRow['studentID'] . "'>". $newMinSqlRow['studentID']. " " . $newMinSqlRow['firstName'] ." ". $newMinSqlRow['lastName']  ."</option>";
                  }
               ?>
            </select><br>
        <select id="newMinorSel" name="newMinorSel">
       <?
                  $newMinSelectSql = "SELECT * FROM Minor";
                  $newMinSelectSqlResult = mysqli_query($dataBase, $newMinSelectSql);

                  while ($newMinSelectSqlRow = mysqli_fetch_array($newMinSelectSqlResult)) { $newMinSelectSqlRows[] = $newMinSelectSqlRow; }
                  foreach ($newMinSelectSqlRows as $newMinSelectSqlRow) { 
                     print "<option value='" . $newMinSelectSqlRow['minorID'] . "'>". $newMinSelectSqlRow['minorName']."</option>";
                  }
               ?>
            </select><br>
        

                    <input type="date" value="" id="newMinButton" name="newMinButton"><br>
                    <input type ="submit" value="submit" id="submitButton" name="submitButton"><br>
                    </form>
                    <button id="doneButton" class="button" onclick="toggleElement( 'newMinorDiv', 'buttonBlock8' );">Done</button>
 </div>
   <div id ="editMinorDiv" style="display:none">
        <form method="post" action=" " id="editMinorForm">
        <input type ="hidden" value="20" name="hiddenButton" id="hiddenButton">
        <select id="editStudentMinSel" name="editStudentMinSel">
        <?
        $editminSql = "SELECT * FROM StudentMinor INNER JOIN User ON StudentMinor.studentID = User.userID";
        $editminResult = mysqli_query($dataBase, $editminSql);

              while ($editminRow = mysqli_fetch_array($editminResult)) { $editminRows[] = $editminRow; }
                  foreach ($editminRows as $editminRow) { 
                     print "<option value='" . $editminRow['studentID'] . "'>". $editminRow['studentID']. " " . $editminRow['firstName'] ." ". $editminRow['lastName']  ."</option>";
                  }
               ?>
            </select><br>
        <select id="editMinorSel" name="editMinorSel">
       <?
        $editMinSelectSql = "SELECT * FROM Minor";
                  $editMinSelectSqlResult = mysqli_query($dataBase, $editMinSelectSql);

                  while ($editMinSelectSqlRow = mysqli_fetch_array($editMinSelectSqlResult)) { $editMinSelectSqlRows[] = $editMinSelectSqlRow; }
                  foreach ($editMinSelectSqlRows as $editMinSelectSqlRow) { 
                     print "<option value='" . $editMinSelectSqlRow['minorID'] . "'>". $editMinSelectSqlRow['minorName']."</option>";
                  }
               ?>
            </select><br>
        

                    <input type="date" value="" id="editMinDateButton" name="editMinDateButton"><br>
                    <input type ="submit" value="submit" id="submitButton" name="submitButton"><br>
                    </form>
                    <button id="doneButton" class="button" onclick="toggleElement( 'editMinorDiv', 'buttonBlock8' );">Done</button>
 </div>
  <div id ="deleteMinorDiv" style="display:none">
        <form method="post" action=" " id="deleteMinorForm">
        <input type ="hidden" value="21" name="hiddenButton" id="hiddenButton">
        <select id="deleteStudentMinSel" name="deleteStudentMinSel">
        <?
        $deleteMinSql = "SELECT * FROM StudentMinor INNER JOIN User ON StudentMinor.studentID = User.userID";
        $deleteMinResult = mysqli_query($dataBase, $deleteMinSql);

              while ($deleteMinRow = mysqli_fetch_array($deleteMinResult)) { $deleteMinRows[] = $deleteMinRow; }
                  foreach ($deleteMinRows as $deleteMinRow) { 
                     print "<option value='" . $deleteMinRow['studentID'] . "'>". $deleteMinRow['studentID']. " " . $deleteMinRow['firstName'] ." ". $deleteMinRow['lastName']  ." " .$deleteMinRow['minorName'] . "</option>";
                  }
               ?>
            </select><br>
        

                   
                    <input type ="submit" value="submit" id="submitButton" name="submitButton"><br>
                    </form>
                    <button id="doneButton" class="button" onclick="toggleElement( 'deleteMinorDiv', 'buttonBlock8' );">Done</button>
 </div>
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