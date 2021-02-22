<?php
class DatabaseHandler
{

    private $_dbh;
    function __construct()
    {
        $dbname = "messageboard";
        $dbuser = "messageboard";
        $dbpassword = "Ge5z8YclkqXS8AWJ";

        try {
            $this->_dbh = new PDO("mysql:host=localhost;dbname=" . $dbname . ";charset=utf8;", $dbuser, $dbpassword);
        } catch (PDOException $exception) {
            die("Erreur connexion à la base de données");
        }
    }


    function getMessages()
    {

        $get_messages = "SELECT user.nickname, message.* FROM user INNER JOIN message ON user.id = message.author ORDER BY message.sent_at";

        $stmt = $this->_dbh->prepare($get_messages);

        $stmt->execute();

        $messages = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $messages;
    }

    function sendMessage($content, $author)
    {
        $new_message = "INSERT INTO message (content, sent_at, author) VALUES (:content, :sent_at, :author);";

        $stmt = $this->_dbh->prepare($new_message);

        $sent_at = date('Y-m-d H:i:s');

        $stmt->execute([
            ":content" => $content,
            ":sent_at" => $sent_at,
            ":author" => $author
        ]);
    }
}
$dbh = new DatabaseHandler();
