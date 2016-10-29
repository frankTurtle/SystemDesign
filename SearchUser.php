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

   function searchUser(){
      $formValuesDictionary = [
         "firstName"   => ( isset($_POST['firstNameInput']) ? $_POST['firstNameInput'] : NULL ),
         "lastName"    => ( isset($_POST['lastNameInput']) ? $_POST['lastNameInput'] : NULL ),
         "email"       => ( isset($_POST['emailInput']) ? $_POST['emailInput'] : NULL ),
         "phoneNumber" => ( isset($_POST['phoneInput']) ? $_POST['phoneInput'] : NULL ),
         "typeOfUser"  => ( ($_POST['userType'] != "Type of User") ? getCorrectUserType($_POST['userType']) : NULL )
      ];

      $searchSql = "SELECT * FROM User ";

      foreach ($formValuesDictionary as $key => $value) {
         if( $value != NULL ){
               if( strpos($searchSql, 'WHERE') === false ){ $searchSql .= "WHERE "; }
               $searchSql .= "'$key' LIKE '%" . $value . "%' AND ";
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

		<br>
		
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
                  	print "<tr>";
                  	print "<td class='text-left'>" . $row['firstName'] . "</td>";
                  	print "<td class='text-left'>" . $row['lastName'] . "</td>";
                  	print "<td class='text-left'>" . $row['email'] . "</td>";
                  	print "<td class='text-left'>" . $row['phoneNumber'] . "</td>";
                  	print "<td class='text-left'>" . $row['typeOfUser'] . "</td>";
                  	print "</tr>";
                  }

               ?>
			</tbody>
		</table>

	</body>
 </html>