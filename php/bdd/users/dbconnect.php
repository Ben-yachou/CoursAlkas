<?php

function dbConnect($dbname, $username, $password)
{
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=" . $dbname . ";charset=utf8;", $username, $password);
    } catch (PDOException $exception) {
        die("Erreur connexion à la base de données");
    }
    return $dbh;
}
