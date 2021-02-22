<?php
$min = 300;
$max = 450;

$pdo = new PDO('mysql:host=localhost;dbname=test;charset=utf8',
                'root',
                'password');

//on prépare notre requête SQL à trous
$queryText = "SELECT * FROM appart WHERE rent BETWEEN :min AND :max";
//on demande à PDO de préparer l'execution de la requête
$query = $pdo->prepare($queryText);

//on lance l'execution de la requête à l'aide des paramètres
$query->execute([
    ':min' =>$min, 
    ':max' => $max]);

while ($data = $query->fetch()){
    print_r($data);
    echo '<hr>';
}
?>