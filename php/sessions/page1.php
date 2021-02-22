<?php
//une session en PHP est un moyen d'utiliser un stockage de variables qui serait accessible sur toutes les pages de notre site
//Cela nous permettrait essentiellement de "transmettre" des données ou un état d'une page à une autre 
//Une session est sensée représenter une "session d'utilisation" d'une application web, c'est à dire de l'ouverture du site à la fermeture du site
// exemple : rester connecté entre deux pages d'un même site 

//pour démarrer une session, il faut utiliser session_start()
//attention : aucun texte ne doit être inscrit dans la page (pas de html, pas de echo, print etc) avant session_start
session_start();
//à la création d'une session, php génère un cookie PHPSESSID qui expire a la fermeture du navigateur, contenant un identifiant de session généré au moment de session_start(); qui permet de retrouver des données stockées sur le serveur
//les données stockées sur le serveur sont liées à ce PHPSESSID, et ne peuvent être accédées que grâce à lui

//pour modifier les données stockées dans la session, on utilise la superglobale $_SESSION, qui est un tableau associatif (à la manière de $_POST)

//si notre panier n'a pas déjà été créé
if (!isset($_SESSION['panier'])){
    $_SESSION['panier'] = []; //création d'un panier vide
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Page 1 </title>
</head>
<body>
    <a href="page2.php">page 2</a>
    <a href="destroy.php">destroy</a>

    <?php
        //on récupère ensuite la variable de session qui nous intéresse avec $_SESSION['clé']
        if (isset($_SESSION['panier'])){
            print_r($_SESSION['panier']);
        } else {
            print("Panier vide");
        }
    ?>

</body>
</html>