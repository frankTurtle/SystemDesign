<?php
  //include connection file 
  include("Config.php");
  include("Session.php");

  if(isset($_POST)){
    if( isset($_POST['subjectSelected']) ) {
          $sectionID = $_POST['subjectSelected'];

          $getPreReqs = "SELECT prerequisiteID FROM Prerequisites 
                        JOIN Section ON Section.courseID = Prerequisites.courseID
                        WHERE sectionID = $sectionID";

          $getAllGrades = "SELECT * FROM CourseEnrollment 
                           JOIN Section ON CourseEnrollment.sectionID = Section.sectionID 
                           JOIN Course ON Section.courseID = Course.courseID 
                           WHERE studentID = $userID";

          $preReqResults = mysqli_query($dataBase, $getPreReqs);
          $currentGrades = mysqli_query($dataBase, $getAllGrades);

          $answer = "true";

          while( $gradesArray = mysqli_fetch_array($currentGrades) ) { $grades[] = $gradesArray; }
          while( $preRequeIDS = mysqli_fetch_array($preReqResults) ) { $preReq[] = $preRequeIDS; }

          foreach( $preReq as $id ){
              foreach ($grades as $grade) { 
                  if( $grade['courseID'] == $id ){
                      if( !is_null($grade['finalGrade']) && $grade['finalGrade'] > 2.0 ){
                          $answer = "true";
                      }
                      else{
                          $answer = "false";
                      }
                  }
              }    
          }

          print $answer;
    } 
  }

?>