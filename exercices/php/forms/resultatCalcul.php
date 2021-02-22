<?php
//calcul du volume du cone a partir des données envoyées par formulaire
//le volume d'un cone est calculé de la façon suivante :

// (π x r² x h)/3
//pour utiliser pi dans un calcul en php on utilise pi()
//pour mettre un nombre n au carré on fait pow(n, 2)
//(pi() * pow(rayon, 2) *  hauteur)/3 

//l'arrondi se fait avec round(n)
//si la case correspondante est cochée dans le formulaire
//arrondir le résultat du calcul

//récupération des données du formulaire
$rayon = $_POST['rayon'];
$hauteur = $_POST['hauteur'];
$arrondir = isset($_POST['arrondir']); //on vérifie si la case a été cochée

$resultat = pi() * pow($rayon, 2) * $hauteur * 1/3;

if ($arrondir){
    $resultat = round($resultat);
}

echo 'Le volume du cone de rayon ' . $rayon . ' et hauteur ' . $hauteur . ' est : '. $resultat;
//si le résultat est arrondi on ajoute la mention (arrondi) à la suite
if ($arrondir){
    echo ' (arrondi)';
}