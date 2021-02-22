<?php
    //gérer l'insertion des messages envoyés
    //par formulaire dans la bdd

    //après l'insertion en bdd du message 
    //la redirection vers la page chat.php
    //se fait à l'aide de la fonction header
if (isset($_POST['author']) && isset($_POST['message'])){
    $author = $_POST['author'];
    $message = $_POST['message'];

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=mini_chat;charset=utf8', 'root', 'password');
    } catch (PDOException $exception){
        die($exception->getMessage());
    }

    $query = $pdo->prepare('INSERT INTO message (author, message, time) VALUES (:author, :message, :time)');
    $query->execute([
        ":author" => $author, 
        ":message" => $message,
        ":time" => time() //time() renvoie le nombre de secondes depuis le 1/01/1970
        ]);
}
//redirection vers la page du chat
header('Location: chat.php');