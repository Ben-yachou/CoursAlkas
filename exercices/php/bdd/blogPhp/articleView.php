<?php
include('includes/bdd.php');
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $pdo = bddConnect();
    $article = getArticleById($pdo, $id);

    if ($article) {
        $pageTitle = $article['title'];
        include('includes/head.php');
        ?>
        <div class="article">
            <ul>
                <li>
                    <h1 class="article-title">
                        <!-- je crée un lien vers la page article.php -->
                        <!-- ce lien contient un paramètre GET avec l'id unique de l'article-->
                        <!-- On affiche le titre -->
                        <?php echo htmlspecialchars($article['title']); ?>
                    </h1>
                </li>
                <li>
                    <p class="article-author">
                        <?php
                        echo 'Écrit par : ' . htmlspecialchars($article['author']);
                        ?>
                    </p>
                </li>

                <li>
                    <p class="article-content">
                        <?php
                        //nl2br permet de transformer les sauts de ligne dans une chaine
                        //en une balise <br> automatiquement
                        echo nl2br(htmlspecialchars($article['content']));
                        ?>
                    </p>
                </li>
            </ul>
        </div>
        <?php
        //si l'utilisateur est connecté
        if (isset($_SESSION['user_id'])) {
            $user = getUserById($pdo, $_SESSION['user_id']);
            //le formulaire de commentaire est disponible
            ?>
            <form action="commentPost.php" method="POST">
                <label for="content">
                    Écrivez votre commentaire :
                    <input type="text" name="content">
                </label>
                <input type="hidden" name="author" value="<?php echo $user['username'] ?>">
                <input type="hidden" name="id_article" value="<?php echo $article['id'] ?>">
                <input type="submit" value="Envoyer">
            </form>
        <?php
        }

        $comments = getCommentsFromArticle($pdo, $article['id']);
        foreach($comments as $comment){
            
        ?>
        <div class="comment">
            <ul>
                <li>
                    <p class="comment-author">
                        <?php
                        echo 'Écrit par : ' . htmlspecialchars($comment['author']);
                        ?>
                    </p>
                </li>

                <li>
                    <p class="comment-content">
                        <?php
                        //nl2br permet de transformer les sauts de ligne dans une chaine
                        //en une balise <br> automatiquement
                        echo nl2br(htmlspecialchars($comment['content']));
                        ?>
                    </p>
                </li>
            </ul>
        </div>
        <?php
        }
        
    }
include('includes/foot.php');
}
