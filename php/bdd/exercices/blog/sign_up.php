<?php
session_start();
include('display.php');
displayHeader('Sign Up');
displayNav();
displayMessages();

?>
<form method="post" action="sign_up_process.php">
    <label for="username">Username</label>
    <input id="username" name="username" type="text">
    <label for="password">Password</label>
    <input id="password" name="password" type="password">
    <label for="password_confirm">Confirm Password</label>
    <input id="password_confirm" name="password_confirm" type="password">
    <input type="submit" value="Sign Up">
</form>
<?php
displayFooter();
