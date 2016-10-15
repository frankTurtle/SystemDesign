<?php
   define('DB_SERVER', 'fdb12.biz.nf');
   define('DB_USERNAME', '2102429_sysdsn');
   define('DB_DATABASE', '2102429_sysdsn');
   define('DB_PASSWORD', 'systemDesignGupta1234');
   $dataBase = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

   if ($dataBase->connect_error) { die("Connection failed: " . $conn->connect_error); } 
?>