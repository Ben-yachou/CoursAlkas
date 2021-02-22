<?php
//on vérifie que nos valeur soient présentes 
if (isset($_POST['num']) && isset($_POST['unit1']) && isset($_POST['unit2'])){
    //et on les stocke
    $num = $_POST['num'];
    //si notre valeur à convertir est un nombre
    if (is_numeric($num)){
        $unit1 = $_POST['unit1'];
        $unit2 = $_POST['unit2'];
    
        //on prépare des ratios de conversion en référence a notre unité de base : b/s
        //étant donné que le point de référence est le même pour tous les ratios dans notre tableau, le résultat est toujours calculé de façon relative et sera toujours correct
        $ratios = ["b/s" => 1, "kb/s" => 1/1e3, "Mb/s" => 1/1e6, "Gb/s" => 1/1e9, "o/s" => 1/8, "ko/s" => 1/8e3, "Mo/s" => 1/8e6, "Go/s" => 1/8e9];
    
        //pour vérifier que notre unité existe bien, on vérifie qu'elle existe dans les clés de notre tableau associatif
        //à l'aide de array_key_exists()
        if (array_key_exists($unit1, $ratios) && array_key_exists($unit2, $ratios)) {
            echo $num * ($ratios[$unit2]/$ratios[$unit1]);
        } else {
            echo "unité inconnue";
        }
    } else {
        echo "La valeur convertie doit être un nombre";
    }
}