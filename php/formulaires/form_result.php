<?php
//ici on traite les données reçues via notre formulaire form.html

//pour traiter les valeurs reçues du formulaire en méthode POST, il faut pouvoir les récupérer
//Dans un traitement de formulaire POST, les valeurs sont stockées dans une variable nommée $_POST 
//$_POST contient un tableau associatif (clé/Valeurs), les clés étant les "name" de nos champs input
//les valeurs étant les "value" de notre formulaire 

//pour vérifier si des données ont bien été envoyées, il faut donc vérifier si $_POST est rempli 
//var_dump($_POST); //var_dump permet d'inspecter une variable

//pour vérifier l'existence de données, on peut utiliser la fonction isset() qui permet de renvoyer true si une donnée existe

if (isset($_POST['nickname'])) { //si nickname existe dans $_POST
    echo $_POST['nickname']; //c'est qu'on peut accéder à sa valeur
}

if (isset($_POST['fruit'])) { //si fruit existe dans $_POST
    echo "<br/>Votre fruit préféré est : {$_POST['fruit']}"; //les accolades autour d'une variable dans une chaine permettent d'émuler une concaténation
}

//pour vérifier si une checkbox a été cochée, on vérifie son existence, si elle est présente dans $_POST c'est qu'elle a été cochée
if (isset($_POST['agree'])){
    echo "<br/>Les conditions ont été acceptées";
} else {
    echo "<br/>Veuillez accepter les conditions";
}