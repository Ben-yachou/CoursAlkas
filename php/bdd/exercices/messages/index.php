<?php
require_once('dbconnect.php');

//on récupère la session
session_start();

//on vérifie que l'utilisateur est connecté 
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];

    //en récupérant notre fichier databaseHandler.php
    //on instancie un $dbh à nous qui contient toutes les méthodes nécessaire aux requêtes vers notre base
    require_once('databaseHandler.php');
    $messages = $dbh->getMessages(); //getMessages nous renvoie un tableau de messages
} else {
    //sinon on redirige vers la page de connexion
    header('Location: signin_form.php');
}

//on définit le titre de la page
$page_title = "Messages";
//de fait à ce que head.php puisse l'utiliser
require_once('head.php');
?>

<form action="send.php" method="POST">
    <fieldset>
        <legend>Envoyer un message</legend>
        <label for="message">
            Message
        </label>
        <input id="message" name="message" type="text">
    </fieldset>
    <input type="submit">

    <div class="messages">
        <?php
        require_once('display.php');
        //on appelle notre fonction displayMEssages pour renvoyer le html correspondant aux messages
        displayMessages($messages, $userid);
        ?>
    </div>
</form>
</body>

</html>