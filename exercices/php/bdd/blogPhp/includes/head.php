<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css">
    <title>
        <?php
        echo $pageTitle;
        ?>
        - Blog
    </title>
</head>

<body>
    <?php
    if (isset($_GET['message'])) {
        ?>
        <div class="messages">
            <?php echo $_GET['message']; ?>
        </div>
    <?php
}
?>
    <nav>
        <ul>
            <li><a href="articles.php">Accueil</a></li>
            <?php
            if (isset($_SESSION['user_id'])) {
                ?>
                <li><a href="articleForm.php">Poster</a></li>
                <li><a href="signOut.php">Deconnexion</a></li>
                <?php
        } else {
            ?>
                <li><a href="signIn.php">Connexion</a></li>
                <li><a href="signUp.php">Inscription</a></li>
            <?php
        }
        ?>
        </ul>
    </nav>