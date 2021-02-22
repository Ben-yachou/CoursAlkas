<?php
//on démarre notre session avant d'écrire du texte (sinon session_start ne fonctionne pas)
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title>Inscription plateforme</title>
</head>

<body>
    <?php
        //si on a bien quelque chose dans notre stockage de session
        if (isset($_SESSION['info'])){
            //on affiche notre message
            echo "Bienvenue, {$_SESSION['info']['firstname']} {$_SESSION['info']['lastname']}, vous êtes bien connectés sur la plateforme de {$_SESSION['info']['city']} {$_SESSION['info']['zip']}";
        } else { //sinon on affiche le formulaire
    ?>
    <form action="traitement.php" method="post">
        <label for="firstname">First Name</label>
        <input type="text" name="firstname" id="firstname">
        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" id="lastname">
        <label for="email">E Mail</label>
        <input type="email" name="email" id="email" placeholder="example@email.com">
        <label for="city">City</label>
        <input type="text" name="city" id="city">
        <label for="zip">Zipcode</label>
        <input type="text" name="zip" id="zip">

        <input type="submit" value="Send">
    </form>
    <?php 
        }
        if (isset($_SESSION['info'])){
            //ici, toujours dans le cas ou notre session serait remplie, on propose de la détruire
            ?>
            
                <a href="destroy.php">Logout</a>
            <?php
        }
    ?>
</body>

</html>