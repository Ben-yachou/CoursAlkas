<?php

function bddConnect()
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=blogphp;charset=utf8', 'root', 'password');
    } catch (PDOException $exception) {
        die($exception->getMessage());
    }

    return $pdo;
}

function getAllArticles($pdo)
{
    $query = $pdo->prepare('SELECT * FROM article');
    $query->execute();
    //fetchAll récupère un tableau contenant toutes les données
    //au lieu de récupérer une ligne à la fois
    $articles = $query->fetchAll();
    $query->closeCursor();
    return $articles;
}

function getArticleById($pdo, $id)
{
    $query = $pdo->prepare('SELECT * FROM article WHERE article.id = :id');
    $query->execute([
        ':id' => $id,
    ]);
    $article = $query->fetch();
    $query->closeCursor();
    return $article;
}

function createArticle($pdo, $title, $content, $author, $image)
{
    $query = $pdo->prepare('INSERT INTO article (title, content, author, image)
    VALUES (:title, :content, :author, :image)');
    //$query->execute() renverra false si une erreur est survenue
    return $query->execute(
        [
            ':title' => $title,
            ':content' => $content,
            ':author' => $author,
            ':image' => $image
        ]
    );
}

function createUser($pdo, $username, $email, $password, $sign_date){
    //on prépare notre requête insert into
    $query = $pdo->prepare('INSERT INTO user (username, email, password, sign_date) 
    VALUES (:username, :email, :password, :sign_date)');
    //on exécute notre requête avec nos paramètres de formulaire
    $query->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $password,
        ':sign_date' => $sign_date,
    ]);
    //on récupère errorInfo pour connaître la nature de l'execution de notre requête
    //c'est à dire si tout s'est déroulé correctement ou si une erreur est survenue
    $query_error = $query->errorInfo(); //errorInfo() nous renvoie un tableau à 3 cases
    //la première case contient le code SQLSTATE décrivant l'état de la requête, sur 5 caractères
    //la deuxième case contient, si erreur il y a, le code d'erreur de SQL
    //la troisième case contient, si erreur il y a, le message d'erreur de SQL

    //si tout se passe bien, le tableau ressemblera à ['00000', '', '',]
    //c'est à dire que code SQLSTATE sera à zéro
    //si une erreur survient (erreur de duplicata par exemple) ["23000", 1062, 'erreur duplicata'];

    //on teste si une erreur est survenue, donc si le code SQLSTATE n'est PAS 00000
    if ($query_error[0] != "00000") {
        //si le code d'erreur est celui du duplicata
        if ($query_error[1] == 1062) {
            return -1; //on renvoie -1 en cas d'un duplicata
        } else {
            //sinon on plante la page en envoyant le message d'erreur
            return 0; //on renvoie 0
        }
    }
    return 1; 
}

function getUserFromUsernameOrEmail($pdo, $user){
    $query = $pdo->prepare('SELECT * FROM user WHERE username = :user OR email = :user');

    $query->execute([
        ":user" => $user
    ]);
    $user = $query->fetch();
    return $user;
}

function getUserById($pdo, $id){
    $query = $pdo->prepare('SELECT username FROM user WHERE id = :id');
    $query->execute([
        ':id' => $id
    ]);
    $user = $query->fetch();
    return $user;
}

function createComment($pdo, $content, $author, $id_article){
    $query = $pdo->prepare('INSERT INTO commentaire (content, author, id_article) 
    VALUES (:content, :author, :id_article)');
    return $query->execute([
        ':content' => $content,
        ':author' => $author,
        ':id_article' => $id_article,
    ]);
}

function getCommentsFromArticle($pdo, $id_article){
    $query = $pdo->prepare('SELECT * FROM commentaire WHERE id_article = :id_article');
    $query->execute([
        ':id_article' => $id_article,
    ]);
    return $query->fetchAll();
}