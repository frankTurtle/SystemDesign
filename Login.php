<?php 
   include("Config.php");
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = $_POST['emailAddress'];
      $mypassword = $_POST['password']; 

      // $sql = "SELECT userID FROM User WHERE email = 'admin@email.com' and password = 'admin'";
      $sql = "SELECT * FROM User WHERE email = '$myusername' and password = '$mypassword'";
      // $sql = "SELECT * FROM User WHERE email = * and password = *";

      $result = mysqli_query( $dataBase, $sql );
      // $row = mysqli_fetch_array( $result, MYSQLI_ASSOC );
      // $active = $row['active'];
      
      $count = mysqli_num_rows( $result );

      // debug_to_console( mysqli_fetch_assoc($result) );
      
      // If result matched $myusername and $mypassword, table row must be 1 row
        
      if($count == 1) {
        session_start();
         $_SESSION['login_user'] = $myusername;
         
         header( 'Location: Welcome.php' );
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }

    function debug_to_console( $data ) {
        if ( is_array( $data ) )
            $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

        echo $output;
    }

?>
<html>
   
   <!-- define the meta data -->
    <head>
        <meta charset = "utf-8">
        <meta name = "description" content = "Login">
        <meta name = "keywords" content = "HTML5, login">
        <meta name = "author" content = "Barret J. Nobel">

        <!-- link to the stylesheet -->
        <link rel="stylesheet" type="text/css" href="styles/home.css">

        <!-- set the title of the page -->
        <title>Login</title>
    </head>
   
   <body bgcolor = "#FFFFFF">
    
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
                
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <label>Email Address  :</label><input type = "text" name = "emailAddress" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
                    
            </div>
                
         </div>
            
      </div>

   </body>
</html>