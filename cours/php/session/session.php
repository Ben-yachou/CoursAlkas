<?php
//on initialise la session à l'aide de la fonction
//session_start()
//session_start() doit être appelé avant 
//le code html
session_start();

//pour définir le temps d'expiration d'une session on utilise
//session_cache_expire()
//session_cache_expire(30); //la session expirera dans 30min

//on stocke des valeurs de session à l'aide de $_SESSION
$_SESSION['pseudo'] = '1trucopif';

$panier = ['article1', 'article2', 'article3'];
$_SESSION['panier'] = $panier;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>page</title>
</head>
<body>
    <nav>
        <a href="session2.php">Session 2</a>
        <a href="sessionDestroy.php">Déconnexion</a>
    </nav>

    <p>Coucou <?php echo $_SESSION['pseudo'] ?></p>

    <p> Contenu du panier : 
    <?php
    //si un panier existe
    if (isset($_SESSION['panier'])){
        for ($i = 0; $i < count($_SESSION['panier']); $i++){
            echo $_SESSION['panier'][$i];
            echo '<br/>';
        }
    }    
    ?>
</body>
</html>