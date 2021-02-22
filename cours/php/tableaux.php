<?php
//on peut créer un tableau (array) de deux façons différentes
//façon historique
$valeurs = array(1, 2, 3, 4);
//depuis php 5.x
$prenoms = ["Omar", "Gianni", "Thomas", "Julien"];

//accéder aux valeurs d'un tableau
echo $prenoms[0]."</br>"; //concaténer br permet de sauter une ligne en html
echo $prenoms[1]."</br>";
echo $prenoms[2]."</br>";
echo $prenoms[3]."</br>";

//modifier les valeurs d'un tableau
$prenoms[0] = "Yassine";
echo $prenoms[0]."</br>"; 
echo $prenoms[1]."</br>";
echo $prenoms[2]."</br>";
echo $prenoms[3]."</br>";
//ajouter une valeur au tableau
//laisser les crochets vide permet d'ajouter a la fin du tableau
$prenoms[] = "Thomas"; 
echo $prenoms[0]."</br>"; 
echo $prenoms[1]."</br>";
echo $prenoms[2]."</br>";
echo $prenoms[3]."</br>";
echo $prenoms[4]."</br>";

//tableaux associatifs
//les tableaux associatifs permettent d'associer
//une clé a une valeur a la place d'un index
$utilisateur = [
    'nom' => 'Jones',
    'prenom' => 'Joe',
    'adresse' => 'Main Street',
    'ville' => 'Nouillorke'
];

echo $utilisateur['nom'];

//utilisation du for pour parcours de tableaux
//count() ou sizeof() permet de récuperer le nombre de valeurs dans un tableau
for ($i = 0; $i < count($prenoms); $i++){
    echo $prenoms[$i] . '</br>';
}

//vérifier la présence d'une valeur dans un tableau
$fruits = ['Banane', 'Pomme', 'Ananas', 'Poire', 'Cerise'];
$fruitAChercher = 'Fraise';
//in_array(valeur, tableau) permet de vérifier l'existence d'une valeur dans un tableau
if (in_array($fruitAChercher, $fruits)){
    echo $fruitAChercher . ' est bien dans le tableau de fruits </br>';
} else {
    echo $fruitAChercher . ' n\'est pas dans le tableau de fruits </br>';
}

//récuperer la longueur d'une chaine se fait non pas à l'aide de count()
//mais à l'aide de strlen ou mb_strlen (préféré)
echo mb_strlen('coucoü');