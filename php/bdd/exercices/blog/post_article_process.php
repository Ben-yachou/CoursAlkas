<?php
//on récupère notre session
session_start();
//on vérifie qu'un auteur soit bien connecté
if (isset($_SESSION['userid'])) {


    if (isset($_POST['title']) && isset($_POST['content'])) {

        $title = $_POST['title'];
        $content = $_POST['content'];

        if (!empty($title) && !empty($content)) {

            include("db/db.php");
            $dbh = getDatabaseHandler();

            $author = $dbh->getUserById($_SESSION['userid']);
            if ($author) {


                $article_id = $dbh->createArticle($title, $content, new DateTime(), $author);
                $article = $dbh->getArticle($article_id);

                //UPLOAD DE FICHIER : 
                //on vérifie d'abord qu'un fichier soit bien arrivé, si error est à 0, tout va bien
                if ($_FILES['image'] && $_FILES['image']['error'] == 0) {

                    //on établit une liste blanche des types MIME 
                    $accepted_types = ['image/jpeg', 'image/png', 'image/gif'];
                    //on récupère le type MIME du fichier envoyé grâce à mime_content_type
                    //on ne peut pas se contenter de l'extension de fichier qui est facilement falsifiable
                    $file_mime_type = mime_content_type($_FILES['image']['tmp_name']);
                    //on stocke également la taille du fichier en octet
                    $file_size = $_FILES['image']['size'];

                    //si le type est acceptable
                    if (in_array($file_mime_type, $accepted_types)) {
                        //on vérifie limite maximale 5Mo minimale 100ko
                        if ($file_size < 5 * 1024 * 1024 && $file_size > 100 * 1024) {

                            //un dossier de stockage
                            $upload_dir = "./uploads/";

                            //on récupère le nom originel du fichier
                            $file_original_name = pathinfo($_FILES['image']['name'])['basename'];
                            //on détermine son extension à partir de l'extension d'origine
                            $file_extension = pathinfo($_FILES['image']['name'])['extension'];
                            //on crée le nom aléatoire final de notre image
                            $file_name = md5(uniqid(rand()) . $_FILES['image']['name']);
                            //on crée la destination finale de notre image
                            $path = $upload_dir . $file_name . "." .  $file_extension;
                            //on tente de la déplacer ensuite
                            if (
                                move_uploaded_file($_FILES['image']['tmp_name'], $path)
                            ) {
                                //si on a reussi on stocke nos informations de l'image dans la bdd
                                //pas l'image elle même
                                $dbh->createImage($file_original_name, $path, $article, new DateTime());
                            } else {
                                //défaut d'écriture, on plante tout 
                                die("au secours");
                            }
                        }
                    }
                }
            } else {
                //A remplacer par une vraie page d'erreur
                die('Author does not exist');
            }
            header('Location: index.php');
        }
    }
} else {
    //si aucun user n'est trouvé dans la session on redirige vers la page de connexion
    header('Location: sign_in.php');
}
