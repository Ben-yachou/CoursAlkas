<!DOCTYPE html>
<html>
<head>
    <title>Recherche Apparts </title>
    <meta charset="utf-8">
</head>
<body>
    <form action="" method="post">
        <select name="column" id="">
            <option value="id">Identifiant</option>
            <option value="city">Ville</option>
            <option value="address">Adresse</option>
            <option value="zip">Code Postal</option>
            <option value="surface">Superficie</option>
            <option value="rooms">Nombre de Pièces</option>
            <option value="rent">Loyer</option>
        </select>
        <input type="submit" value="Envoyer">
    </form>

    <?php
        //connexion a la bdd
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=test;charset=utf8',
            'root',
            'password');
        } catch (PDOException $exception){
            //en cas d'erreur on fait crash la page et affiche le message
            die($exception->getMessage());
        }

        if (isset($_POST['column'])){

            $response = $pdo->query('SELECT * FROM appart ORDER BY ' . $_POST['column']);

            //on met en place un tableau html
            //<table> ouvre le tableau
            echo '<table>';
            //les balises <th> (pour tab head) gèrent les titres des colonnes
            echo '<th>id</th>
                <th>city</th>
                <th>address</th>
                <th>zip</th>
                <th>surface</th>
                <th>rooms</th>
                <th>rent</th>';
            while ($data = $response->fetch()){
                //pour chaque ligne de notre resultat de requête
                //on utilise une balise <tr> (table row) pour créer une ligne
                echo '<tr>';
                //les balises <td> (tab data) contiennent les données de chaque colonne
                echo '<td>'.$data['id'].'</td>'; //$data['id'] récupère l'id de la ligne 
                echo '<td>'.$data['city'].'</td>'; //$data['city'] récupère la ville
                echo '<td>'.$data['address'].'</td>'; //etc..
                echo '<td>'.$data['zip'].'</td>';
                echo '<td>'.$data['surface'].'</td>';
                echo '<td>'.$data['rooms'].'</td>';
                echo '<td>'.$data['rent'].'</td>';
                //on ferme notre ligne
                echo '</tr>';
            }
            //une fois la boucle terminée on peut fermer notre table
            echo '</table>';
            $query->closeCursor();
        }
    ?>
</body>
</html>