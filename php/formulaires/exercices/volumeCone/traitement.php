<?php
//calcul du volume du cone ici
//on vérifie l'intégrité de notre formulaire
if (isset($_POST['rayon']) && isset($_POST['hauteur'])){
    //on entreprends de calculer le résultat (pi * rayon² * hauteur) / 3
    $resultat = (pi() * pow($_POST['rayon'], 2) * $_POST['hauteur'])/3;
    //si $_POST['arrondi'] est initialisé, c'est que la checkbox a été cochée
    if (isset($_POST['arrondi'])){
        //on renvoie donc un résultat arrondi
        echo round($resultat);
    } else {
        //sinon on se contente du résultat normal
        echo $resultat;
    }
} else {
    echo "Erreur";
}