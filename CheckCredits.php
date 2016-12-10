<?php
  //include connection file 
  include("Config.php");
  include("Session.php");

  if(isset($_POST)){
    if( isset($_POST['termSelected']) && $_POST['termSelected'] != "Choose A Term"  ) {
          $termSelected = $_POST['termSelected'];

          $getCurrentClassesSQL = "SELECT * FROM CourseEnrollment 
                                   JOIN Section ON CourseEnrollment.sectionID = Section.sectionID 
                                   JOIN User ON Section.facultyID = User.userID 
                                   JOIN Room ON Section.roomID = Room.roomID 
                                   JOIN Course ON Section.courseID = Course.courseID 
                                   WHERE studentID = $userID
                                   AND termID = '$termSelected'";

          $currentClassesResult = mysqli_query($dataBase, $getCurrentClassesSQL);

          while ($classesRow = mysqli_fetch_array($currentClassesResult)) {
               $creditHours += $classesRow['creditHours'];
          }

          if( $creditHours <= 16 ){ print "true"; }
          else { print "false"; }
    }
    else{
      print "choose";
    }
  }

?>