<?php
include('database.php');

$pdo = bddConnect();
//on appelle getProjetsFromCategorie avec l'id de categorie 1
$projets = getProjetsFromCategorie($pdo, 1);


//on affiche sommairement
foreach ($projets as $projet){
    echo $projet['titre'];
    echo '<br>';
    echo date('m/y', $projet['date']);
    echo '<br>';
    echo $projet['auteurs'];
    echo '<hr>';
}