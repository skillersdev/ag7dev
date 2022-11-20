<?php
 $dbhost = 'localhost';
 $dbuser = 'root';
 $dbpass = '';
 $db_name='thrabcse_new';
 $con = mysqli_connect($dbhost, $dbuser, $dbpass,$db_name);

 if(! $con ){
    die('Could not connect: ' . mysqli_error());
 }
 //echo 'Connected successfully';
 //mysqli_close($conn);
?>