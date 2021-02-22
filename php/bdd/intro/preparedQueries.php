<?php
$rent = 50;

$dbh = new PDO('mysql:host=localhost;dbname=apparts;charset=utf8', 'root', '');

//pour optimiser nos requêtes ainsi que nous prémunir des injections SQL, on peut insérer dans notre chaîne de caractère des paramètres que l'on pourra demander à PDO de remplacer par la suite
//par exemple ici au lieu de placer la variable $rent on utilise un "placeholder" :rent
$sql_query = "SELECT * FROM appart WHERE rent > :rent";
$stmt = $dbh->prepare($sql_query);

//au moment de l'exécution, on indique à PDO par quelle valeur on souhaite remplacer ces paramètres, et on lui passe pour ce faire un tableau associatif contenant chaque paramètre et sa valeur associée
//ici, :rent sera remplacé par $rent dans notre requête au moment de l'exécution
$stmt->execute([
    ":rent" => $rent,
]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($results as $row) {
    echo $row['rent'] . " </br>";
}
