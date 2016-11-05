<?php
   include('Config.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];

   $ses_sql = mysqli_query($dataBase,"SELECT firstName, userID from User where email = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['firstName'];
   $userID = $row['userID'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:Login.php");
   }
?>