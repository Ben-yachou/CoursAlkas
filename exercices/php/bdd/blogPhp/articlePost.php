<?php
session_start();
if (isset($_SESSION['user_id'])){
    include('includes/bdd.php');
    $pdo = bddConnect();
    $user = getUserById($pdo, $_SESSION['user_id']);

    if (isset($_POST['title']) && isset($_POST['content'])) {
        $title = $_POST['title'];
        $author = $user['username'];
        $content = $_POST['content'];
        
        $pdo = bddConnect();
        createArticle($pdo, $title, $content, $author, NULL);
        
        header('Location: articles.php');
    }
} else {
    $message = "Vous devez être connecté pour poster un article";
    header('Location: articles.php?message='.$message);
}
    