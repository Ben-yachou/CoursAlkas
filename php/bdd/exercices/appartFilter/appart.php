<?php
if (isset($_POST['min_rent']) && isset($_POST['max_rent']) && isset($_POST['min_surface']) && isset($_POST['max_surface']) && isset($_POST['city']) && isset($_POST['zipcode'])) {
    $max_rent = $_POST['max_rent'];
    $min_rent = $_POST['min_rent'];
    $max_surface = $_POST['max_surface'];
    $min_surface = $_POST['min_surface'];
    $city = "%" . $_POST['city'] . "%";
    $zipcode = $_POST['zipcode'] . "%";

    //on établit une liste de nos valeurs autorisées pour le order by 
    $columns = ["city", "address", "zip", "surface", "rooms", "rent"];
    //et on filtre selon si cette valeur de formulaire est dans ce tableau ou pas
    if (isset($_POST['orderby']) && in_array($_POST['orderby'], $columns)) {
        $orderby = $_POST['orderby'];
    } else {
        $orderby = "rent";
    }


    //gestion des valeurs numériques par défaut 
    if (empty($min_rent)) {
        $min_rent = 0;
    }
    if (empty($min_surface)) {
        $min_surface = 0;
    }
    if (empty($max_rent)) {
        $max_rent = PHP_INT_MAX; //on pourrait également utiliser INF si SQL pouvait le comprendre
    }
    if (empty($max_surface)) {
        $max_surface = PHP_INT_MAX; //on pourrait également utiliser INF si SQL pouvait le comprendre
    }


    //récupération des cases cochées du nb de pièces
    $rooms = [];
    //on compte autant de fois que ce qu'il y a de filtre de pièces
    for ($i = 1; $i <= 10; $i++) {
        //si la case à cocher est dispo
        if (isset($_POST['room_' . $i])) {
            //on ajoute son numéro au tableau
            array_push($rooms, $i);
        }
    }
    //on gère le cas par défaut dans lequel aucune case n'est cochée
    if (empty($rooms)) {
        $rooms = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    }




    //vérifier si nos valeurs supposées numériques le sont bien 
    if (is_numeric($max_rent) && is_numeric($min_rent) && is_numeric($max_surface) && is_numeric($min_surface)) {
        //on tente une connexion a la bdd
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=apparts', 'appart', 'TGqxUhKFljizSLzo', [
                //le dernier paramètre du constructeur de PDO permet de définir des options 
                //parmi ces options il existe un moyen de définir le mode de gestion d'erreur
                //ici, on demande à ce que ce mode de gestion d'erreur soit via des exceptions pour pouvoir utiliser try/catch
                //https://www.php.net/manual/fr/pdo.error-handling.php
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                //on peut également demander à PDO de ne pas faire de "fausses" requêtes préparées si on le désire
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $jacques) {
            //si la connexion est foirée on casse tout
            die("Error 500 à l'aide");
        }

        //on prépare notre requête
        //:min_rent et :max_rent servent à "chauffer la place" aux valeurs qu'on enverra lors du execute
        //pour le IN on est obligés de reconstituer une liste SQL (valeurs séparées par virgules)
        //a cause des limitations de SQL on est obligés de passer les valeurs de cette liste avant le prepare, et on doit donc s'assurer qu'aucune injection ne soit possible
        //fort heureusement, les valeurs de notre tableaux sont des index que nous avons définis et ne peuvent donc pas être du code malicieux
        $query = "SELECT * FROM appart WHERE (rent BETWEEN :min_rent AND :max_rent) AND (surface BETWEEN :min_surface AND :max_surface) AND city LIKE :city AND zip LIKE :zipcode AND (rooms IN (" . implode(",", $rooms) . ")) ORDER BY " . $orderby;
        $stmt = $dbh->prepare($query);

        //on envoie enfin nos valeurs pour execution
        $stmt->execute(
            [
                ":min_rent" => $min_rent,
                ":max_rent" => $max_rent,
                ":min_surface" => $min_surface,
                ":max_surface" => $max_surface,
                ":city" => $city,
                ":zipcode" => $zipcode,
            ]
        );

        //on recup les résultats
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
