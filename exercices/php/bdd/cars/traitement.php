<?php
//on vérifie que les données du formulaire aient bien été transferées
if (isset($_POST['marque']) && isset($_POST['modele']) && isset($_POST['prix']) ){
    //si c'est le cas on les stocke dans des variables
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $prix = $_POST['prix'];
    //on crée le PDO permettant de dialoguer avec la bdd
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'password');
    } catch (PDOException $exception) {
        die($exception->getMessage());
    }
    //on prépare notre requête d'insertion
    $query = $pdo->prepare('INSERT INTO voiture (marque, modele, prix) VALUES (:marque, :modele, :prix)');
    //on execute la requête avec les paramètres récupérés du formulaire
    $query->execute([
        ":marque" => $marque,
        ":modele" => $modele,
        ":prix" => $prix,
    ]);
}
//enfin on redirige vers la première page
header('Location: cars.php');
?>
