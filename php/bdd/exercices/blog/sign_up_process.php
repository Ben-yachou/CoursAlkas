<?php
session_start();
include('messageHandler.php');
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirm'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (!empty($username) && !empty($password) && !empty($password_confirm)) {
        if ($password === $password_confirm) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            //on récupère le gestionnaire de base de données
            include("db/db.php");
            $dbh = getDatabaseHandler();

            //on tente de créer un utilisateur
            try {
                $dbh->createUser($username, $password_hash);
            } catch (Exception $e) {
                //on enregistre un message dans la session
                MessageHandler::addMessage($e->getMessage(), MessageHandler::M_ERROR);
                //et on redirige
                header('Location: sign_up.php');
                exit;
            }

            //si tout va bien on renvoie vers la page de connexion
            header('Location: sign_in.php');
            exit;
        } else {
            //on enregistre un message dans la session
            MessageHandler::addMessage("The passwords must match !", MessageHandler::M_ERROR);
            //et on redirige
            header('Location: sign_up.php');
            exit;
        }
    }
}
header('Location: sign_up.php');
