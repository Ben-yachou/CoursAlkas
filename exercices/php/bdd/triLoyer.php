<!DOCTYPE html>
<html>

<head>
    <title>Recherche Apparts </title>
    <meta charset="utf-8">
</head>

<body>
    <form action="" method="post">
        <label>
            Loyer Mini
            <input type="number" name="min" value="<?php
            //si le formulaire a déjà été envoyé on garde les valeurs précédentes
            //dans nos champs de formulaire
                if (isset($_POST['min'])){
                    echo $_POST['min'];
                }
            ?>">
        </label>
        <label>
            Loyer Maxi
            <input type="number" name="max" value="<?php
            //si le formulaire a déjà été envoyé on garde les valeurs précédentes
            //dans nos champs de formulaire
                if (isset($_POST['max'])){
                    echo $_POST['max'];
                }
            ?>">
        </label>

        <label>
            Tri
            <select name="order">
                <option value="asc">Croissant</option>
                <option value="desc">Decroissant</option>
            </select>
        </label>
        <input type="submit" value="Envoyer">
    </form>
</body>

</html>
<?php
//on vérifie si les valeurs ont bien été envoyées via http POST
if (isset($_POST['min']) && isset($_POST['max']) && isset($_POST['order'])) {
    $min = $_POST['min'];
    $max = $_POST['max'];

    if ($_POST['order'] == "desc"){
        $order = "DESC";
    } else {
        $order = "ASC";
    }
    

    if ($min > $max) {
        echo 'Le minimum ne peut être supérieur au maximum';
    } else {
        $pdo = new PDO(
            'mysql:host=localhost;dbname=test;charset=utf8',
            'root',
            'password'
        );
        //on prépare le texte de notre requête SQL en laissant des paramètres :min et :max
        $queryText = "SELECT * FROM appart WHERE rent BETWEEN :min AND :max ORDER BY rent ". $order;
        //on demande à pdo de transferer la requête à MySQL 
        $query = $pdo->prepare($queryText);
        //pdo envoie les valeurs des paramètres :min et :max à MySQL pour le traitement de la requête
        $query->execute([
            ":min" => $min,
            ":max" => $max
        ]);
        //tant qu'on reçoit des données renvoyées par fetch()
        //on les stocke dans $data
        while ($data = $query->fetch()) {
            //puis on les utilise
            //chaque tour de boucle while correspond à une ligne de résultat 
            echo '<ul>';
            echo '<li>' . $data['city'] . '</li>';
            echo '<li>' . $data['address'] . '</li>';
            echo '<li>' . $data['zip'] . '</li>';
            echo '<li>' . $data['surface'] . '</li>';
            echo '<li>' . $data['rooms'] . '</li>';
            echo '<li>' . $data['rent'] . '</li>';
            echo '</ul>';
            echo '<hr>';
        }
        //une fois l'affichage du résultat terminé on arrête l'exécution de notre requête
        $query->closeCursor();
    }
}
?>