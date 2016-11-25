<?php
   include('Session.php');

   if($_SERVER["REQUEST_METHOD"] == "POST") {
   		$subject = $_POST['sectionID'];

   		$sql = "INSERT INTO `CourseEnrollment`( `studentID`, `sectionID` )
                 VALUES ( '$userID', '$subject');";

        $message = "Successfully Registered";
        $error = "Duplicate Entry, try again";

        if (mysqli_query($dataBase, $sql)) { echo "<script type='text/javascript'>alert('$message');</script>"; }
        else { echo "<script type='text/javascript'>alert('$message');</script>"; }
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
        <li><a class="active" href = "Logout.php">Sign Out</a></li>
        <li><a class="active" href="PasswordReset.php">Reset Password</a></li>
      </ul>

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

      <button class="accordion">Add / Drop / View Classes</button> 
      <div class="panel">

         <br>

         <div id="currentClassesDiv">
            <div id="sliderResult" class="transition">

            	<div id="currentClasses">
	            	<?
	            		$getCurrentClassesSQL = "SELECT * FROM CourseEnrollment 
	            		                         JOIN Section ON CourseEnrollment.sectionID = Section.sectionID 
	            		                         JOIN User ON Section.facultyID = User.userID 
	            		                         JOIN Room ON Section.roomID = Room.roomID 
	            		                         JOIN Course ON Section.courseID = Course.courseID 
	            		                         WHERE studentID = $userID";

	            		$currentClassesResult = mysqli_query($dataBase, $getCurrentClassesSQL);
	            		while ($classesRow = mysqli_fetch_array($currentClassesResult)) { $currentClassesRows[] = $classesRow; }

	            		if( count( $currentClassesRows ) == 0 ){
	            			print "<h1 style='text-align: center'>You're not currently enrolled in any classes</h1>";
	            		}
	            		else{
	            			echo'
	            				<h1 style="text-align: center">Here is your current schedule</h1>
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

			                  	print "<tr name='" . $classesRow['sectionID'] . "' data-row-id=" . $classesRow['sectionID'] . " id=" . $classesRow['sectionID'] . " class='toggler'>";
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
				                  	
				            echo'
								</tbody>

								</table>
							';
	            		}
	     

					?>
				</div>
				<br>

				<hr>

				<h1 style='text-align: center'>Add a new Class</h1>
            	<form method="post" action="" id="addOrDropClassForm">

                   	<select id='termID' name='termID' onchange="getSubject(this.value, subject);">
                       	<option selected="selected">Choose A Term</option>

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
		                         WHERE studentID = '$userID'";

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


      <script>
      	var acc = document.getElementsByClassName("accordion");
		var i;

		for (i = 0; i < acc.length; i++) {
		    acc[i].onclick = function(){
		        this.classList.toggle("active");
		        this.nextElementSibling.classList.toggle("show");
		    }
		}

		$(".toggler").click(function(e){
	        e.preventDefault();
	        $('.cat'+$(this).attr('data-row-id')).toggle();
	    });
	</script>
	</body>
   
</html>