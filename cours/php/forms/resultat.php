<?php

//récupération de valeurs textuelles via la variable SuperGlobale $_POST
//var_dump permet d'afficher le contenu d'une variable même si c'est une structure de données
//print_r() est une fonction similaire arrivant a un résultat semblable
var_dump($_POST);
echo '</br>';
//$_POST est un tableau associatif, ainsi pour récupérer les valeurs de la requête POST
//il faut indiquer a clé associée à cette valeur, qui est le nom du champ correspondant
echo $_POST['pseudo'].'</br>'; //on récupère la valeur du champ pseudo
echo $_POST['message'].'</br>'; //on récupère la valeur du champ message
echo $_POST['liste'].'</br>'; //on récupère la valeur de l'option de la liste

//vérifier si une case à cocher a été cochée ou pas
//on va vérifier si la valeur "on" a été envoyée via Post
//isset() vérifie qu'une variable ait été initialisée
if (isset($_POST['check'])){ //si la variable correspondant a notre checkbox a été initialisée
    //alors la case a été cochée
    echo 'Case cochée<br/>';
}

//récupération des valeurs de bouton radio
echo $_POST['choix'].'<br/>';