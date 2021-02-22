<?php

if (isset($_POST['user']) && isset($_POST['password'])){
    $user = $_POST['user'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'password');
    } catch (PDOException $exception){
        die($exception->getMessage());
    }

    $query = $pdo->prepare('SELECT * FROM user WHERE username = :user OR email = :user');

    $query->execute([
        ":user" => $user
    ]);
    
    //si on récupère une ligne de données c'est que l'utilisateur existe 
    if ($data = $query->fetch()){
        //une fois l'utilisateur trouvé on peut comparer le mot de passe du formulaire
        //au mot de passe haché contenue dans la base à l'aide de password_verify()
        if (password_verify($password, $data['password'])){
            //si le mot de passe correspond alors l'utilisateur est connecté
            session_start(); //on commence une session de connexion pour l'utilisateur
            $_SESSION['user_id'] = $data['id']; //on stocke l'id de l'utilisateur
            $_SESSION['sign_in_time'] = time(); //on stocke l'heure de la connexion
            header('Location: userPage.php'); //on envoie l'user vers son espace membre
        }
    }
}