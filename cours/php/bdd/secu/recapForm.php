<form action="" method="POST">
    <input type="text" name="username">
    <input type="email" name="email">
    <input type="password" name="password">
    <input type="number" name="age">
    <input type="submit" value="Envoyer">
</form>


<?php
//la première chose à faire pour valider un formulaire est de 
//vérifier que les données aient bien été envoyées
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['age'])){
    //en utilisant isset on peut vérifier si des variables ont été initialisées
    //et si oui ou non elles sont vides 

    //ensuite on doit vérifier que le type de données reçu est bien le type attendu
    //c'est à dire que les int en soient, que des emails en soient etc...

    //filter_var permet de vérifier que des strings aient un format particulier
    //ici on vérifie que notre variable censée être un email ait bien le format d'une adresse mail
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        //on peut aussi vérifier qu'une variable soit bien un nombre avec is_numeric
        if (is_numeric($_POST['age'])){
            //on peut également vérifier que les chaines envoyées fassent la longueur demandée
            //comme par exemple vérifier qu'un mot de passe fasse une certaine longueur
            if(mb_strlen($_POST['password']) > 7 ){
                //ici on vérifie que le mot de passe fasse plus de 7 caractères (donc 8 minimum)

                //une fois toutes les vérifications faites on peut enfin utiliser nos variables
                //venant de notre formulaire pour effectuer notre requête en base de données

                $username = $_POST['username'];
                //le hachage de mot de passe se fait a l'aide de la fonction password_hash
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //toujours hacher les mots de passe
                $email = $_POST['email'];
                $age = $_POST['age'];

                $pdo = new PDO('mysql:host=localhost;dbname=test;charset=utf8',
                'root',
                'password');
                //prepare se charge pour nous de rendre les caractères spéciaux innoffensifs
                //en échappant tous les caractères spéciaux avant de les envoyer à SQL
                //en faisant ça, PDO->prepare() nous protège des attaques par injection
                $query = $pdo->prepare('INSERT INTO user (username, password, email, age) 
                VALUES (:username, :password, :email, :age)');

                $query->execute([
                    ":username" => $username,
                    ":password" => $password,
                    ":email" => $email,
                    ":age" => $age,
                ]);
            }
        }
    }
}

?>

<?php
//imaginons maintenant qu'on lise des données en base de données et qu'on veuille les afficher
//par abondance de précaution on pourrait refiltrer nos variables également avant de les afficher
//imaginons qu'on ait stocké les résultats de notre requête dans une variable résultat
$resultat = getAllArticles($pdo);
//et qu'on veuille afficher les titres de tous les articles
foreach($resultat as $article){
    //imaginons qu'un individu mal intentionné ait mis dans le titre de son article
    //une chaine de caractère spéciaux visant à faire une attaque par Cross Scripting
    //c'est à dire une chaine contenant un script malicieux qui serait executé
    //côté client
    //pour prévenir de cette attaque, il faudrait empêcher l'interpretation des caractères spéciaux
    //par le navigateur, pour ce faire, on peut les convertir en caractères normaux en les echappant
    //la fonction htmlspecialchars() le fait pour nous
    echo htmlspecialchars($article['title']);
    echo '<br>';
    //imaginons que le titre de l'article du pirate etait <script>etc...
    //au lieu que la balise soit interprétée par HTML comme une balise script
    //elle serait interprétée comme du texte écrivant <script> et non une balise spéciale
    //cela afficherait donc le texte '<script>' au lieu de lancer un script
}

//https://www.php.net/manual/fr/function.filter-var.php
//https://www.php.net/manual/fr/filter.filters.php
?>