<?php
//on récupère notre session
session_start();
//on vérifie qu'un auteur soit bien connecté
if (isset($_SESSION['userid'])) {

    if (isset($_POST['article']) && isset($_POST['content'])) {

        $article_id = $_POST['article'];
        $content = $_POST['content'];

        if (!empty($article_id) && !empty($content)) {

            include("db/db.php");
            $dbh = getDatabaseHandler();

            $author = $dbh->getUserById($_SESSION['userid']);
            $article = $dbh->getArticle($article_id);
            if ($author) {
                $dbh->createComment($content, new DateTime(), $author, $article);
            } else {
                //A remplacer par une vraie page d'erreur
                die('Author does not exist');
            }
            header('Location: view.php?id=' . $article->id);
        }
    }
} else {
    //si aucun user n'est trouvé dans la session on redirige vers la page de connexion
    header('Location: sign_in.php');
}
