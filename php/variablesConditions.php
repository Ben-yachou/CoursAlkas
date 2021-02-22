<?php
//les variables en php ont leur déclaration (et nom) précédées de $
$message = "Salut";

//étant donné qu'un fichier php interprété renvoie toujours du texte
//pour afficher quelque chose à l'écran, il faut pouvoir écrire du texte dans le document
//pour cela, on utilise la fonction echo 
echo $message;

$nombre = 15; 

echo nl2br("\nLe nombre est $nombre + 5"); //pour sauter une ligne, on peut associer le caractère \n (new line) avec la fonction nl2br, qui traduit les \n en <br> 
//insérer une variable dans une chaîne de caractères définie avec des double quote (") est possible,
//mais parfois pour améliorer la lisibilité ou effectuer certaines opérations on va utiliser la concaténation

//la concaténation en php se fait avec . 
echo nl2br("\nLe nombre est " . ($nombre + 5));

//les conditions sont pareilles qu'en javascript
$age = 11;

echo "<p>"; //pour écrire du HTML dans notre code php, il faut juste renvoyer du texte formaté en HTML
if ($age < 18){
    echo "Accès interdit";
} elseif ($age > 20){
    echo "Vous pouvez boire";
} else {
    echo "On regarde mais on ne boit pas";
}
echo "</p>";