<?php
  //include connection file 
  include_once("Config.php");

  if(isset($_POST)){
    if( isset($_POST['termSelected']) ) {
        $term = $_POST['termSelected'];
        $sectionSql = "SELECT * FROM Section WHERE termID = '$term'";

        $sectionResult = mysqli_query($dataBase, $sectionSql);

        echo "<option>Choose a Subject</option>";

        while ($sectionRow = mysqli_fetch_array($sectionResult)) { $sectionRows[] = $sectionRow; }
        foreach ($sectionRows as $row) { 
          echo "<option>" . $row['sectionID'] . " " . $row['timeslotID'] . "</option>";
        }
    } 
  }
  
  // send data as json format
  // echo json_encode($msg);
?>