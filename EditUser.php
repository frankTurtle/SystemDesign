<?php
  //include connection file 
  include_once("Config.php");

  $columns = array( 'firstName', 'lastName', 'email', 'phoneNumber', 'typeOfUser' );

  $error = true;
  $colVal = '';
  $colIndex = 0;
  $rowId = 0;
  
  $msg = array('status' => !$error, 'msg' => 'Failed to update the Database');

  if(isset($_POST)){
    if(isset($_POST['val']) && !empty($_POST['val']) && $error) {
      $colVal = $_POST['val'];
      $error = false; 
    } 
    else { $error = true; }

    if( isset($_POST['index']) ) {
      $colIndex = $_POST['index'];
      $error = false;
    } 
    else { $error = true; }

    if(isset($_POST['id']) && !empty($_POST['id']) ) {
      $rowId = $_POST['id'];
      $error = false;
    } 
    else { $error = true; }
  
    if(!$error) {
        $sql = "UPDATE User SET ". $columns[ $colIndex ] ." = '".$colVal."' WHERE userID='".$rowId."'";

        $status = mysqli_query($dataBase, $sql) or die("database error:". mysqli_error($dataBase));
        $msg = array('status' => !$error, 'msg' => 'Successfully updated Database');
    }
  }
  
  // send data as json format
  echo json_encode($msg);
?>