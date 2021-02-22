<?php

/**
 * Contient la classe DatabaseHandler permettant de dialoguer avec la base de données via des méthodes
 */


//on récupère nos modèles de données permettant de ranger proprement les données de la base dans des objets
require_once('model/user.php');
require_once('model/comment.php');
require_once('model/article.php');
require_once('model/image.php');

/**
 * raccourci pour instancier notre databasehandler sur notre bdd blog
 */
function getDatabaseHandler()
{
    return new DatabaseHandler("php_blog", "php_blog", "swC7L6Jpdvmmn8Oj");
}

/**
 * Permet l'utilisation de méthodes de dialogue avec la base de données
 */
class DatabaseHandler
{
    private string $_dbname;
    private string $_username;
    private string $_password;

    //contient l'instance de PDO permettant la communication avec la base de données
    private PDO $_handler;

    public function __construct(string $dbname, string $username, string $password)
    {
        $this->_dbname = $dbname;
        $this->_username = $username;
        $this->_password = $password;

        $this->_handler = $this->getDatabaseConnection();
    }

    /**
     * Permet la connexion à la base de données en instanciant un objet PDO
     * 
     * L'objet PDO instancié est rangé dans la propriété _handler du DatabaseHandler
     */
    public function getDatabaseConnection()
    {
        try {
            $dbh = new PDO("mysql:host=localhost;charset=utf8; dbname={$this->_dbname}", $this->_username, $this->_password);
        } catch (PDOException $e) {
            http_response_code(500);
            die("500 - Internal Server Error");
        }

        return $dbh;
    }

    /**
     * Renvoie l'instance de PDO utilisée par DatabaseHandler
     */
    public function getHandler()
    {
        return $this->_handler;
    }


    #region GESTION DES ARTICLES

    /**
     * Renvoie tous les articles de la base de données 
     * 
     * @return BlogArticle[]
     */
    public function getArticles()
    {
        $stmt = $this->_handler->prepare("SELECT * FROM article ORDER BY created_at");
        $stmt->execute();

        $articles = [];
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //pour chaque ligne de résultat
        foreach ($res as $article) {
            //on range dans un tableau une nouvelle instance de BlogArticle 
            //chaque BlogArticle représente un article

            //on récupère l'objet user auteur de l'article
            $author = $this->getUserById($article['author']);
            array_push($articles, new BlogArticle($article['id'], $author, $article['title'], $article['content'], new DateTime($article['created_at'])));
        }
        //on renvoie nos BlogArticle
        return $articles;
    }

    /**
     * Renvoie un article de type BlogArticle 
     * @param int $id l'id de l'article
     * @return ?BlogArticle
     */
    public function getArticle(int $id): ?BlogArticle
    {
        $stmt = $this->_handler->prepare("SELECT * FROM article WHERE id = :id");
        $stmt->execute([
            ":id" => $id,
        ]);

        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($article) {
            //on récupère l'auteur de l'article 
            //étant donné que notre base de données ne permet pas un article sans auteur
            //on a pas besoin de vérifier si l'auteur a bien été récupéré, il le sera sans problème si l'article existe
            $author = $this->getUserById($article['author']);

            //on renvoie une instance de BlogArticle si on reçoit un résulta
            return  new BlogArticle($article['id'], $author, $article['title'], $article['content'], new DateTime($article['created_at']));
        } else {
            return null;
        }
    }

    /**
     * Insère un article dans notre table article 
     * @return int l'id de l'article créé
     */
    public function createArticle(string $title, string $content, DateTime $created_at, BlogUser $author)
    {
        $this->_handler->beginTransaction();
        $stmt = $this->_handler->prepare("INSERT INTO article (title, content, created_at, author) VALUES (:title, :content, :created_at, :author)");
        //Date de création de l'article
        $date = $created_at->format("Y-m-d H:i:s");
        $stmt->execute(
            [
                ":title" =>  $title,
                ":content" =>  $content,
                ":created_at" =>  $date,
                //on attribue l'id de l'auteur à notre colonne author
                ":author" =>  $author->id,
            ]
        );

        $article_id = $this->_handler->query("SELECT LAST_INSERT_ID()");
        $result = $article_id->fetch(PDO::FETCH_COLUMN);
        $this->_handler->commit();
        return $result;
    }

    /**
     * Permet de modifier un article dans la base de données
     */
    public function updateArticle(int $id, string $title, string $content)
    {
        $stmt = $this->_handler->prepare("UPDATE article SET title = :title, content = :content WHERE id = :id");
        $stmt->execute([
            ":title" => $title,
            ":content" => $content,
            ":id" => $id,
        ]);
    }

    /**
     * SUpprime un article selon son id
     */
    public function deleteArticle(int $id)
    {
        $stmt = $this->_handler->prepare("DELETE FROM article WHERE id = :id");
        $stmt->execute([
            ":id" => $id,
        ]);
    }
    #endregion

