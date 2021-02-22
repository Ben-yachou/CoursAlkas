<?php
require_once('dbconnect.php');
session_start();

//si notre utilisateur est connecté
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];

    if (isset($_POST['message'])) {
        if (!empty($_POST['message'])) {
            $message = $_POST['message'];

            require_once('databaseHandler.php');
            $dbh->sendMessage($message, $userid);

            header('Location: index.php');
        }
    }
} else {
    //si un utilisateur n'est pas connecté on le redirige
    //cela permet de s'assurer du bon fonctionnement de l'application en cas d'expiration de la session
    header('Location: signin_form.php');
}
