<?php
//on vérifie l'intégrité des données
if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['zip']) && isset($_POST['city'])) {
    //si tout est ok, commence la session
    session_start();

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];

    //puis on enregistre les données de notre utilisateur dans notre stockage de session
    //en ce faisant, on rend disponible les donnéees quelque soit la page de notre site
    $_SESSION['info'] = ['firstname' => $firstname, 'lastname' => $lastname, 'city' => $city, 'zip' => $zip];


    //on affiche ensuite notre récapitulatif
    echo "Recap : <br/>";
    echo "<br/>Firstname : " . $firstname;
    echo "<br/>Lastname : " . $lastname;
    echo "<br/>Email : " . $email;
    echo "<br/>City : " . $city;
    echo "<br/>Zip : " . $zip;

    //et une proposition de retour à l'accueil
    echo "<br/> <a href='form.php'>Retour à l'accueil</a>";
} 

