<?php
  //include connection file 
  include("Config.php");

  if( isset($_POST) ){
      if( isset($_POST['courseIDSent']) ){
          $courseID = $_POST['courseIDSent'];
          $courseSQL = "SELECT * FROM Course WHERE courseID = '$courseID'";

          $courseResults = mysqli_query($dataBase, $courseSQL);

          $courseData = mysqli_fetch_assoc( $courseResults );

          print "<select id='department2ID' name='department2ID'>";

          $depart2Sql = "SELECT * FROM Department";
          $depart2Result = mysqli_query($dataBase, $depart2Sql);

          while ($depart2Row = mysqli_fetch_array($depart2Result)) { $depart2Rows[] = $depart2Row; }
          foreach ($depart2Rows as $depart2Row) {
            if( $depart2Row['departmentID'] == $courseData['departmentID'] ){
                print "<option selected='selected' value='" . $depart2Row['departmentID'] . "'>" . $depart2Row['deptName'] . "</option>";
            }
            else{
                print "<option value='" . $depart2Row['departmentID'] . "'>" . $depart2Row['deptName'] . "</option>";  
            }
          }

          print "</select><br>";

            
             
          print"<input type='text' name='creditHours2Input' value='" . $courseData['creditHours'] . "'><br>";
          print"<input type='text' name='courseName2Input' value='" . $courseData['courseName'] . "'><br>";
          print"<input type='text' name='textbook2Input' value='" . $courseData['textBook'] . "'><br>";
          print"<input type='textarea' name='description2Input' value='" . $courseData['description'] . "'><br>";
          print"<input type='text' name='courseCode2Input' value='" . $courseData['courseCode'] . "'><br>";
          print"<input type='hidden' value='3' name='hiddenButton' id='hiddenButton'>";
          print"<input type='submit' value='Update' id='submitButton'>";
      }

      if( isset($_POST['sectionIDSent']) ){
          $sectionID = $_POST['sectionIDSent'];
          $sectionSQL = "SELECT * FROM Section WHERE sectionID = '$sectionID'";

          $sectionResults = mysqli_query($dataBase, $sectionSQL);

          $sectionData = mysqli_fetch_assoc( $sectionResults );

          print "<select id = 'course5ID' name='course5ID'> ";
               
          $course5Sql = "SELECT * FROM Course";
          $course5Result = mysqli_query($dataBase, $course5Sql);

          while ($course5Row = mysqli_fetch_array($course5Result)) { $course5Rows[] = $course5Row; }
          foreach ($course5Rows as $course5Row) {
              if( $course5Rows['courseId'] == $sectionData['courseID'] ){
                  print"<option selected='selected' value='" . $course5Rows['courseID'] . "'>" . $course5Rows['courseName'] . "</option>";
              }
              else{
                  print "<option value='" . $course5Row['courseID'] . "'>" . $course5Row['courseName'] . "</option>";  
              }
          }

          print"</select><br>";

          print"<input type='text' name='sectionNum2Input' value='" . $sectionData['sectionNum'] . "'><br>";
                   
          print"<select id = 'term2ID' name='term2ID'>";

          $term2Sql = "SELECT * FROM Term";
          $term2Result = mysqli_query($dataBase, $term2Sql);

          while ($term2Row = mysqli_fetch_array($term2Result)) { $term2Rows[] = $term2Row; }
          foreach ($term2Rows as $row2Term) {
              if( $row2Term['termID'] == $sectionData['termID'] ){
                  print"<option selected='selected' value='" . $row2Term['termID'] . "'>" . $row2Term['semester'] . " " . $row2Term['year'] . "</option>";
              }
              else{
                  print "<option value='" . $row2Term['termID'] . "'>" . $row2Term['semester'] . " " . $row2Term['year'] . "</option>";
              }
             
          }

          print"</select><br>";
                  
            
          print"<select id = 'timeSlot2ID' name='timeSlot2ID'>";

          $timeSlot2sql = "SELECT * FROM Timeslot INNER JOIN Time ON Timeslot.timeID=Time.timeID INNER JOIN Day ON Timeslot.dayID=Day.DayID";
          $timeSlot2result = mysqli_query($dataBase, $timeSlot2sql);
                  
                  
          while ($timeSlot2row = mysqli_fetch_array($timeSlot2result)) { $timeSlot2rows[] = $timeSlot2row; }
          foreach ($timeSlot2rows as $timeSlot2row) {
              if( $timeSlot2row['timeslotID'] == $sectionData['timeslotID'] ){
                  print "<option selected='selected' value='" . $timeSlot2row['timeslotID'] . "'>" . $timeSlot2row['timeStart'] . "-" . $timeSlot2row['timeEnd'] . " " . $timeSlot2row['days'] ."</option>";
              }
              else{
                  print "<option value='" . $timeSlot2row['timeslotID'] . "'>" . $timeSlot2row['timeStart'] . "-" . $timeSlot2row['timeEnd'] . " " . $timeSlot2row['days'] ."</option>";
              }
             
          }

          print"</select><br>";

          print"<select id = 'room2ID' name='room2ID'>";

          $room2Sql = "SELECT * FROM Room INNER JOIN Building ON Room.buildingID=Building.buildingID";
          $room2Result = mysqli_query($dataBase, $room2Sql);

          while ($room2Row = mysqli_fetch_array($room2Result)) { $room2Rows[] = $room2Row; }
          foreach ($room2Rows as $room2Row) { 
              if( $room2Row['roomID'] == $sectionData['roomID'] ){
                  print "<option selected='selected' value='" . $room2Row['roomID'] . "'>" . $room2Row['roomNum'] . " " . $room2Row['buildingName'] . "</option>";
              }
              else{
                  print "<option value='" . $room2Row['roomID'] . "'>" . $room2Row['roomNum'] . " " . $room2Row['buildingName'] . "</option>";
              }
          }

          print"</select><br>";
            
          print"<select id = 'faculty2ID' name='faculty2ID'>";

          $faculty2Sql = "SELECT * FROM Faculty INNER JOIN User ON Faculty.facultyID=User.userID";
          $faculty2Result = mysqli_query($dataBase, $faculty2Sql);

          while ($faculty2Row = mysqli_fetch_array($faculty2Result)) { $faculty2Rows[] = $faculty2Row; }
          foreach ($faculty2Rows as $faculty2Row) { 
              if( $faculty2Row['facultyID'] == $sectionData['facultyID'] ){
                  print "<option selected='selected' value='" . $faculty2Row['facultyID'] . "'>" ."Faculty ID: ". $faculty2Row['facultyID'] . " " . $faculty2Row['firstName'] . " ". $faculty2Row['lastName']  ."</option>";
              }
              else{
                  print "<option value='" . $faculty2Row['facultyID'] . "'>" ."Faculty ID: ". $faculty2Row['facultyID'] . " " . $faculty2Row['firstName'] . " ". $faculty2Row['lastName']  ."</option>";
              }
          }

          print"</select><br>";
            
          print"<input type='hidden' value='5' name='hiddenButton' id='hiddenButton'>";
          print"<input type='submit' value='Edit' id='submitButton'>";
      }

      if( isset($_POST['roomIDSent']) ){
          $roomID = $_POST['roomIDSent'];

          $editRoomSql = "SELECT * FROM Room Inner Join Building ON Room.buildingID = Building.buildingID WHERE roomID = '$roomID'";
          $editRoomResult = mysqli_query($dataBase, $editRoomSql);

          $roomData = mysqli_fetch_assoc( $editRoomResult );

          print"<input type='text' name='roomNum2Input' value='" . $roomData['roomNum'] . "'><br>";
          print"<input type='text' name='roomCapacity2Input' value='" . $roomData['capacity'] . "'><br>";

          print"<select id = 'build2ID' name='build2ID'>";

          $build2Sql = "SELECT * FROM Building";
          $build2Result = mysqli_query($dataBase, $build2Sql);

          while ($build2Row = mysqli_fetch_array($build2Result)) { $build2Rows[] = $build2Row; }
          foreach ($build2Rows as $build2Row) { 
              if( $build2Row['buildingID'] == $roomData['buildingID'] ){
                  print "<option selected='selected' value='" . $build2Row['buildingID'] . "'>" . $build2Row['buildingName'] ."</option>";
              }
              else{
                  print "<option value='" . $build2Row['buildingID'] . "'>" . $build2Row['buildingName'] ."</option>";
              }   
          }

          print"</select><br>";
          
          print"<select name='roomType2' required='true' id='roomType2'>";
          print"<option " . getSelectedRoom( $roomData['roomType'], 0 ) . " value='0'>Lab</option>";
          print"<option " . getSelectedRoom( $roomData['roomType'], 1 ) . " value='1'>Classroom</option>";
          print"<option " . getSelectedRoom( $roomData['roomType'], 2 ) . " value='2'>Office</option>";
          print"</select><br>";

          print"<input type='submit' value='Edit' id='submitButton'>";
      }

      if( isset($_POST['deptIDSent']) ){
          $deptID = $_POST['deptIDSent'];

          $deptSQL = "SELECT * FROM Department WHERE departmentID = '$deptID'";
          $deptSQLResult = mysqli_query($dataBase, $deptSQL);

          $deptData = mysqli_fetch_assoc( $deptSQLResult );

          print"<select id='editCollegeSel' name='editCollegeSel'>";

          $editCollegeSql = "SELECT * FROM College";
          $editCollegeResult = mysqli_query($dataBase, $editCollegeSql);

          while ($editCollegeRow = mysqli_fetch_array($editCollegeResult)) { $editCollegeRows[] = $editCollegeRow; }
          foreach ($editCollegeRows as $editCollegeRow) { 
              if( $editCollegeRow['collegeID'] == $deptData['collegeID'] ){
                  print "<option selected='selected' value='" . $editCollegeRow['collegeID'] . "'>". $editCollegeRow['collegeName']."</option>";
              }
              else{
                  print "<option value='" . $editCollegeRow['collegeID'] . "'>". $editCollegeRow['collegeName']."</option>";
              }
          }
          
          print"</select><br>";

          print"<input type='text' name='editDeptName' value='" . $deptData['deptName'] . "'><br>";
          print"<input type='text' name='editDeptChair' value='" . $deptData['chair'] . "'><br>";
          print"<input type='text' name='editDeptContact' value='" . $deptData['contact'] . "'><br>";
          print"<input type='text' name='editDeptDescription' value='" . $deptData['description'] . "'><br>";
          print"<input type='text' name='editDeptLocation' value='" . $deptData['location'] . "'><br>";
          print"<input type='submit' value='Edit' id='submitButton'>";
      }

      if( isset($_POST['collegeIDSent']) ){
          $collegeID = $_POST['collegeIDSent'];

          $collegeSQL = "SELECT * FROM College WHERE collegeID = '$collegeID'";
          $collegeSQLResult = mysqli_query($dataBase, $collegeSQL);

          $collegeData = mysqli_fetch_assoc( $collegeSQLResult );

          print"<input type='text' name='editCollegeName' value='" . $collegeData['collegeName'] . "'><br>";
          print"<input type='text' name='editCollegeAddress' value='" . $collegeData['collegeAddress'] . "'><br>";
          print"<input type='text' name='editCollegePhone' value='" . $collegeData['collegePhone'] . "'><br>";
          print"<input type='text' name='editCollegeAdmitted' value='" . $collegeData['collegeAdmitted'] . "'><br>";
          print"<input type='submit' value='Edit' id='submitButton'>";
      }
  
  
  if( isset($_POST['studentHoldIDSent']) ){
          $studentID = $_POST['studentHoldIDSent'];

          $studHoldSQL = "SELECT * FROM StudentHolds WHERE studentID = '$studentID'";
          $studHoldSQLResult = mysqli_query($dataBase, $studHoldSQL);

          $studHoldData = mysqli_fetch_assoc( $studHoldSQLResult );
          
                print"<select id='editStudentHoldSel' name='editStudentHoldSel'>";

          $editStudHoldSql = "SELECT * FROM StudentHolds WHERE studentID = '$studentID'";
          $editstudHoldResult = mysqli_query($dataBase, $editStudHoldSql);

          while ($editStudHoldRow = mysqli_fetch_array($editstudHoldResult)) { $editStudHoldRows[] = $editStudHoldRow; }
          foreach ($editStudHoldRows as $editStudHoldRow) { 
                  print "<option value='" . $editStudHoldRow['holdID'] . "'>". $editStudHoldRow['holdID']."</option>"; 
          }
          
          print"</select><br>";
           

          print"<input type='number' name='editStudHoldBit' value='" . $studHoldData['active'] . "'><br>";
          print"<input type='date' name='editStudHoldDate' value='" . $studHoldData['dateCreated'] . "'><br>";
          print"<input type='submit' value='Edit' id='submitButton'>";
      }
      
      
      if( isset($_POST['deletestudentHoldIDSent']) ){
          $studentID = $_POST['deletestudentHoldIDSent'];

          $studHoldSQL = "SELECT * FROM StudentHolds WHERE studentID = '$studentID'";
          $studHoldSQLResult = mysqli_query($dataBase, $studHoldSQL);

          $studHoldData = mysqli_fetch_assoc( $studHoldSQLResult );
          
                print"<select id='deleteStudentHoldIDSel' name='deleteStudentHoldIDSel'>";

          $deleteStudHoldSql = "SELECT * FROM StudentHolds WHERE studentID = '$studentID'";
          $deletestudHoldResult = mysqli_query($dataBase, $deleteStudHoldSql);

          while ($deleteStudHoldRow = mysqli_fetch_array($deletestudHoldResult)) { $deleteStudHoldRows[] = $deleteStudHoldRow; }
          foreach ($deleteStudHoldRows as $deleteStudHoldRow) { 
                  print "<option value='" . $deleteStudHoldRow['holdID'] . "'>". $deleteStudHoldRow['holdID']."</option>"; 
          }
          
          print"</select><br>";
           


          print"<input type='submit' value='delete' id='submitButton'>";
      }
      
      if( isset($_POST['newCourseEnrollTerm']) ){
          $termID = $_POST['newCourseEnrollTerm'];

         
          
                print"<select id='newCourseEnrollSectionSel' name='newCourseEnrollSectionSel'>";

          $addcoureEnrollSQL = "SELECT * FROM Section INNER JOIN Course ON Section.courseID=Course.courseID WHERE termID = '$termID'";
          $addcoureEnrollResult = mysqli_query($dataBase, $addcoureEnrollSQL);

          while ($addcoureEnrollRow = mysqli_fetch_array($addcoureEnrollResult)) { $addcoureEnrollRows[] = $addcoureEnrollRow; }
          foreach ($addcoureEnrollRows as $addcoureEnrollRow) { 
                  print "<option value='" . $addcoureEnrollRow['sectionID'] . "'>". $addcoureEnrollRow['courseName']. " " .$addcoureEnrollRow['sectionNum']. "</option>"; 
          }
          
          print"</select><br>";
           


          print"<input type='submit' value='submit' id='submitButton'>";
      }
      
      if( isset($_POST['editCourseEnrollTerm']) ){
          $sectionID = $_POST['editCourseEnrollTerm'];

          $coureEnrollSQL = "SELECT * FROM CourseEnrollment WHERE sectionID = '$sectionID'";
          $coureEnrollSQLResult = mysqli_query($dataBase, $coureEnrollSQL);

          $coureEnrollData = mysqli_fetch_assoc( $studHoldSQLResult );
          
                print"<select id='editCourseEnrollSectionSel' name='editCourseEnrollSectionSel'>";

          $editcoureEnrollSQL = "SELECT * FROM CourseEnrollment INNER JOIN User ON CourseEnrollment.studentID=User.userID WHERE sectionID = '$sectionID'";
          $editcoureEnrollResult = mysqli_query($dataBase, $editcoureEnrollSQL);

          while ($editcoureEnrollRow = mysqli_fetch_array($editcoureEnrollResult)) { $editcoureEnrollRows[] = $editcoureEnrollRow; }
          foreach ($editcoureEnrollRows as $editcoureEnrollRow) { 
                  print "<option value='" . $editcoureEnrollRow['studentID'] . "'>". $editcoureEnrollRow['firstName']. " " .$editcoureEnrollRow['lastName']. "</option>"; 
          }
          
          print"</select><br>";
           
          print"<select name='midTermGrade' required='true' id='midTermGrade'>";
          print"<option value='U'>Unsatisfactory</option>";
          print"<option value='s'>Satisfactory</option>";
          print"</select><br>";
          
          print"<select name='finalGrade' required='true' id='finalGrade'>";
          print"<option value='A'>A</option>";
          print"<option value='A-'>A-</option>";
          print"<option value='B+'>B+</option>";
          print"<option value='B'>B</option>";
          print"<option value='B-'>B-</option>";
          print"<option value='C+'>C+</option>";
          print"<option value='C'>C</option>";
          print"<option value='C-'>D-</option>";
          print"<option value='D+'>D+</option>";
          print"<option value='D'>D</option>";
          print"<option value='D-'>D-</option>";
          print"<option value='F'>F</option>";
         
          print"</select><br>";

          print"<input type='submit' value='edit' id='submitButton'>";
      }
      
       if( isset($_POST['deleteCourseEnrollTerm']) ){
          $sectionID = $_POST['deleteCourseEnrollTerm'];

          $coureEnrollSQL = "SELECT * FROM CourseEnrollment WHERE sectionID = '$sectionID'";
          $coureEnrollSQLResult = mysqli_query($dataBase, $coureEnrollSQL);

          $coureEnrollData = mysqli_fetch_assoc( $studHoldSQLResult );
          
                print"<select id='editCourseEnrollSectionSel' name='editCourseEnrollSectionSel'>";

          $editcoureEnrollSQL = "SELECT * FROM CourseEnrollment INNER JOIN User ON CourseEnrollment.studentID=User.userID WHERE sectionID = '$sectionID'";
          $editcoureEnrollResult = mysqli_query($dataBase, $editcoureEnrollSQL);

          while ($editcoureEnrollRow = mysqli_fetch_array($editcoureEnrollResult)) { $editcoureEnrollRows[] = $editcoureEnrollRow; }
          foreach ($editcoureEnrollRows as $editcoureEnrollRow) { 
                  print "<option value='" . $editcoureEnrollRow['studentID'] . "'>". $editcoureEnrollRow['studentID'] ." ". $editcoureEnrollRow['firstName']. " " .$editcoureEnrollRow['lastName']. "</option>"; 
          }
          
          print"</select><br>";
           
     

          print"<input type='submit' value='delete' id='submitButton'>";
      }
  }

  function getSelectedRoom( $roomType, $value ){
      if( $roomType == $value ){
          return "selected='selected'";
      }
  }

?>