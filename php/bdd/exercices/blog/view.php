<?php
session_start();
include("db/db.php");
include('display.php');


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    //récupération des données des articles
    $dbh = getDatabaseHandler();
    $article = $dbh->getArticle($id);
    if ($article) {
        if (isset($_SESSION['userid'])) {
            $user = $dbh->getUserById($_SESSION['userid']);
        } else {
            $user = null;
        }

        $images = $dbh->getImagesByArticle($article);


        //affichage de la page
        displayHeader('Home');
        displayNav($user);
        displayArticle($article, $user);
        foreach ($images as $image) {
            echo "<img height='50px' width='50px' src='{$image->path}'>";
        }
        var_dump($images);

        if (isset($_SESSION['userid'])) {
?>
            <form method="post" action="post_comment_process.php">
                <label for="content">
                    content
                </label>
                <textarea name="content" id="content"></textarea>
                <input type="hidden" name="article" value="<?= $article->id ?>" />
                <input type="submit" value="Post Article">
            </form>
<?php
        }
        $comments = $dbh->getCommentsByArticle($article);
        displayComments($comments, $user);
        displayFooter();
    }
}
