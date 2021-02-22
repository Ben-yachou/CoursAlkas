<?php
session_start();
if (isset($_SESSION['userid'])) {
    header('Location: index.php');
    //on quitte prématurément car on sait qu'on ne va pas rester sur sign_in.php
    //on évite donc d'exécuter des choses inutiles
    exit;
}
include('display.php');
displayHeader('Sign In');
displayNav()
?>
<form method="post" action="sign_in_process.php">
    <label for="username">Username</label>
    <input id="username" name="username" type="text">
    <label for="password">Password</label>
    <input id="password" name="password" type="password">
    <input type="submit" value="sign in">
</form>
<?php
displayFooter();
