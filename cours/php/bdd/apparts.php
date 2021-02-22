<!DOCTYPE html>
<html>
<head>
    <title>Recherche Apparts </title>
    <meta charset="utf-8">
</head>
<body>
    <form action="" method="post">
        <select name="column" id="">
            <option value="*">Tout</option>
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

        //on vérifie qu'on ait bien reçu le paramètre post
        if (isset($_POST['column'])){
            

            //requête SELECT en sql SELECT rent FROM APPART
            $response = $pdo->query('SELECT '. $_POST['column'] .' FROM appart');
            
            //tant qu'on reçoit des données
            while ($data = $response->fetch()){
                //on les affiche
                print_r($data);
                echo '<hr>';
            }
        }
    ?>
</body>
</html>