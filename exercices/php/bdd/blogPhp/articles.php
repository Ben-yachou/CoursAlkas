<?php
include('includes/bdd.php');
$pageTitle = 'Articles';
include('includes/head.php');
//appel a notre fonction bddConnect se trouvant dans le fichier bdd.php
$pdo = bddConnect();

$data = getAllArticles($pdo);

//affichage de tous les articles
//pour chaque element contenu dans $data
//je fais un tour de boucle et stocke l'element dans une variable $article
foreach ($data as $article) {
    //je récupère l'id de l'article dans l'élément $article
    $articleId = $article['id'];
    ?>
    <div class="article">
        <ul>
            <li>
                <h3 class="article-title">
                    <!-- je crée un lien vers la page article.php -->
                    <!-- ce lien contient un paramètre GET avec l'id unique de l'article-->
                    <a href="articleView.php?id=<?php echo $articleId; ?>">
                        <!-- On affiche le titre -->
                        <!-- htmlspecialchars() permet d'empêcher les caractères spéciaux d'être
                        interprétés par HTML ce qui pourrait mener a des attaques de cross-scripting-->
                        <?php echo htmlspecialchars($article['title']); ?>
                    </a>
                </h3>
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
                    echo substr(htmlspecialchars($article['content']), 0, 64) . '...';
                    ?>
                </p>
            </li>
        </ul>
    </div>

<?php
} //fermeture du foreach
include('includes/foot.php');
?>