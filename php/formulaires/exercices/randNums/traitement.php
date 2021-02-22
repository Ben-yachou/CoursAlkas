<?php
//traitement du formulaire ici 

//vérification de l'intégrité du formulaire
if (isset($_POST['nbValeurs']) && isset($_POST['min']) && isset($_POST['max'])){
    $nbValeurs = $_POST['nbValeurs'];
    $min = $_POST['min'];
    $max = $_POST['max'];

    //on vérifie que les champs de formulaire aient bien été renseignés
    //empty() vérifie qu'une variable soit vide ou pas, !empty vérifie qu'une variable soit remplie
    //problème : empty considère 0 comme étant vide
    if ((!empty($nbValeurs) && !empty($min) && !empty($max)) || $nbValeurs == 0 || $min == 0 || $max == 0){
        //pour tester si un nombre est un nombre, on peut utiliser is_numeric
        if (is_numeric($nbValeurs) && is_numeric($min) && is_numeric($max)){
            //si notre nombre de valeurs demandé est positif
            if ($nbValeurs >= 1){
                //on répète l'opération autant que nécessaire
                for ($i = 1; $i <= $nbValeurs; $i++){
                    //génération de notre nombre aléatoire
                    $randomNum = rand($min, $max);
            
                    //affichage du nombre aléatoire avec gestion du français
                    if ($i == 1){
                        echo "Voici le {$i}er nombre aléatoire  : {$randomNum}"; 
                    } else {
                        echo "<br/> Voici le {$i}ème nombre aléatoire : {$randomNum}";
                    }
                }
            } else {
                echo "Le nombre de valeurs à genérer doit être supérieur à 0";
            }
        } else {
            echo "Les valeurs du formulaires doivent être des nombres";
        }
    } else {
        echo "Vous devez renseigner des valeurs dans le formulaire";
    }
} else {
    echo "Erreur formulaire";
}