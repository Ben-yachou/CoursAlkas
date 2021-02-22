<?php
//lecture en base de données des messages et affichage
//chaque message sur une ligne écrite de la façon suivante
// auteur1: message1
// auteur2: message2

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=mini_chat;charset=utf8',
        'root',
        'password'
    );
} catch (PDOException $exception) {
    die($exception->getMessage());
}
//la requête imbriquée nous permet de faire un SELECT sur le résultat d'un autre SELECT
//de façon a pouvoir réorganiser le premier résultat dans un ordre différent 
//cela permet d'organiser les messages dans le bon ordre pour notre chat
$queryText = "SELECT t.* FROM (SELECT * FROM message ORDER BY id DESC LIMIT 10)t ORDER BY id ASC";
$query = $pdo->prepare($queryText);
$query->execute();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Chat</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" media="screen" href="chat.css">
</head>

<body>
    <div class="container">
        <ul>
            <?php
            while ($data = $query->fetch()) {
                echo '<li>'. date("H:i", $data['time'] + 7200) .' - <span>' . $data['author'] . ' :</span> ' . $data['message'] . '</li>';
            }
            ?>
        </ul>
        <form action="traitement.php" method="post">
            <label>
                Pseudo
                <input type="text" name="author">
            </label>
            <label>
                Message
                <input type="text" name="message">
            </label>

            <input type="submit" value="Envoyer">
        </form>
    </div>
</body>


</html>