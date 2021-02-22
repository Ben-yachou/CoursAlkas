<?php

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        include("db/db.php");
        $dbh = getDatabaseHandler();

        $user = $dbh->getUserByUsername($username);

        if ($user) {
            if (password_verify($password, $user->password)) {
                session_start();
                $_SESSION["userid"] = $user->id;
                header('Location: index.php');
            } else {
                header('Location: sign_in.php');
            }
        } else {
            header('Location: sign_in.php');
        }
    }
}
