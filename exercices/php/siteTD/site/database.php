<?php

function bddConnect(){
    //on fait appel a notre fichier de config contenant les pass vers la bdd
    $config = parse_ini_file('../configuration/config.ini');

    try {
        //on utilise ensuite le contenu du fichier de config pour se connecter
        $pdo = new PDO(
            'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=utf8',
            $config['username'], //utilisateur
            $config['password'] //mot de passe
        );
    } catch (PDOException $exception) {
        die($exception->getMessage());//on suspend la page et affiche le message d'erreur
    }

    return $pdo;
}

//renvoie tous les projets
function getProjets($pdo){
    $query = $pdo->prepare('SELECT * FROM projet');
    $query->execute();
    $projets = $query->fetchAll();
    $query->closeCursor();
    
    return $projets;
}

//renvoie un projet a partir de son id
function getProjetById($pdo, $id){
    $query = $pdo->prepare('SELECT * FROM projet WHERE projet.id = :id');
    $query->execute(
        [
            ":id" => $id
        ]
    );
    $projet = $query->fetch();
    $query->closeCursor();
    
    return $projet;
}

//renvoie les projets avec le titre $titre
function getProjetsByTitre($pdo, $titre){
    $query = $pdo->prepare('SELECT * FROM projet WHERE projet.titre = :titre');
    $query->execute(
        [
            ':titre' => $titre
        ]
    );
    $projets = $query->fetchAll();
    $query->closeCursor();
    return $projets;
}

//renvoie toutes les categories
function getCategories($pdo){
    $query = $pdo->prepare('SELECT * FROM categorie');
    $query->execute();
    $categories = $query->fetchAll();
    $query->closeCursor();
    
    return $categories;
}

//renvoie une categorie en fonction de son id
function getCategorieById($pdo, $id){
    $query = $pdo->prepare('SELECT * FROM categorie WHERE categorie.id = :id');
    $query->execute(
        [
            ":id" => $id
        ]
    );
    $categorie = $query->fetch();
    $query->closeCursor();
    
    return $categorie;
}

//renvoie les projets a partir d'une categorie ainsi que le nom de la categorie
function getProjetsFromCategorie($pdo, $id_categorie){
    $query = $pdo->prepare('SELECT projet.*, categorie.nom 
                            FROM projet 
                            INNER JOIN projet_categorie
                            ON projet.id = projet_categorie.id_projet
                            INNER JOIN categorie
                            ON projet_categorie.id_categorie = categorie.id
                            WHERE projet_categorie.id_categorie = :id_categorie');
    $query->execute(
        [
            ":id_categorie" => $id_categorie
        ]
    );
    $projets = $query->fetchAll();
    $query->closeCursor();
    
    return $projets;
}

//renvoie les categories contenant un projet
function getCategoriesFromProjet($pdo, $id_projet){
    $query = $pdo->prepare('SELECT categorie.*
                            FROM categorie
                            INNER JOIN projet_categorie
                            ON categorie.id = projet_categorie.id_categorie
                            WHERE projet_categorie.id_projet = :id_projet');
    $query->execute(
        [
            ":id_projet" => $id_projet
        ]
    );
    $categories = $query->fetchAll();
    $query->closeCursor();
    
    return $categories;
}