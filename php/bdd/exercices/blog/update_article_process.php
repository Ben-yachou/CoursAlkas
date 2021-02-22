<?php
session_start();

if ($_SESSION['userid']) {
    $userid = $_SESSION['userid'];

    if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['id'])) {

        $title = $_POST['title'];
        $content = $_POST['content'];
        $id = $_POST['id'];

        if (!empty($title) && !empty($content) && !empty($id)) {
            include("db/db.php");
            $dbh = getDatabaseHandler();
            $user = $dbh->getUserById($userid);

            //on vérifie si l'article existe
            if ($article = $dbh->getArticle($id)) {
                //on vérifie que l'auteur soit bien l'utilisateur connecté
                if ($article->author->id == $user->id) {
                    //si c'est le cas on met à jour notre article
                    $dbh->updateArticle($id, $title, $content);
                } else {
                    die('You are not the author of this article');
                }
            } else {
                http_response_code(404);
                die('Article not found');
            }
        }
    }
} else {
    //si aucun user n'est trouvé dans la session on redirige vers la page de connexion
    header('Location: sign_in.php');
}

//tout autre cas de figure renvoie a l'accueil
header('Location: index.php');
