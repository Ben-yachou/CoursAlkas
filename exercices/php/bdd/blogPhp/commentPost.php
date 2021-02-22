<?php
session_start();
include('includes/bdd.php');
//on vérifie que l'utilisateur soit bien connecté
if (isset($_SESSION['user_id'])){
    //si c'est le cas on récupère ses infos dans la bdd
    $pdo = bddConnect();
    $user = getUserById($pdo, $_SESSION['user_id']);
    //si les infos du formulaire sont présentes
    if (isset($_POST['content']) && isset($_POST['id_article']) && isset($_POST['author']) ){
        //et si l'utilisateur connecté est bien l'auteur
        if ($_POST['author'] == $user['username']){
            $content = $_POST['content'];
            $id_article = $_POST['id_article'];
            $author = $_POST['author'];

            //on peut créer le commentaire
            //si le commentaire n'a pu être créé on gère l'erreur
            if (!createComment($pdo, $content, $author, $id_article)){
                $error = "Votre commentaire n'a pas pu être posté, veuillez reessayer plus tard";
            }

            //si une erreur est survenue
            if (isset($error)){
                header('Location: articleView.php?id='.$id_article.'&error='.$error);
            } else {
                header('Location: articleView.php?id='.$id_article);
            }
        } else {
            //si l'auteur n'est pas l'utilisateur connecté on redirige
            header('Location: articleView.php?id='.$_POST['id_article']);
        }
    }
} else {
    //si la session n'est pas disponible, on redirige avec un message
    $error = "La session a expiré, veuillez vous reconnecter";
    header('Location: signIn.php?error='.$error);
}