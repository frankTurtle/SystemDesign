<?php
  //include connection file 
  include_once("Config.php");

  if(isset($_POST)){
    if( isset($_POST['termSelected']) ) {
        $term = $_POST['termSelected'];
        $sectionSql = "SELECT * FROM Section INNER JOIN Course ON Section.courseID = Course.courseID WHERE termID = '$term'";

        $sectionResult = mysqli_query($dataBase, $sectionSql);

        echo "<option>Choose a Subject</option>";

        while ($sectionRow = mysqli_fetch_array($sectionResult)) { $sectionRows[] = $sectionRow; }

        foreach ($sectionRows as $row) { 
            echo "<option value=" . $row['courseID'] . ">" . $row['courseName'] . "</option>";
        }
    } 
  }
?>