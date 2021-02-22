<?php
//Pour se connecter à une base de données en PHP 
//Il faut qu'on utilise une classe d'objets appelée PDO (PHP Data Objects)
//la classe PDO contient des méthodes permettant de dialoguer avec une BDD 
//https://www.php.net/manual/fr/book.pdo.php
//ici, on va contacter un serveur de bdd mysql et demander l'accès à une base de données test

//Pour se connecter à la base on va donc instancier un PDO 
//le premier paramètre du constructeur PDO est le DSN (Data Source Name)
//Il sert à identifier à quelle base de données on souhaite se connecter
//il s'écrit au format : $driver:host=$nomhote;dbname=$nombdd;charset=utf8
//dans de mysql, le driver est mysql par exemple
$dbh = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');

//on appelle notre objet PDO 'dbh' pour 'database handler' ou 'gestionnaire de bdd' 

//pour préparer nos requêtes SQL on peut les définir comme des chaînes de caractères étant donné que mySQL dialogue via du texte 
//pour créer une table par exemple : 
//$sql_query = "CREATE TABLE test_php (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, label VARCHAR(255))";
$sql_query = "SELECT * FROM test_php";
//pour que la requête SQL au format texte soit envoyée à mysql, il faut qu'on prépare un statement (une déclaration) que PDO se chargera d'envoyer au DSN précisé plus haut
//prepare permet de préparer la déclaration à SQL via PDO, et renvoie la déclaration
$stmt = $dbh->prepare($sql_query);
//enfin, il faut exécuter la déclaration obtenue
$stmt->execute();
//si une erreur survient, on peut l'afficher avec $stmt->errorInfo() qui est un tableau contenant les erreurs survenues 
//var_dump($stmt->errorInfo());

//si on attend une réponse à notre requête, il faut demander à PDO d'aller la chercher et nous la renvoyer. Pour ça, il faut utiliser une commande fetch (pour 'aller chercher')
//fetchAll renvoie toutes les lignes de résultat, et le renvoie par défaut sous deux formes : une forme sous tableau classique (index 0 - n), et une forme clé/valeur en tableau associatif 
//pour ne choisir qu'une seule forme de résultat, on peut lui préciser comme par exemple avec PDO::FETCH_ASSOC qui indique d'utiliser uniquement un tableau associatif
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

//pour chaque ligne de resultat
foreach ($res as $ligne) {
    //on affiche l'id et le label 
    echo sprintf("id : %d, label: %s <br/>", $ligne['id'], $ligne['label']);
}
