<?php

//PDO ou Php Data Object est une classe PHP contenant des utilitaires
//permettant le dialogue avec un SGBD (système de gestion de bases de données)
//pour créer une nouvelle instance de PDO il faut lui spécifier comment se connecter à la db
//il faut donc lui donner ce qu'on appelle le DSN (data source name), qui est l'"adresse" de la db
//puis le nom d'utilisateur, ainsi que le mot de passe s'il y en a, de connexion
try {
    //try (littérallement essayer) permet de mettre des instructions à l'épreuve
    //si une Exception (une erreur) est renvoyée par l'instruction
    //alors on pourra la traiter dans le bloc catch (attrapper)
    $pdo = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'password');
} catch (PDOException $exception) {
    //en attrappant l'exception on peut choisir la marche à suivre en cas d'erreur
    //ici on choisis d'arrêter l'execution de la page et d'afficher le message d'erreur 
    die($exception->getMessage());
}
$sqltext = 'SELECT * FROM voiture ORDER BY id DESC';
//PDO->prepare() permet de préparer une requête écrite en SQL
//et renvoie la requête préparée prête à l'exécution dans un objet
//l'objet renvoyé contient les méthodes nécessaires pour exécuter la requête, lire ses résultats, etc... 
$query = $pdo->prepare($sqltext);
//la requête ainsi préparée peut être exécutée à l'aide de la méthode execute()
$query->execute(); //cette méthode donne le feu vert à mysql pour lancer la requête
//pour lire le résultat de notre requête SELECT il faut aller chercher lesdits resultats
$resultat = $query->fetchAll(); //fetchAll() renvoie les résultats de notre requête dans un tableau
//pour chaque voiture contenue dans le tableau resultat
foreach ($resultat as $voiture) {
    //on affiche les informations proprement
    echo $voiture['marque'];
    echo '<br/>';
    echo $voiture['modele'];
    echo '<br/>';
    echo $voiture['prix'];
    echo '<br/>';
}

?>

<form method="POST" action="traitement.php">
    <label for="marque">Marque</label>
    <input type="text" name="marque">
    <label for="modele">Modele</label>
    <input type="text" name="modele">
    <label for="prix">Prix</label>
    <input type="number" name="prix">
    <input type="submit" value="Envoyer">
</form>

