<?php
   include('Session.php');

   if($_SERVER["REQUEST_METHOD"] == "POST") {
   		$subject = $_POST['sectionID'];
   		$term = $_POST['termID'];
   		$gradesTable = "";

	    $getGradesSQL = "SELECT * FROM CourseEnrollment 
						JOIN Section ON CourseEnrollment.sectionID = Section.sectionID 
						JOIN Course ON Section.courseID = Course.courseID
						WHERE termID = '$term'
						AND CourseEnrollment.sectionID = '$subject'";

		$getGradesAgain = mysqli_query($dataBase, $getGradesSQL);

		while ($gradesRow1 = mysqli_fetch_array($getGradesAgain)) { $gradeRows1[] = $gradesRow1; }

		if( count( $gradeRows1 ) == 0 ){
		  $gradesTable = "<h1 style='text-align: center'>There are no Grades</h1>";
		}
		else{
		  $gradesTable .= "
		    <table class='table-fill'>

		    <thead>
		      <tr>
		        <th class='text-left'>Course Name</th>
		        <th class='text-left'>Midterm Grade</th>
		        <th class='text-left'>Final Grade</th>
		      </tr>
		    </thead>

		    <tbody class='table-hover'>
		  ";

		  foreach ($gradeRows1 as $gradeRows3) { 
		        $index = 0;

		        $gradesTable .= "<tr>";
		        $gradesTable .= "<td class='text-left' col-index=" . $index++ . ">" . $gradeRows3['courseName']  . "</td>";
		        $gradesTable .= "<td class='text-left' col-index=" . $index++ . ">" . $gradeRows3['midtermGrade']  . "</td>";
		        $gradesTable .= "<td class='text-left' col-index=" . $index++ . ">" . $gradeRows3['finalGrade'] . "</td>";
		        $gradesTable .= "</tr>";
		  }

		  $gradesTable .= "

		    </tbody>

		    </table>
		  " ;
		}
	}
?>
<html>

	<head>
     <link rel="stylesheet" type="text/css" href="css/student.css">
     <script src="javascript/admin.js" type="text/javascript"></script>
     <script src="javascript/research.js" type="text/javascript"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <title>Research</title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $login_session; ?></h1>

      <ul>
        <li><a class="active" href="Research.php">Home</a></li>
        <li><a class="active" href="PasswordReset.php">Reset Password</a></li>
        <li><a class="active" href = "Logout.php">Sign Out</a></li>
      </ul>

      <h1>Research</h1>

      <div>

        <br>

        <div>

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

	               	<select id='subject' name='sectionID' style='display:none'></select>

               	<input type="submit" value="RESEARCH" id="submitButton">

        	</form>

        </div>

        <hr>
        <br>

        <div id="displayGrades"></div>

        	<?php
        		echo $gradesTable;
        	?>

		<br>

      </div>
   </body>
   
</html>