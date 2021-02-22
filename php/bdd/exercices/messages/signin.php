<?php
require_once("dbconnect.php");

if (isset($_POST['nickname']) && isset($_POST['password'])) {

    $nickname = $_POST['nickname'];
    $password = $_POST['password'];

    if (!empty($nickname) && !empty($password)) {

        $dbh = dbConnect("messageboard", "messageboard", "Ge5z8YclkqXS8AWJ");

        //pour connecter un utilisateur il faut que celui ci existe
        //on fait donc une requête en ce sens
        $get_user = "SELECT * FROM user WHERE nickname = :nickname";
        $stmt = $dbh->prepare($get_user);

        $stmt->execute([
            ":nickname" => $nickname
        ]);

        //on récupère notre ligne de résultat
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) { //si on recup quelque chose
            //on vérifie le mot de passe avec password_verify qui va comparer le mot de passe en clair avec le mot de passe haché de la bdd
            if (password_verify($password, $user["password"])) {
                //si le mot de passe est bien le bon, on peut commencer une session, ou rediriger ou faire ce qu'on veut
                session_start();
                //on enregistre l'id de l'utilisateur dans la session
                $_SESSION["userid"] = $user["id"];
                header('Location: index.php');
            } else {
                echo "nom d'utilisateur ou mot de passe erronés";
            }
        } else {
            echo "nom d'utilisateur ou mot de passe erronés";
        }
    } else {
        echo "erreur valeur vide";
    }
} else {
    echo "erreur formulaire";
}
