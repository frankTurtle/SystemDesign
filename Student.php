<?php
   include('Session.php');

   if($_SERVER["REQUEST_METHOD"] == "POST") {
   		$subject = $_POST['sectionID'];

   		$sql = "INSERT INTO `CourseEnrollment`( `studentID`, `sectionID` )
                 VALUES ( '$userID', '$subject');";

        $message = "Successfully Registered";
        $error = "Duplicate Entry, try again";

        if (mysqli_query($dataBase, $sql)) { echo "<script type='text/javascript'>alert('$message');</script>"; }
        else { echo "<script type='text/javascript'>alert('$error');</script>"; }
   }
?>
<html>

	<head>
     <link rel="stylesheet" type="text/css" href="css/student.css">
     <script src="javascript/admin.js" type="text/javascript"></script>
     <script src="javascript/student.js" type="text/javascript"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <title>Student Page</title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $login_session; ?></h1>

      <ul>
        <li><a class="active" href="Student.php">Home</a></li>
        <li><a class="active" href="PasswordReset.php">Reset Password</a></li>
        <li><a class="active" href = "Logout.php">Sign Out</a></li>
      </ul>

      <button class="accordion">Add / Drop / View Classes</button> 
      <div class="panel">

         <br>

         <div id="currentClassesDiv">
            <div id="sliderResult" class="transition">

            	<div id="currentClasses">
	            	<?
	            		print"<script>getSchedule(" . $semester . ")</script>";
					?>
				</div>

				<div>
					<form method="post" action="" id="chooseTerm">

	                   	<select id='chooseTermID' name='chooseTermID' onchange="getSchedule(this.value);">

	                       	<option selected="selected">View Another Term</option>

		                  	<?
			                    $scheduleTerm = "SELECT * FROM Term";
			                  	$scheduleTermResult = mysqli_query($dataBase, $scheduleTerm);

			                	while ($scheduleTermRow = mysqli_fetch_array($scheduleTermResult)) { $scheduleTermRows[] = $scheduleTermRow; }
			                  	foreach ($scheduleTermRows as $scheduleRowTerm) { 
			                    	print "<option name='term' value='" . $scheduleRowTerm['termID'] . "'>" . $scheduleRowTerm['semester'] . " " . $scheduleRowTerm['year'] . "</option>";
			                  	}
			               ?>

	 	               	</select>

            		</form>
				</div>


				<br>

				<div id="addNewClass">
					<hr>

					<h1 style='text-align: center'>Add a new Class</h1>
	            	<form method="post" action="" id="addOrDropClassForm">

	                   	<select id='termID' name='termID' onchange="getSubject(this.value, subject);">

	                       	<option selected="selected" value="99">Choose A Term</option>

		                  	<?
			                    $termSql = "SELECT * FROM Term";
			                  	$termResult = mysqli_query($dataBase, $termSql);

			                	while ($termRow = mysqli_fetch_array($termResult)) { $termRows[] = $termRow; }
			                  	foreach ($termRows as $rowTerm) { 
			                    	print "<option name='term' value='" . $rowTerm['termID'] . "'>" . $rowTerm['semester'] . " " . $rowTerm['year'] . "</option>";
			                  	}
			               ?>

	 	               	</select>

	 	               	<select id='subject' name='sectionID' style='display:none' onchange="getTimeSlot(this.value);"></select>
	 	               	<select id='timeSlot' name='timeSlot' style='display:none'> </select>

		               	<input type="submit" value="Register" id="submitButton">

	            	</form>

	            	<div id="answer"></div>

	            	<script>
	            		document.getElementById("submitButton").addEventListener("click",
						 	function(event){
						    	event.preventDefault();

						    	checkCredits();

						    	// check credits -- DONE
						    	// check prereqs
						    	// timeslot check


							}
						);

						function checkCredits(){
							var selector = document.getElementById('termID');
						    var value = selector[selector.selectedIndex].value;

							$.ajax({
								type: 'POST',
								url: 'CheckCredits.php',
								data: {
									  termSelected:value
						 		},

						 		success:
						 		function (response) {
						 			if( response == "true" ){
						 				checkPrerequisites();
						 			}
						 			else if ( response == "false" ){
						 				document.getElementById("answer").innerHTML = "<h1 style='text-align: center'>TOO MANY CREDITSSSSSSS!!!! <br> UNABLE TO REGISTER</h1>"
						 			}
						 			else{
						 				document.getElementById("answer").innerHTML = "<h1 style='text-align: center'>Please Choose a Term!</h1>"
						 			}
						  			
								}
							});
						}

						function checkPrerequisites(){
							var selector = document.getElementById('subject');
						    var value = selector[selector.selectedIndex].value;

							$.ajax({
								type: 'POST',
								url: 'CheckPrerequisites.php',
								data: {
									  subjectSelected:value
						 		},

						 		success:
						 		function (response) {
						 			alert( response );
						 			
						 			if( response == "true" ){
						 				document.getElementById("addOrDropClassForm").submit();	
						 			}
						 			else{
						 				document.getElementById("answer").innerHTML = "<h1 style='text-align: center'>Dont meet prerequisites. Try again</h1>"
						 			}
						  			
								}
							});
						}
					</script>

	            </div>
			</div>

			<br>

         </div>
      </div>

      <button class="accordion">Holds</button> 
      <div class="panel">

         <br>

         <div id="holdsDive">
            <div id="sliderResult" class="transition">
            	<?
            		$getHoldsSQL = "SELECT * FROM StudentHolds INNER JOIN Holds ON StudentHolds.holdID = Holds.holdID WHERE studentID = $userID";
            		$result = mysqli_query($dataBase, $getHoldsSQL);
            		while ($row = mysqli_fetch_array($result)) { $rows[] = $row; }

            		if( count( $rows ) == 0 ){
            			print "<h1 style='text-align: center'> Congratulations no holds!</h1>";
            		}
            		else{
            			echo'   
            				<script>hideElement("addNewClass")</script>
	            			<table class="table-fill">
						
							<thead>
								<tr>
									<th class="text-left">Hold Type</th>
									<th class="text-left">Active</th>
									<th class="text-left">Days Left</th>
									<th class="text-left">Description</th>
								</tr>
							</thead>

							<tbody class="table-hover">
						';

						function getHoldTypeName( $holdType ){
	                  		switch ($holdType) {
	                  			case 0:
	                  				return "Disciplinary";
	                  				break;

                  				case 1:
	                  				return "Financial";
	                  				break;

                  				case 2:
	                  				return "Academic";
	                  				break;

                  				case 3:
	                  				return "Immunization";
	                  				break;
	                  		}
	                  	}

	                  	function isActive( $active ){
	                  		return ( $active == 1 )
	                  			? "Yes"
	                  			: "No";
	                  	}

	                  	function timeLeft( $dateCreated, $duration ){
							$daysPassed = round(abs(time() - strtotime($dateCreated)) / 86400);
							return $duration - $daysPassed;
	                  	}

	                  	foreach ($rows as $row) { 
	                  		$index = 0;

		                  	print "<tr data-row-id=" . $row['userID'] . ">";
		                  	print "<td class='text-left' col-index=" . $index++ . ">" . getHoldTypeName( $row['holdType'] ) . "</td>";
		                  	print "<td class='text-left' col-index=" . $index++ . ">" . isActive( $row['active'] ) . "</td>";
		                  	print "<td class='text-left' col-index=" . $index++ . ">" . timeLeft( $row['dateCreated'], $row['durationInDays'] ). "</td>";
		                  	print "<td class='text-left' col-index=" . $index++ . ">" . $row['description'] . "</td>";
		                  	print "</tr>";
	                  	}
			                  	
			            echo'
							</tbody>

							</table>
						';
            		}
     

				?>
			</div>

			<br>

         </div>
      </div>

      <button class="accordion">View Adviser</button> 
      <div class="panel">

         <br>

         <div id="adviser">
           
			<br>

			<?
            		$getAdviser = "SELECT * FROM StudentAdviser INNER JOIN User on User.userID = StudentAdviser.facultyID WHERE studentID = '$userID'";
            		$adviserResult = mysqli_query($dataBase, $getAdviser);
            		while ($adviserRow = mysqli_fetch_array($adviserResult)) { $adviserRows[] = $adviserRow; }

            		if( count( $adviserRows ) == 0 ){
            			print "<h1 style='text-align: center'>You have no Adviser</h1>";
            		}
            		else{
            			echo'
	            			<table class="table-fill">
						
							<thead>
								<tr>
									<th class="text-left">First Name</th>
									<th class="text-left">Last Name</th>
									<th class="text-left">Email</th>
									<th class="text-left">Phone Number</th>
								</tr>
							</thead>

							<tbody class="table-hover">
						';

	                  	foreach ($adviserRows as $adviserRow2) { 
	                  		$index = 0;

		                  	print "<tr>";
		                  	print "<td class='text-left' col-index=" . $index++ . ">" . $adviserRow2['firstName']  . "</td>";
		                  	print "<td class='text-left' col-index=" . $index++ . ">" . $adviserRow2['lastName']  . "</td>";
		                  	print "<td class='text-left' col-index=" . $index++ . ">" . $adviserRow2['email'] . "</td>";
		                  	print "<td class='text-left' col-index=" . $index++ . ">" . $adviserRow2['phoneNumber'] . "</td>";
		                  	print "</tr>";
	                  	}
			                  	
			            echo'
							</tbody>

							</table>

							<br>
						';
            		}
     

				?>

    	 </div>
      </div>

      <button class="accordion">View Grades</button> 
      <div class="panel">

         <br>

         <div id="grades">
           
			<br>

			<?
            		$getGrades = "SELECT * FROM CourseEnrollment 
		                         JOIN Section ON CourseEnrollment.sectionID = Section.sectionID 
		                         JOIN User ON Section.facultyID = User.userID 
		                         JOIN Course ON Section.courseID = Course.courseID 
		                         WHERE studentID = '$userID'
                                 AND termID = $semester";

            		$getGrades = mysqli_query($dataBase, $getGrades);
            		while ($gradesRow = mysqli_fetch_array($getGrades)) { $gradeRows[] = $gradesRow; }

            		if( count( $gradeRows ) == 0 ){
            			print "<h1 style='text-align: center'>You have no Adviser</h1>";
            		}
            		else{
            			echo'
	            			<table class="table-fill">
						
							<thead>
								<tr>
									<th class="text-left">Course Name</th>
									<th class="text-left">Midterm Grade</th>
									<th class="text-left">Final Grade</th>
								</tr>
							</thead>

							<tbody class="table-hover">
						';

	                  	foreach ($gradeRows as $gradeRows2) { 
	                  		$index = 0;

		                  	print "<tr>";
		                  	print "<td class='text-left' col-index=" . $index++ . ">" . $gradeRows2['courseName']  . "</td>";
		                  	print "<td class='text-left' col-index=" . $index++ . ">" . $gradeRows2['midtermGrade']  . "</td>";
		                  	print "<td class='text-left' col-index=" . $index++ . ">" . $gradeRows2['finalGrade'] . "</td>";
		                  	print "</tr>";
	                  	}
			                  	
			            echo'
							</tbody>

							</table>

							<br>
						';
            		}
     

			?>

    	 </div>
      </div>

      <button class="accordion">Schedule</button> 
      <div class="panel">

	   <?php

	      if($_POST['XXX'] == 2) {
	         

	      } else if($_POST['XXX'] == 1)  {


	      } else {

	         $sql = "SELECT a.firstname, a.lastname, c.termID, f.courseName, c.sectionNum, g.dayID, g.days, e.timeStart, e.timeEnd FROM User a 
	         INNER JOIN CourseEnrollment b on a.userID = b.studentID INNER JOIN Section c on b.sectionID = c.sectionID INNER JOIN Timeslot d 
	         on c.timeslotID = d.timeslotID INNER JOIN Time e on d.timeID = e.timeID INNER JOIN Course f on c.courseID = f.courseID INNER JOIN Day g on d.dayID = g.dayID 
	         WHERE a.userID =".$userID." AND c.termID =".$semester." ORDER BY e.timeStart, g.dayID";
	         $result6 = mysqli_query($dataBase, $sql);
	         $rowcount = mysqli_num_rows($result6);

	         $slot = array('07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00') ;
	         print "<br><table width='80%' align='center' if='schdulefaculty'>";
	         print "<tr>
	                   <th>Time</th>
	                   <th>Monday</th>
	                   <th>Tuesday</th>
	                   <th>Wednesday</th>
	                   <th>Thrusday</th>
	                   <th>Friday</th>
	                   <th>Saturday</th></tr>";

	         for($x = 0; $x <= 15; $x++) {

	             print "<tr><th>".$slot[$x]."</th>";
	             print "<th>";


	             $result6 = mysqli_query($dataBase, $sql);
	             while ($row6 = mysqli_fetch_array($result6)) {                            
	                     if(($row6['days'] =='M' || $row6['days'] == 'MW') && $slot[$x] == $row6['timeStart']){
	                         print $row6['courseName'];
	                     }
	               }
	                        print "</th><th>";

	             $result6 = mysqli_query($dataBase, $sql);
	             while ($row6 = mysqli_fetch_array($result6)) {                            
	                     if(($row6['days'] =='T' || $row6['days'] == 'TTH') && $slot[$x] == $row6['timeStart']){
	                         print $row6['courseName'];
	                     }
	               }
	                        print "</th><th>";

	             $result6 = mysqli_query($dataBase, $sql);
	             while ($row6 = mysqli_fetch_array($result6)) {                            
	                     if(($row6['days'] =='W' || $row6['days'] == 'MW') && $slot[$x] == $row6['timeStart']){
	                         print $row6['courseName'];
	                     }
	               }
	                        print "</th><th>";

	             $result6 = mysqli_query($dataBase, $sql);
	             while ($row6 = mysqli_fetch_array($result6)) {                            
	                     if(($row6['days'] =='TH' || $row6['days'] == 'TTH') && $slot[$x] == $row6['timeStart']){
	                         print $row6['courseName'];
	                     }
	               }
	                        print "</th><th>";

	             $result6 = mysqli_query($dataBase, $sql);
	             while ($row6 = mysqli_fetch_array($result6)) {                            
	                     if(($row6['days'] =='F') && $slot[$x] == $row6['timeStart']){
	                         print $row6['courseName'];
	                     }
	               }
	                        print "</th><th>";

	             $result6 = mysqli_query($dataBase, $sql);
	             while ($row6 = mysqli_fetch_array($result6)) {                            
	                     if(($row6['days'] =='S') && $slot[$x] == $row6['timeStart']){
	                         print $row6['courseName'];
	                     }
	               }
	                        print "</th></tr>";


	         }
	         print "</table>";
	         print "<input type='hidden' value='1' name='hiddenButtonAdvisor' id='XXX'>";
	         print "</form>";

	      }

	   ?>
	   
      </div>

      <button class="accordion">Transcript</button> 
      <div class="panel">

        <br>

        	<?php
        		// include 'Transcript.php';
        		// getTranscript();

        		$getGradesSQL = "SELECT * FROM CourseEnrollment 
                     JOIN Section ON CourseEnrollment.sectionID = Section.sectionID 
                     JOIN Course ON Section.courseID = Course.courseID 
                     WHERE studentID = $userID
                     AND finalGrade != 'F'";

		        $getGradesAgain = mysqli_query($dataBase, $getGradesSQL);

		        while ($gradesRow1 = mysqli_fetch_array($getGradesAgain)) { $gradeRows1[] = $gradesRow1; }

		        if( count( $gradeRows1 ) == 0 ){
		          print "<h1 style='text-align: center'>You have no Grades</h1>";
		        }
		        else{
		          echo'
		            <table class="table-fill">
		    
		            <thead>
		              <tr>
		                <th class="text-left">Course Name</th>
		                <th class="text-left">Final Grade</th>
		              </tr>
		            </thead>

		            <tbody class="table-hover">
		          ';

		          foreach ($gradeRows1 as $gradeRows3) { 
		                $index = 0;

		                print "<tr>";
		                print "<td class='text-left' col-index=" . $index++ . ">" . $gradeRows3['courseName']  . "</td>";
		                print "<td class='text-left' col-index=" . $index++ . ">" . $gradeRows3['finalGrade'] . "</td>";
		                print "</tr>";
		          }

		          echo'
		            <tr>
		              <td colspan="2" style="background:black; height:10px;"></td>
		            </tr>

		            <tr>
		              <td class="text-right">Total GPA</td>
		              <td>
	              '; 
		          print"" . totalGPA($gradeRows1) . "</td>
		            </tr>

		            <tr>
		              <td class='text-right'>Total credits</td>
		              <td>" . totalCredits( $gradeRows1 ) . "</td>
		            </tr>

		            </tbody>

		            </table>

		            <br>
		          " ;
		        }

		        function totalGPA( $grades ){
		        	$totalCredits = 0;
		        	$calculation = 0;

		        	foreach( $grades as $grade ){
		        		$totalCredits += $grade['creditHours'];
		        		$calculation += convertToNumber($grade['finalGrade']) * $grade['creditHours'];
		        	}

		        	return $calculation / $totalCredits;
		        }

		        function convertToNumber( $letter ){
		        	switch (strtoupper($letter)) {
		        		case 'A':
		        			return 4.0;
		        			break;

	        			case 'A-':
		        			return 3.67;
		        			break;

	        			case 'B+':
		        			return 3.33;
		        			break;

	        			case 'B':
		        			return 3;
		        			break;

	        			case 'B-':
		        			return 2.67;
		        			break;

	        			case 'C+':
	        				return 2.33;
		        			break;

	        			case 'C':
		        			return 2;
		        			break;

	        			case 'C-':
		        			return 1.67;
		        			break;

	        			case 'D+':
		        			return 1.33;
		        			break;

	        			case 'D':
		        			return 1;
		        			break;

	        			case 'D-':
		        			return 0.7;
		        			break;
		        		
		        		default:
		        			return 0.0;
		        			break;
		        	}
		        }

		        function totalCredits( $grades ){
		        	$totalCredits = 0;

		        	foreach( $grades as $grade ){
		        		$totalCredits += $grade['creditHours'];
		        	}

		        	return $totalCredits;
		        }

        	?>

        <br>

      </div>


      <script>
      	var acc = document.getElementsByClassName("accordion");
		var i;

		for (i = 0; i < acc.length; i++) {
		    acc[i].onclick = function(){
		        this.classList.toggle("active");
		        this.nextElementSibling.classList.toggle("show");
		    }
		}
	</script>
	</body>
   
</html>