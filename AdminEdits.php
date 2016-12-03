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
                print "<option selected='selected' value='" . $depart2Row['departmentID'] . ">" . $depart2Row['deptName'] . "</option>";
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
    
  }

?>