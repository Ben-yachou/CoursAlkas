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
        $article = $dbh->getArticle($id);

        //si notre article a été récupéré
        if ($article) {
            //on vérifie si l'auteur de l'article est bien l'utilisateur connecté
            if ($article->author->id == $user->id) {
                $title = $article->title;
                $content = $article->content;
            } else {
                die('You are not the author of this article');
            }
        } else {
            //sinon on affiche que l'article n'a pas été trouvé
            http_response_code(404);
            die('Article not found');
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
displayHeader('Update Article');
displayNav($user)
?>
<form method="post" action="update_article_process.php">
    <label for="title">
        title
    </label>
    <input type="text" name="title" id="title" value="<?= $title ?>">
    <label for="content">
        content
    </label>
    <textarea name="content" id="content"><?= $content ?></textarea>
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="submit" value="Update Article">
</form>

<?php
displayFooter();
