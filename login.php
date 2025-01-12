
<?php include('header.php'); ?>
<div class="login-container">
<form action="function.php?op=checklogin" method="post">
    
    <label for="username">User Name:</label>
    <input type="text" name="username" id="username" required>
    <br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <br>
    <input type="submit" value="Login">

</form>
</div>
<?php include('footer.php'); ?>
