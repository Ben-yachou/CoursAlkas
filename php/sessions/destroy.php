<?php
//pour supprimer une session (ex: déconnexion d'un utilisateur)
//il faut d'abord la récupérer
session_start();
//puis on la supprime
session_destroy(); 
//session_destroy supprime la session et les données associées, ainsi que le cookie PHPSESSID stocké sur le navigateur

//si on veut faire une redirection on peut utiliser header Location: url
header('Location: page1.php');