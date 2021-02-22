<?php
session_start();

//si un utilisateur est connecté on le redirige
if (isset($_SESSION['userid'])) {
    header('Location: index.php');
}

$page_title = "Inscription";
require_once('head.php');
?>

<form action="signup.php" method="POST">
    <label for="nickname">Pseudo</label>
    <input id="nickname" name="nickname" type="text">
    <label for="password">Mot de passe</label>
    <input id="password" name="password" type="password">
    <label for="password_repeat">Confirmer mot de passe</label>
    <input id="password_repeat" name="password_repeat" type="password">
    <input type="submit" value="Inscription">
</form>
</body>

</html>