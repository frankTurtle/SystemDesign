<!--
Barret J. Nobel
System Design
October 9th, 2016
Professor Naresh Gupta
-->

<?php
   define('DB_SERVER', 'fdb12.biz.nf');
   define('DB_USERNAME', '2102429_sysdsn');
   define('DB_PASSWORD', 'systemDesignGupta1234');
   if( !( $dataBase = mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD) )
   		die( 'Could not connect to database' );
?>