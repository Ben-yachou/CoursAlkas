<?php
include('includes/bdd.php');
if (isset($_POST['user']) && isset($_POST['password'])){
    $user = $_POST['user'];
    $password = $_POST['password'];

    $pdo = bddConnect();

    //si on récupère une ligne de données c'est que l'utilisateur existe 
    if ($data = getUserFromUsernameOrEmail($pdo, $user)){
        //une fois l'utilisateur trouvé on peut comparer le mot de passe du formulaire
        //au mot de passe haché contenue dans la base à l'aide de password_verify()
        if (password_verify($password, $data['password'])){
            //si le mot de passe correspond alors l'utilisateur est connecté
            session_start(); //on commence une session de connexion pour l'utilisateur
            $_SESSION['user_id'] = $data['id']; //on stocke l'id de l'utilisateur
            $_SESSION['sign_in_time'] = time(); //on stocke l'heure de la connexion
            header('Location: articles.php'); //on envoie l'user vers l'accueil
        }
    } else {
        $error = "Utilisateur introuvable";
        header('Location: signIn.php?error='.$error);
    }
}