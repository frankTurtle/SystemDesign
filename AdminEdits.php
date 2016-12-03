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
  }

  function getSelectedRoom( $roomType, $value ){
      if( $roomType == $value ){
          return "selected='selected'";
      }
  }

?>