<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>

    <title>Fuseau horaire UTC</title>
</head>

<body>
    <form method="POST" action="">
        <label for="fuseau">fuseau de décalage : </label>
        <input type="text" name="fuseau" id="fuseau">

        <input type="submit" value="calculer">
    </form>

    <?php

    if (isset($_POST['fuseau'])) {
        //on récupère notre fuseau au format texte heure:minute
        $fuseau = $_POST['fuseau'];
        //on récupère en découpant au niveau des : 
        $fuseau_explose = explode(":", $fuseau);
        //les heures sont à l'index 0 du tableau récupéré
        $fuseau_heure = (int) $fuseau_explose[0]; //(int) permet de convertir en int

        //utc possède des fuseaux entre -12h et +14h
        if ($fuseau_heure >= -12 && $fuseau_heure <= 14) {
            //si un : est absent (si seules les heures sont précisées) on obtient pas de deuxième case, il faut donc vérifier son existence
            if (isset($fuseau_explose[1])) {
                //Avant de récupérer les minutes
                $fuseau_minute = (int) $fuseau_explose[1];
            } else {
                //sinon, on considère que les minutes sont à 0
                $fuseau_minute = 0;
            }

            //les fuseaux horaires utc peuvent décaler les minutes de 0, 30 ou 45 uniquement
            if ($fuseau_minute === 30 || $fuseau_minute === 45 || $fuseau_minute === 0) {

                echo "<p>" .  $fuseau_heure . " " . $fuseau_minute . "</p>";

                //on récupère l'heure actuelle en secondes
                $heure_en_secondes = time();
                //on récupère les minutes
                $minutes = intdiv($heure_en_secondes, 60) % 60;
                //on récupère les heures
                $heures = intdiv($heure_en_secondes, 3600) % 24;

                echo "<p>" . $heures . ":" . $minutes . "</p>";

                $heure_decal = ($heures + $fuseau_heure) % 24;
                $minute_decal = $minutes + $fuseau_minute;
                if ($minute_decal > 59) {
                    $heure_decal++;
                    $minute_decal = $minute_decal % 60;
                }
                if ($heure_decal > 23) {
                    $heure_decal = 0;
                }

                echo "<p>" . $heure_decal . ":" . $minute_decal . "</p>";
            } else {
                echo "Fuseau horaire invalide, minute peuvent être 0, 30, 45";
            }
        } else {
            echo "Fuseau horaire invalide, heure [-12, +14]";
        }
    }

    ?>

</body>

</html>