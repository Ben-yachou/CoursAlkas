<?php
//pour récupérer une session déjà ouverte, on utilise également session_start();
//Si la session est déjà commencée, alors session_start() la récuperera au lieu d'en créer une nouvelle
session_start();

//on vérifie que notre panier existe
if (isset($_SESSION['panier'])){
    $_SESSION['panier'][] = 'pâtes';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Page 2 </title>
</head>
<body>
    <a href="page1.php">page 1</a>
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