    #region GESTION DES COMMENTAIRES

    public function createComment(string $content, DateTime $created_at, BlogUser $author, BlogArticle $article)
    {
        $stmt = $this->_handler->prepare("INSERT INTO comment (content, created_at, author, article) VALUES (:content, :created_at, :author, :article)");

        $date = $created_at->format('Y-m-d H:i:s');
        $stmt->execute([
            ":content" => $content,
            ":created_at" => $date,
            ":author" => $author->id,
            ":article" => $article->id,
        ]);
    }

    public function getCommentsByArticle(BlogArticle $article)
    {
        $stmt = $this->_handler->prepare("SELECT * FROM comment  WHERE article = :article ORDER BY created_at");
        $stmt->execute([
            ":article" => $article->id
        ]);

        $comments = [];
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //pour chaque ligne de résultat
        foreach ($res as $comment) {
            //on range dans un tableau une nouvelle instance de Blogcomment 
            //chaque Blogcomment représente un comment

            //on récupère l'objet user auteur de l'comment
            $author = $this->getUserById($comment['author']);
            array_push($comments, new BlogComment($comment['id'], $comment['content'],  new DateTime($comment['created_at']), $author, $article));
        }
        //on renvoie nos BlogComment
        return $comments;
    }

    /**
     * Get a Comment by its ID
     */
    public function getComment(int $id)
    {
        $stmt = $this->_handler->prepare(
            "SELECT * FROM comment WHERE id = :id"
        );
        $stmt->execute([
            ":id" => $id
        ]);

        $comment = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($comment) {

            $author = $this->getUserById($comment['author']);
            $article = $this->getArticle($comment['article']);
            return new BlogComment($comment['id'], $comment['content'], new DateTime($comment['created_at']), $author, $article);
        } else {
            return null;
        }
    }

    public function updateComment(int $id, string $content)
    {
        $stmt = $this->_handler->prepare("UPDATE comment SET content = :content WHERE id = :id");
        $stmt->execute([
            ":content" => $content,
            ":id" => $id,
        ]);
    }

    public function deleteComment(int $id)
    {
        $stmt = $this->_handler->prepare("DELETE FROM comment WHERE id = :id");
        $stmt->execute([
            ":id" => $id,
        ]);
    }

    #endregion COMMENTAIRES
    //GESTION DES UTILISATEURS

    /**
     * Renvoie un utilisateur selon son id, null sinon 
     * 
     * @return ?BlogUser
     */
    public function getUserById(int $id): ?BlogUser
    {
        $stmt = $this->_handler->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->execute(
            [
                ":id" => $id
            ]
        );

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            //Si l'user a été trouvé on renvoie une instance de BlogUser 
            return new BlogUser($user['id'], $user['username'], $user['password']);
        } else {
            return null;
        }
    }

    /**
     * Renvoie un utilisateur selon son `username`
     * 
     * @return ?BlogUser
     */
    public function getUserByUsername(string $username): ?BlogUser
    {
        $stmt = $this->_handler->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute(
            [
                ":username" => $username
            ]
        );

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return new BlogUser($user['id'], $user['username'], $user['password']);
        } else {
            return null;
        }
    }

    /**
     * Crée un nouvel utilisateur
     * 
     * Renvoie une `Exception` en cas de duplicata
     *
     * @throws Exception
     */
    public function createUser($username, $password_hash)
    {
        $stmt = $this->_handler->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");
        $stmt->execute(
            [
                ":username" =>  $username,
                ":password" =>  $password_hash,
            ]
        );

        $errors = $stmt->errorInfo();

        if ($errors[0] == "23000" && $errors[1] == 1062) {
            throw new Exception("User already exists");
        }
    }

    public function createImage(string $name, string $path, BlogArticle $article, DateTime $created_at)
    {
        $stmt = $this->_handler->prepare("INSERT INTO image (name, created_at, path, article) VALUES (:name, :created_at, :path, :article)");

        $date = $created_at->format('Y-m-d H:i:s');
        $stmt->execute([
            ":name" => $name,
            ":created_at" => $date,
            ":path" => $path,
            ":article" => $article->id,
        ]);
    }

    public function getImagesByArticle(BlogArticle $article)
    {
        $stmt = $this->_handler->prepare("SELECT * FROM image  WHERE article = :article ORDER BY created_at");
        $stmt->execute([
            ":article" => $article->id
        ]);

        $images = [];
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //pour chaque ligne de résultat
        foreach ($res as $image) {
            //on range dans un tableau une nouvelle instance de BlogImage 
            //chaque BlogImage représente un image

            array_push($images, new BlogImage($image['id'], $image['name'], $image['path'], new DateTime($image['created_at']), $article));
        }
        //on renvoie nos BlogImage
        return $images;
    }
}
