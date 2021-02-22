<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title>Détermination jour semaine</title>
</head>

<body>
    <form action="" method="POST">
        <input name="date" type="date">
        <input type="submit" value="calculer">
    </form>

    <?php
    //désastre : 
    
    if (isset($_POST['date'])){
        $date=$_POST['date'];
        echo $date;
        
        
        //calcul pour le numéro du jour : https://fr.wikibooks.org/wiki/Curiosit%C3%A9s_math%C3%A9matiques/Trouver_le_jour_de_la_semaine_avec_une_date_donn%C3%A9e
        //on récupère jour mois et année depuis notre date stockée sous forme de string
        //explode() permet de faire un tableau contenant [annee, mois, jour]
        //$date_explosee = explode("-", $date);
        //intval() permet de convertir chaque chaine de caractère en nombre entier
        //$annee = intval($date_explosee[0]);
        //$mois = intval($date_explosee[1]);
        //$jour = intval($date_explosee[2]);
        //marche pour le 20ème siècle et après uniquement (oups) -- ou alors le calendrier a faux -- ou le calcul
        //if ($mois < 3){
        //    $day = ((23*$mois/9) + $jour + 4 + $annee + (($annee-1)/4) - (($annee-1)/100) + (($annee-1)/400)) % 7;
        //} else {
        //    $day = ((23*$mois/9) + $jour + 2 + $annee + ($annee/4) - ($annee/100) + ($annee/400)) % 7;
        //}    

        //pour stocker une date on peut utiliser l'objet DateTime
        //vraie solution (flemmarde et qui marche): 
        $datetime = new DateTime($date);
        $day =  $datetime->format('N') - 1; // en demandant à datetime de nous renvoyer le numéro du jour 

        
        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        echo $days[$day];
    } else {
        echo "Entrez une date";
    }
    ?>
</body>

</html>