<?php
session_start();

if ($_SESSION['userid']) {
    $userid = $_SESSION['userid'];

    if (isset($_POST['content']) && isset($_POST['id'])) {

        $content = $_POST['content'];
        $id = $_POST['id'];

        if (!empty($content) && !empty($id)) {
            include("db/db.php");
            $dbh = getDatabaseHandler();
            $user = $dbh->getUserById($userid);

            //on vérifie si le commentaire existe
            if ($comment = $dbh->getComment($id)) {
                //on vérifie que l'auteur soit bien l'utilisateur connecté
                if ($comment->author->id == $user->id) {
                    //si c'est le cas on met à jour notre article
                    $dbh->updateComment($id, $content);
                    header('Location: view.php?id=' . $comment->article->id);
                    exit;
                } else {
                    die('You are not the author of this comment');
                }
            } else {
                http_response_code(404);
                die('Comment not found');
            }
        }
    }
} else {
    //si aucun user n'est trouvé dans la session on redirige vers la page de connexion
    header('Location: sign_in.php');
}
