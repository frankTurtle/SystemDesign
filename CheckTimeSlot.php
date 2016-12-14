<?php
  //include connection file 
  include("Config.php");
  include("Session.php");

  if(isset($_POST)){
    if( isset($_POST['timeSlot']) ) {
          $timeSlot = $_POST['timeSlot'];
          $term     = $_POST['term'];

          $slots = "SELECT * FROM CourseEnrollment 
                     JOIN Section ON CourseEnrollment.sectionID = Section.sectionID 
                     JOIN Course ON Section.courseID = Course.courseID 
                     WHERE studentID = $userID
                     AND termID = $term";

                     // print $slots;

          $selectedSlots = mysqli_query($dataBase, $slots);

          $answer = "true";

          while( $gradesArray = mysqli_fetch_array($selectedSlots) ) { $grades[] = $gradesArray; }

          if( count($grades) > 0 ){
              foreach( $grades as $grade ){
                  if( $grade['timeslotID'] == $timeSlot ){
                      $answer = "false";
                  }
              }
          } 

          print $answer;
    } 
  }

?>