<?php
//vérification de l'intégrité du formulaire 
if (isset($_POST['num1']) && isset($_POST['num2']) && isset($_POST['operation'])){
    //récupération de nos valeurs de formulaire
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operation = $_POST['operation'];
    
    //si les opérandes sont bien des nombres
    if (is_numeric($num1) && is_numeric($num2)){
        //application de l'opération
        //le switch-case permet de prendre une variable comme point de comparaison et établir plusieurs "cases" 
        //chaque "case" définit un comportement lorsque la variable à comparer est égale à une certaine valeur
        //les "break" permettent de mettre fin au switch si on rencontre un certain cas 
        switch($operation){
            case 'add':
                echo $num1 + $num2;
                break;
            case 'sous':
                echo $num1 - $num2;
                break;
            case 'mul':
                echo $num1 * $num2;
                break;
            case 'div':
                if ($num2 != 0){
                    echo $num1 / $num2;
                } else {
                    echo "Division par zéro impossible";
                }
                break;
            default:
                echo "Opération {$operation} inconnue";
        }
        
    } else {
        echo "Les opérandes doivent être des nombres !";
    }
} else {
    echo "Erreur formulaire";
}