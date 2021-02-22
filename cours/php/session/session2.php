<?php
//pour récuperer une session on utilise également 
//session_start()
session_start();

//n'importe quelle page peut modifier les variables
//stockées dans $_SESSION
$_SESSION['panier'][] = 'article4';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>page</title>
</head>
<body>
    <nav>
        <a href="session.php">Session</a>
        <a href="sessionDestroy.php">Déconnexion</a>
    </nav>

    <p>Rebonjour <?php echo $_SESSION['pseudo'] ?></p>
<p> Contenu du panier : 
    <?php
    //si un panier existe
    //on vérifie que la clé 'panier' existe
    //dans le tableau $_SESSION
    if (isset($_SESSION['panier'])){
        for ($i = 0; $i < count($_SESSION['panier']); $i++){
            echo $_SESSION['panier'][$i];
            echo '<br/>';
        }
    }    
    ?>

</p>
</body>
</html>