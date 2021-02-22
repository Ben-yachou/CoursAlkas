<?php

//vérification des entrées utilisateurs
if (isset($_POST['op1']) &&  isset($_POST['op2']) && isset($_POST['calcul'])) {
    $op1 = $_POST['op1'];
    $op2 = $_POST['op2'];
    $calcul = $_POST['calcul'];

    //on vérifie que nos opérandes soient des nombres
    if (!is_numeric($op1) || !is_numeric($op2)) {
        $resultat = "erreur : je ne bosse qu'avec des nombres";
    } else {
        //on vérifie la nature du calcul
        switch ($calcul) {
            case "add":
                $resultat = $op1 + $op2;
                break;
            case "mul":
                $resultat = $op1 * $op2;
                break;
            case "sous":
                $resultat = $op1 - $op2;
                break;
            case "div":
                //on vérifie qu'on ne divise pas par 0
                if ($op2 != 0) {
                    $resultat = $op1 / $op2;
                } else {
                    $resultat = "Erreur : division par zéro";
                }
                break;
            default:
                //si aucun des calculs pris en compte n'est renseigné
                //on affiche une erreur
                $resultat = "Erreur : calcul inconnu";
        }
    }
} else {
    $resultat = "Erreur : formulaire invalide";
}
//on affiche notre résultat
echo $resultat;
