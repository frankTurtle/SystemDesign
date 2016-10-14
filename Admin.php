<?php
   include('Session.php');
?>
<html">
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $login_session; ?></h1> 
      <h2><a href = "Logout.php">Sign Out</a></h2>
      
      <p>Admin page</p>
   </body>
   
</html>