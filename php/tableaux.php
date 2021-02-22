<?php
//historiquement, un tableau en php se crée à l'aide d'une fonction nommée array()
$nombres = array(1, 2, 3, 4); //dans $nombres sera stocké [1, 2, 3, 4];
//depuis php5 on peut créer un tableau "à la volée" comme en js
$voitures = ["fiat", "ferrari", "alfa romeo"];
//on accède aux cases du tableau comme d'habitude via son index :
echo $voitures[1]; //affiche ferrari

//une grosse différence avec js est que les tableaux php sont mutables (modifiables)
//si on désire affecter une nouvelle valeur à une case de tableau on peut agir comme n'importe quelle variable
$voitures[0] = "lancia";
echo "<br/>";
echo $voitures[0];

//pour ajouter une valeur à la suite d'un tableau on peut utiliser des crochets vides
$voitures[] = "lamborghini";
echo "<br/>";
echo $voitures[3];

//on peut utiliser également array_push(), qui permet elle d'ajouter plusieurs variables à la fois
array_push($voitures, "peugeot", "renault");
//pour les ajouter au début, on peut utiliser array_unshift();
array_unshift($voitures, "mitsubishi", "toyota");

//si on désire afficher chaque élément de notre tableau, on peut utiliser un for comme d'hab
//pour obtenir le compte de valeurs dans notre tableau, on utilise count($tableau);
for ($i = 0; $i < count($voitures); $i++){
    echo "<br/>" . $voitures[$i];
}

//count sert aux tableaux et assimilés (collections) mais pas aux strings, les strings utilisent mb_strlen()
//mb_strlen("coucou"); renverra 6
//strlen() ne doit pas être utilisé (obsolète)


//en php il existe aussi un autre type de tableaux, appelés tableaux associatifs 
//qui prennent la forme de dictionnaires clé/valeur
$villes = [
    "34000" => "Montpellier", 
    "75000" => "Paris",
    "31000" => "Toulouse",
    "13000" => "Marseille"
];

echo "<br>" . $villes["34000"]; //renvoie montpellier 
//les données de notre tableau associatifs sont accessibles par des clés, mais plus par des indexs 
//pour récupérer chaque élément d'un tableau associatif on ne peut donc pas utiliser un for avec $i 
//on doit donc forcément utiliser un foreach($tableau as $cle => $valeur){}
//pour récupérer seulement les valeurs et pas les clés on peut utiliser foreach($tableau as $valeur)
foreach ($villes as $code_postal => $ville){
    echo "<br/>" . $code_postal . " : " . $ville;
}

//si on veut vérifier la présence d'une valeur dans un tableau, on utilise in_array($aiguille, $botteDeFoin)
if (in_array("Montpellier", $villes)) {
    echo "<br/> Livraison possible à Montpellier";
}
//pour vérifier une existence de clé on utilise array_key_exists($clé, $tableau)