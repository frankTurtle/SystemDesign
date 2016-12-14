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

          // print "Section: " . $sectionID . "  ";
          // print "ID: " . $userID . "\r\n";
          // print "Grades count: " . count($grades) . "\r\n";

          if( count($preReq) != 0 && count($grades) != 0 ){
            foreach( $preReq as $id ){
              // print "inside prereq for";
              foreach ($grades as $grade) { 
                  // print "inside grades for-- ";
                  // print $grade['courseID'];
                  // print "  id ". $id['prerequisiteID'];

                // print "GradeID: " . $grade['courseID'] . " PREID: " . $id['prerequisiteID'] . "\r\n";
                  if( $grade['courseID'] == $id['prerequisiteID'] ){
                      // print "***inside if grade == ID***";

                      if( is_null($grade['finalGrade']) && $grade['finalGrade'] < 2.0 ){
                          $answer = "false";
                      }
                  }
              }    
            }  
          }

          print $answer;
    } 
  }

?>