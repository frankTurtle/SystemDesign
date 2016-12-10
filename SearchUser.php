<?php
   include('Session.php');
   include("Config.php");
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      if($_POST['hiddenButton'] == 5){
         searchUser();
      }
   }

   function getCorrectUserType( $formType ){
         $ftFaculty = 0;
         $ptFaculty = 1;
         $ftStudent = 2;
         $ptStudent = 3;
         $admin     = 4;
         $research  = 5;
         switch ($formType) {
            case $ftFaculty:
            case $ptFaculty:
               return 2;
               break;
            
            case $ftStudent:
            case $ptStudent:
               return 3;
               break;
            case $admin:
               return 0;
               break;
            case $research:
               return 1;
               break;
         }
   }

   // function getUserTypeString( $numberIn ){

   // }

   function searchUser(){
      $formValuesDictionary = [
         "firstName"   => ( isset($_POST['firstNameInput']) ? $_POST['firstNameInput'] : -1 ),
         "lastName"    => ( isset($_POST['lastNameInput']) ? $_POST['lastNameInput'] : -1 ),
         "email"       => ( isset($_POST['emailInput']) ? $_POST['emailInput'] : -1 ),
         "phoneNumber" => ( isset($_POST['phoneInput']) ? $_POST['phoneInput'] : -1 ),
         "typeOfUser"  => ( ($_POST['userType'] !== "Type of User") ? getCorrectUserType($_POST['userType']) : -1 )
      ];

      $searchSql = "SELECT * FROM User ";

      foreach ($formValuesDictionary as $key => $value) {
         if( $value > -1 ){
               if( strpos($searchSql, 'WHERE') === false ){ $searchSql .= "WHERE "; }
               $searchSql .= "`$key` LIKE '%" . $value . "%' AND ";
         }
      }

      $finalSql = ( strpos($searchSql, 'AND') == true ) ? substr($searchSql, 0, -4) : $searchSql;

      return $finalSql;
   }
?>

<html>
   
   <head>
     <link rel="stylesheet" type="text/css" href="css/admin.css">
     <link rel="stylesheet" type="text/css" href="css/searchUser.css">
     <script src="javascript/admin.js" type="text/javascript"></script>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <title>Admin Page</title>
   </head>
   
   <body>
		<h1>Welcome <?php echo $login_session; ?></h1> 

		<ul>
			<li><a class="active" href="Search.php">Home</a></li>
			<li><a class = "active" href = "Logout.php">Sign Out</a></li>
		</ul>

		<button>slide</button>
		<script>
			$('button').on('click', function(){
			    $('#sliderResult').hide();
			    $('#searchUserDiv').toggleClass('editForm');
			})

			$(document).ready(function(){
			  $('td.text-left').on('focusout', function() {
			    data = {};
			    data['val'] = $(this).text();
			    data['id'] = $(this).parent('tr').attr('data-row-id');
			    data['index'] = $(this).attr('col-index');
			    
			    $.ajax({   
			          
			          type: "POST",  
			          url: "EditUser.php",  
			          cache:false,  
			          data: data,
			          dataType: "json",       
			          success: function(response)  
			          {   

			            if(response.status) {
			              $("#msg").removeClass('alert-danger');
			              $("#msg").addClass('alert-success').html(response.msg);
			            } else {
			              $("#msg").removeClass('alert-success');
			              $("#msg").addClass('alert-danger').html(response.msg);
			            }


			          }   
			        });
			  });
			});
		</script>

		<br>

		<div id="sliderResult" class="transition">
			<div id="msg"></div>
			<table class="table-fill">
				<thead>
					<tr>
						<th class="text-left">First Name</th>
						<th class="text-left">Last Name</th>
						<th class="text-left">Email Address</th>
						<th class="text-left">Phone Number</th>
						<th class="text-left">User Type</th>
					</tr>
				</thead>

				<tbody class="table-hover">
					<?
	                  	$result = mysqli_query($dataBase, searchUser());
	                  	while ($row = mysqli_fetch_array($result)) { $rows[] = $row; }

	                  	foreach ($rows as $row) { 
	                  		$index = 0;

		                  	print "<tr data-row-id=" . $row['userID'] . ">";
		                  	print "<td class='text-left' contenteditable='true' col-index=" . $index++ . ">" . $row['firstName'] . "</td>";
		                  	print "<td class='text-left' contenteditable='true' col-index=" . $index++ . ">" . $row['lastName'] . "</td>";
		                  	print "<td class='text-left' contenteditable='true' col-index=" . $index++ . ">" . $row['email'] . "</td>";
		                  	print "<td class='text-left' contenteditable='true' col-index=" . $index++ . ">" . $row['phoneNumber'] . "</td>";
		                  	print "<td class='text-left' contenteditable='true' col-index=" . $index++ . ">" . $row['typeOfUser'] . "</td>";
		                  	print "</tr>";
	                  	}
	               ?>
				</tbody>

				
			</table>
		</div>

		<!-- <div id="searchUserDiv" class="transitionForm">
            <form method="post" action="SearchUser.php" id="searchUserForm">
               <input name="firstNameInput" placeholder="First Name" id="firstName"><br>
               <input type="text" name="lastNameInput" placeholder="Last Name"><br>
               <input type="text" name="emailInput" placeholder="Email Address"><br>
               <input type="text" placeholder="Phone Number" name="phoneInput"><br>

               <select name="userType" required="true" id="selectTypeOfUser">
                  <option selected="selected">Type of User</option>
                  <option value="0">Full Time Faculty</option>
                  <option value="1">Part Time Faculty</option>
                  <option value="2">Full Time Student</option>
                  <option value="3">Part Time Student</option>
                  <option value="4">Administrator</option>
                  <option value="5">Research Office</option>
               </select>

               <input type="hidden" value="5" name="hiddenButton" id="hiddenButton">
               <input type="submit" value="Search" id="submitButton">
            </form>
         </div> -->

	</body>
 </html>