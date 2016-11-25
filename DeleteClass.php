<?php
  //include connection file 
  include_once("Config.php");
  include_once("Session.php");

  if(isset($_POST['sectionID'])){
      $sectionID = $_POST['sectionID'];

      $sectionSql = "DELETE FROM `CourseEnrollment` WHERE `studentID` = '$userID' AND `sectionID` = '$sectionID'";

      if (mysqli_query($dataBase, $sectionSql)) { echo "Class Deleted"; }
      else { echo "Error: " . $sectionSql . "<br>" . mysqli_error($dataBase); }
  }
?>