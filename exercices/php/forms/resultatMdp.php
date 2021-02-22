<?php
$motDePasseCorrect = "coco";
if ($_POST['mdp'] == $motDePasseCorrect){
    echo 'Mot de passe correct';
} else {
    echo 'Mot de passe incorrect';
}
?>