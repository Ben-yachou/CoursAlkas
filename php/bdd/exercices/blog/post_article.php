<?php
session_start();
if (isset($_SESSION['userid'])) {
    include('display.php');
    include('db/db.php');
    $user = getDatabaseHandler()->getUserById($_SESSION['userid']);
    if ($user) {
        //affichage de l'en tête et du nav
        displayHeader('Post New Article');
        displayNav($user)
?>
        <form enctype="multipart/form-data" method="post" action="post_article_process.php">
            <label for="title">
                title
            </label>
            <input type="text" name="title" id="title">
            <label for="content">
                content
            </label>
            <textarea name="content" id="content"></textarea>
            <input type="file" name="image" accept="image/jpeg, image/png, image/gif">
            <input type="submit" value="Post Article">
        </form>
<?php
        //affichage du footer
        displayFooter();
    } else {
        header('Location: sign_in.php');
    }
} else {
    header('Location: sign_in.php');
}
