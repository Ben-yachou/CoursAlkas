<?php
session_start();
if ($_SESSION['userid']) {
    $userid = $_SESSION['userid'];
    //si notre paramètre id est reçu dans l'adresse
    if ($_GET['id']) {
        $id = $_GET['id'];

        include("db/db.php");
        $dbh = getDatabaseHandler();
        $user = $dbh->getUserById($userid);
        $comment = $dbh->getComment($id);

        //si notre comment a été récupéré
        if ($comment) {
            //on vérifie si l'auteur du comment est bien l'utilisateur connecté
            if ($comment->author->id == $user->id) {
                $content = $comment->content;
            } else {
                die('You are not the author of this comment');
            }
        } else {
            //sinon on affiche que l'article n'a pas été trouvé
            http_response_code(404);
            die('Comment not found');
        }
    }
} else {
    //si aucun user n'est trouvé dans la session on redirige vers la page de connexion
    header('Location: sign_in.php');
    //on quitte prématurément car on sait qu'on ne va pas rester sur sign_in.php
    //on évite donc d'exécuter des choses inutiles
    exit;
}

include('display.php');
displayHeader('Update Comment');
displayNav($user)
?>
<form method="post" action="update_comment_process.php">
    <label for="content">
        content
    </label>
    <textarea name="content" id="content"><?= $content ?></textarea>
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="submit" value="Update Comment">
</form>

<?php
displayFooter();
