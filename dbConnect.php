<?php 
$dbConnection = mysqli_connect('localhost', 'gaster', 'gaster_pass', 'uqmj');

if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

//echo "Connected successfully";

mysqli_set_charset($dbConnection, 'utf8');
?>
