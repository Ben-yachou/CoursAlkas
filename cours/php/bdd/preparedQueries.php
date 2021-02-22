<?php

//précédemment nous avions récupéré des paramètres POST
//venant de formulaires remplis par l'utilisateur
//pour peupler nos requêtes SQL 
//pour cela nous avions concaténé les paramètres directement dans
//nos chaines de caractères
$queryText = "SELECT " . $_POST['param'] . " FROM apparts"; //par exemple

//mais faire confiance aux données utilisateurs est une TRES MAUVAISE IDEE
//et intégrer directement les paramètres d'un formulaire de cette façon
//dans une requête ouvre la porte a une attaque qu'on appelle attaque par injection
//https://fr.wikipedia.org/wiki/Injection_SQL

//imaginons la requête suivante 
$queryPassword = "SELECT id FROM users WHERE pseudo = Jones AND password = 3916a988bb490a82b24ebc1ef9ba50ab4b7a8d2a6e95872a3cbbf11f8a392fb6";
//cette requête recupererait l'id de l'utilisateur jones en vérifiant son mot de passe haché
//si on recupère le pseudo et le mot de passe en tant que paramètres
$pseudo = $_POST['pseudo'];
$password = password_hash($_POST['password'], ''); // le mot de passe chiffré
$queryPassword = "SELECT id FROM users WHERE pseudo = " . $pseudo. " AND password = " .$password;

//en admettant que le pseudo envoyé par formulaire soit 'Jones;--'
//les -- étant le symbole du commentaire dans SQL
//la requête du point de vue de mysql deviendrait 
//SELECT id FROM users WHERE pseudo = Jones; -- commentaire
//permettant ainsi l'accès au compte sans prendre le mot de passe en considération

//Pour éviter ce genre de pratiques il est conseillé d'utiliser
//les requêtes prépaées 
//http://php.net/manual/fr/pdo.prepare.php
//http://php.net/manual/fr/pdostatement.execute.php

//reprenons notre requête, en plaçant des jokers là où les valeurs doivent aller
//soit à l'aide de ? a l'endroit des paramètres
$queryPassword = "SELECT id FROM users WHERE pseudo = ? AND password = ?";
//soit en plaçant des paramètres nommés comme des variables
$queryPassword = "SELECT id FROM users WHERE pseudo = :pseudo AND password = :password";
//pour préparer notre requête il faut d'abord créer la connexion 
$pdo  = new PDO('myslq:host=localhost;dbname=test;charset=utf8', 'root', 'password');
//on demande de préparer la requête non pas avec $pdo->query() mais avec
//$pdo->prepare()
$query = $pdo->prepare($queryPassword);
//puis on exécute la requête en indiquant les paramètres à remplacer
//et execute remplacera les paramètres dans la requête dans l'ordre
//dans un tableau, si on a utilisé des ?
$query->execute([$pseudo, $password]);
//Si on a utilisé des paramètres nommés on utilisera un tableau associatif
//de façon à être plus précis sur notre façon de répartir les données
$query->execute([':pseudo' => $pseudo, ':password' => $password]);

//après execute il n'y a plus qu'a utiliser fetch() comme avant
while ($data = $query->fetch()){
    print_r($data);
}

?>