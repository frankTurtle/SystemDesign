<?php
  //include connection file 
  include_once("Config.php");

  if(isset($_POST)){
    if( isset($_POST['subjectSelected']) ) {
        $subject = $_POST['subjectSelected'];

        $sectionSql = "SELECT * FROM Timeslot
                       INNER JOIN Section ON Timeslot.timeslotID = Section.timeslotID
                       INNER JOIN Time ON Timeslot.timeID = Time.timeID
                       INNER JOIN Day ON Timeslot.dayID = Day.DayID
                       WHERE courseID = '$subject'";

        $sectionResult = mysqli_query($dataBase, $sectionSql);

        echo "<option>Choose a TimeSlot</option>";

        while ($sectionRow = mysqli_fetch_array($sectionResult)) { $sectionRows[] = $sectionRow; }

        foreach ($sectionRows as $row) { 
          // echo "<option>test</option>";
             echo "<option value=" . $row['timeslotID'] . ">" . $row['days'] . " -- " . $row['timeStart'] . " - " . $row['timeEnd'] . "</option>";
        }
    } 
  }
?>