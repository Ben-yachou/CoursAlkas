<?php
session_start();

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
    //si notre paramètre id est reçu dans l'adresse
    if ($_GET['id']) {
        $id = $_GET['id'];

        include("db/db.php");
        $dbh = getDatabaseHandler();

        //est ce que l'article existe
        $comment = $dbh->getComment($id);
        if ($comment) {
            //est ce que l'utilisateur connecté existe 
            $user = $dbh->getUserById($userid);
            if ($user) {
                //si l'auteur est bien l'utilisateur connecté
                if ($comment->author->id == $user->id || $comment->article->author->id == $user->id) {
                    $dbh->deleteComment($id);
                    header('Location: view.php?id=' . $comment->article->id);
                }
            }
        }
    }
} else {
    //si aucun user n'est trouvé dans la session on redirige vers la page de connexion
    header('Location: sign_in.php');
}
