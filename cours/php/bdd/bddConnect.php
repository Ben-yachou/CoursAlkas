<?php
//pour se connecter à une base de données en php
//il faut utiliser un objet appelé PDO (Php Data Object)
//l'objet PDO contient des méthodes permattant de dialoguer avec une bdd
//ici, on va contacter la base de données mysql, à l'adresse localhost
//et demander d'accéder la base nommée test
//le premier paramètre du constructeur de PDO est une string de connexion à la bdd
//contenant le driver (mysql) l'hôte de connexion (localhost), le nom de la db (test)
//le charset (utf8)
//les second et troisième paramètres sont le nom d'utilisateur et mot de passe
//try catch permet de tester une opération et si une erreur survient la traiter 
//de façon spécifique
try {
    $pdo = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'password');
} catch (Exception $exception){
    //une exception est un objet contenant une erreur
    //elle est souvent envoyée en cas d'erreur en programmation objet
    //en cas d'exception ici on fait planter la page 
    die($exception->getMessage());
    //la méthode getMessage() de l'objet Exception permet d'obtenir le message d'erreur
}

//on prépare notre requête sous forme de chaine de caractères
//contenant la requête écrite en SQL
$requeteSelect = 'SELECT * FROM article';

//ensuite on appelle notre PDO pour préparer l'envoi de la requête
//on lui indique quelle sera la requête à exécuter, on lui transfère la requête
//et pdo enverra la requête à mysql et nous renverra une réponse
$reponse = $pdo->query($requeteSelect);

//puis on demande à l'objet renvoyé par query() d'aller chercher le resultat
//à l'aide de la méthode fetch()
//le résultat renvoyé par fetch() contiendra une ligne du résultat de notre requête
//fetch() peut prendre un paramètre définissant le format dans lequel les données
//seront renvoyées : PDO::FETCH_ASSOC pour recevoir un tableau associatif 
// PDO::FETCH_OBJ pour recevoir un objet etc...
// https://www.php.net/manual/fr/pdostatement.fetch.php
//de base, fetch() renvoie un tableau associatif et un tableau a indices
while ($data = $reponse->fetch(PDO::FETCH_ASSOC)){ //tant qu'on reçoit des données, on les stocke dans $data
    //pour chaque ligne de données, on peut afficher les différentes valeurs
    //ces valeurs sur chaque ligne de données sont stockées dans un tableau
    foreach($data as $key => $value){
        echo $key. "=>" . $value.'<br/>';
    }
    echo '<hr>';
}
//on arrête le traitement de la requête et on réinitialise la tête de lecture
$reponse->closeCursor(); 
?>