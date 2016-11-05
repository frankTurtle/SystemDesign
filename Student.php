<?php
   include('Session.php');
?>
<html>

	<head>
     <link rel="stylesheet" type="text/css" href="css/student.css">
     <script src="javascript/admin.js" type="text/javascript"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <title>Student Page</title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $login_session; ?></h1>

      <ul>
        <li><a class="active" href="Student.php">Home</a></li>

        <!-- <li class="dropdown">
          <a href="#" class="dropbtn">Menu</a>
          <div class="dropdown-content">
           <a href=# onclick="javascript:generateNewUserForm()">Add New User</a>
           <a href=# onclick="createCourse();">Add New Course</a>
           <a href=# onclick="createSection();">Add New Section</a>
          </div>
        </li> -->

        <li><a class = "active" href = "Logout.php">Sign Out</a></li>
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

      <button class="accordion">Add or Drop Classes</button> 
      <div class="panel">

         <br>

         <div id="holdsDive">
            <div id="sliderResult" class="transition">

            	<form method="post" action="" id="addOrDropClassForm">

                   	<select id='termID' name='termID' onchange="getSubject(this.value, subject);">
                       	<option selected="selected">Choose A Term</option>

	                  	<?
		                    $termSql = "SELECT * FROM Term";
		                  	$termResult = mysqli_query($dataBase, $termSql);

		                	while ($termRow = mysqli_fetch_array($termResult)) { $termRows[] = $termRow; }
		                  	foreach ($termRows as $rowTerm) { 
		                    	print "<option value='" . $rowTerm['termID'] . "'>" . $rowTerm['semester'] . " " . $rowTerm['year'] . "</option>";
		                  	}
		               ?>

 	               	</select>

 	               	<select id='subject' name='subject' style='display:none'>

	               	<input type="submit" value="Register" id="submitButton">

            	</form>
			</div>

			<br>

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

     	function getSubject( term, unhideThis ){
     		document.getElementById("subject").innerHTML = "";
     		document.getElementById("subject").style.display = '';

			$.ajax({
					type: 'POST',
					url: 'GetSubject.php',
					data: {
						  termSelected:term
			 		},

			 		success:
			 		function (response) {
			  			document.getElementById("subject").innerHTML = response; 
		 			}
			});
		}

    </script>

	</body>
   
</html>