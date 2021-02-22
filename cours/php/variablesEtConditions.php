<?php
//les variables en php ont leur noms précédés de $
$message = "Bonjour"; //type string 
$nombre = 15; //type int (entier)
$nombreVirgule = 15.5; // type float (nombre a virgule flottante)
$boolean = true; //type bool
$neant = NULL; //néant

$age = 14;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title><?php echo $message ?></title>
</head>

<body>
    <p>
        <?php
        //echo permet d'afficher un message sur la page
        //pour intégrer une variable dans une string il suffit 
        //d'écrire le nom de la variable précédé de $
        echo "Message de bienvenue : $message";
        ?>
    </p>
    <p>
        <?php
        //l'opérateur de concaténation est le point 
        echo "Le nombre est : " . $nombre . " !";
        ?>
    </p>

    <p>
        <?php
        //on peut redéfinir une variable de cette façon
        $age = 19;
        if ($age < 18) {
            echo $age . " ans : vous êtes mineur";
        } elseif ($age > 21) {
            echo $age . " ans : vous êtes en âge de boire";
        } else {
            echo $age . " ans : vous êtes majeur";
        }
        ?>
    </p>

    <p>
        <?php
        $afficherMessage = false;
        if ($afficherMessage) {
            echo "Message secret";
        } else {
            echo "Vous n'êtes pas autorisé à voir ce message";
        }
        ?>
    </p>


    <p>
        <?php
        //les opérateurs AND/&& et OR/||
        $langue = "EN";
        $autorisation = true;
        $messageFr = "Bienvenue";
        $messageEn = "Welcome";
        //&& et AND sont équivalents
        if ($autorisation && $langue == "EN") {
            echo $messageEn;
        } elseif ($autorisation and $langue == "FR") {
            echo $messageFr;
        }

        $pays = "CH";
        //OR et || sont équivalents
        if ($pays == "FR" or $pays == "BE" || $pays == "CH") {
            echo $messageFr;
        } else {
            echo $messageEn;
        }
        ?>

    </p>

    <p>
        <?php
        $country = "US";
        switch ($country) {
            case "FR":
                echo "Vous êtes meilleur";
                break;
            case "UK":
                echo "Vous avez des dents pourries";
                break;
            case "BE":
                echo "Vous êtes colonnialistes";
                break;
            case "US":
                echo "Vous avez des tireurs dans vos écoles primaires";
                break;
            case "CH":
                echo "Vous êtes nazis";
                break;
            case "JP":
                echo "Vous êtes chinois";
                break;
        }


        ?>

    </p>
</body>

</html>