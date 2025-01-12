<?php include('dbConnect.php'); 
session_start()
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <link rel="stylesheet" href="css/css.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>uqmj</title>
</head>
<body>
<nav>
<div class="brand">UQMJ</div>
<div class="nav-links">
    <ul class="publicMenu">
        <li><a href="index.php">Home</a></li>
    </ul>
    <ul class="privateMenu">
        <?php
        if($_SESSION){
            echo '<li><a href="function.php?op=logout">Logout</a></li>';
            echo '<li><a href="history.php">history</a></li>';
        }
        else{
            echo '<li><a href="login.php">Staff Login</a></li>';
        }
        ?>
        <!-- <li><a href="logout.php">Logout</a></li>
        <li><a href="history.php">ehistory</a></li> -->
    </ul>
    </div>
</nav>