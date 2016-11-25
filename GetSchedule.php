<?php
  //include connection file 
  include("Config.php");
  include("Session.php");

  if(isset($_POST)){
    if( isset($_POST['termSelected']) ) {
            $termSelected = $_POST['termSelected'];

            $getCurrentClassesSQL = "SELECT * FROM CourseEnrollment 
                                     JOIN Section ON CourseEnrollment.sectionID = Section.sectionID 
                                     JOIN User ON Section.facultyID = User.userID 
                                     JOIN Room ON Section.roomID = Room.roomID 
                                     JOIN Course ON Section.courseID = Course.courseID 
                                     WHERE studentID = $userID
                                     AND termID = '$termSelected'";

            $currentClassesResult = mysqli_query($dataBase, $getCurrentClassesSQL);

            while ($classesRow = mysqli_fetch_array($currentClassesResult)) { $currentClassesRows[] = $classesRow; }

            if( count( $currentClassesRows ) == 0 ){
              print "<h1 style='text-align: center'>You're not currently enrolled in any classes</h1>";
            }
            else{
                
                  print "<h1 style='text-align: center'>" . getHeader( $termSelected ) .  "</h1>";
                  echo'
                      <br>
                      <table id="currentScheduleTable" class="table-fill">
                    
                      <thead>
                        <tr>
                          <th class="text-left">Course</th>
                          <th class="text-left">Credit Hours</th>
                          <th class="text-left">Room Number</th>
                          <th class="text-left">Professor</th>
                          <th class="text-left">Section</th>
                        </tr>
                      </thead>

                      <tbody class="table-hover">
                ';

                foreach ($currentClassesRows as $classesRow) { 
                  $index = 0;

                  print "<tr name='" . $classesRow['sectionID'] . "' data-row-id=" . $classesRow['sectionID'] . " id=" . $classesRow['sectionID'] . " class='toggler' onclick='showDeleteClassButton(this);'>";
                  print "<td class='text-left' col-index=" . $index++ . ">" . $classesRow['courseName'] . "</td>";
                  print "<td class='text-left' col-index=" . $index++ . ">" . $classesRow['creditHours'] . "</td>";
                  print "<td class='text-left' col-index=" . $index++ . ">" . $classesRow['roomNum'] . "</td>";
                  print "<td class='text-left' col-index=" . $index++ . ">" . $classesRow['firstName'] . " " . $classesRow['lastName'] . "</td>";
                  print "<td class='text-left' col-index=" . $index++ . ">" . $classesRow['sectionNum'] . "</td>";
                  print "</tr>";

                  print"<tr class='cat" . $classesRow['sectionID'] . "' style='display:none;' id=" . $classesRow['sectionID'] . ">";
                  print"<td colspan = 5 style='text-align:center'><a href='#' class='deleteButton' onclick='deleteClass(" . $classesRow['sectionID'] . ");'>Delete</a></td>";
                  print"</tr>";
                }
                      
                print"
                    </tbody>

                    </table>
                ";
          }
    } 
  }

  function getHeader( $termID ){
      return ( $termID == 1 ? "Here is your current schedule" : "Schedule for term selected below" );
  }
?>