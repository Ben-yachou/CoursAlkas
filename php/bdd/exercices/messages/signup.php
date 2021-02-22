<?php
require_once("dbconnect.php");

if (isset($_POST['nickname']) && isset($_POST['password']) && isset($_POST['password_repeat'])) {

    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];

    if (!empty($nickname) && !empty($password) && !empty($password_repeat)) {

        if ($password === $password_repeat) {

            //on hache le mot de passe, hacher le mot de passe reviens à le chiffrer de manière irréversible
            //on ne stocke jamais le mot de passe en clair mais uniquement son hash dans la base de données
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $dbh = dbConnect("messageboard", "messageboard", "Ge5z8YclkqXS8AWJ");

            $insert_user = "INSERT INTO user (nickname, password) VALUES (:nickname, :password)";
            $stmt = $dbh->prepare($insert_user);

            $stmt->execute([
                ":nickname" => $nickname,
                ":password" => $password_hash
            ]);

            //ce petit test nous permet de vérifier si une contrainte d'unicité (sur un pseudo/email par exemple) a été déclenchée
            //si c'est le cas, le code d'état 23000 sera renvoyé dans errorInfo (23000 veut dire contrainte violée)
            //et le code d'erreur 1062 pour contrainte d'unicité le sera également (1062 veut dire contrainte d'unicité)
            if ($stmt->errorInfo()[0] === "23000" && $stmt->errorInfo()[1] === 1062) {
                //on peut donc envoyer un petit message ou rediriger ou faire ce qu'on veut
                echo $nickname . " existe déjà !";
            }

            header("Location: signin_form.php");
        } else {
            echo "erreur mots de passe";
        }
    } else {
        echo "erreur valeur vide";
    }
} else {
    echo "erreur formulaire";
}
