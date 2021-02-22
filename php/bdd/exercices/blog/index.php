<?php
session_start();
include("db/db.php");
include('display.php');

//récupération des données des articles
$dbh = getDatabaseHandler();
$articles = $dbh->getArticles();
if (isset($_SESSION['userid'])) {
    $user = $dbh->getUserById($_SESSION['userid']);
} else {
    $user = null;
}


//affichage de la page
displayHeader('Home');
displayNav($user);


displayArticles($articles, $user);

displayFooter();
