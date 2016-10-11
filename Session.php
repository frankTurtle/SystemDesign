<?php
   include('Config.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];

   debug_to_console( $user_check );
   
   $ses_sql = mysqli_query($dataBase,"SELECT firstName from User where email = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['firstName'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:Login.php");
   }

   function debug_to_console( $data ) {
        if ( is_array( $data ) )
            $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

        echo $output;
    }
?>