<?php
session_start();

//si un utilisateur est connecté on le redirige
if (isset($_SESSION['userid'])) {
    header('Location: index.php');
}
$page_title = "Connexion";
require_once('head.php');
?>


<form action="signin.php" method="POST">
    <label for="nickname">Pseudo</label>
    <input id="nickname" name="nickname" type="text">
    <label for="password">Mot de passe</label>
    <input id="password" name="password" type="password">
    <input type="submit" value="Connexion">
</form>

</html>