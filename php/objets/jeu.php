<?php
//la fonction include permet d'inclure un morceau de code dans un autre 
//ici, on permet l'exécution de notre script personnage.php qui déclarera notre classe pour la rendre disponible dans notre script jeu.php
include('personnage.php');
include('barbare.php'); //barbare inclus déjà personnage, mais utilise require_once
//on crée un personnage avec name, hp, et str
$jacques = new Personnage('Jacques', -15, 3);
echo "Jacques a " . $jacques->getHp() . " points de vie";

$krom = new Barbare('Krom Le Barbare', 100, 0, 5);
echo 'La force du barbare est de '.  $krom->getStr();

echo Barbare::MIN_STR; //on peut accéder à une constante de classe en mettant NomDeClasse::CONSTANTE
//de cette façon, on peut y accéder même sans instancier un objet à partir de cette classe
echo Personnage::MIN_STR;
