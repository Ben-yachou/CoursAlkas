<?php
//Ici on regroupera toutes les fonctions qui permettront d'afficher du HTML dans notre blog 

/**
 * Affiche l'en-tête html de la page
 * @param string $title le titre de la page
 */
function displayHeader(string $title)
{
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>{$title}</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' media='screen' href='css/main.css'>
    </head>
    <body>
        <div class='container'>
    ";
}

/**
 * Affiche le pied de page html de la page
 */
function displayFooter()
{
    echo "
    </div>
    </body>
    </html>";
}

/**
 * Affiche le menu de navigation
 * @param User $user l'utilisateur connecté
 */
function displayNav($user = null)
{
    if ($user) {
        $navlinks = "<li><a href='post_article.php'>New Article</a></li>
        <li><a href='sign_out.php'>Sign Out</a></li>";
    } else {
        $navlinks = "
        <li><a href='sign_in.php'>Sign In</a></li>
        <li><a href='sign_up.php'>Sign Up</a></li>";
    }

    echo "
    <nav>
        <ul>
            <li><a href='index.php'>Home</a></li>
            {$navlinks}
        </ul>
    </nav>
    ";
}


/**
 * Affiche la représentation html d'un article
 */
function displayArticle(BlogArticle $article, ?BlogUser $user)
{
    //affichage des actions dans le footer
    if ($user && $user->id == $article->author->id) {
        $footer = "<a class='action update' href='update_article.php?id={$article->id}'>update</a>
        <a class='action delete' href='delete_article.php?id={$article->id}'>delete</a>";
    } else {
        $footer = "";
    }

    $article_content = nl2br(htmlspecialchars($article->content, ENT_QUOTES));
    $article_author = htmlspecialchars($article->author);

    echo "
    <article>
        <header> 
        <h2>{$article->title}</h2> 
        <h3>{$article_author}</h3> 
        <h4> {$article->created_at->format('Y-m-d H:i:s')} </h4> 
        </header>
        <section>
        <p> {$article_content} </p>
        </section> 
        <footer>
            {$footer}
        </footer>
    </article>";
}

function displayArticles(array $articles, ?BlogUser $user)
{

    foreach ($articles as $article) {
        //affichage des actions dans le footer
        if ($user && $user->id == $article->author->id) {
            $footer = "<a class='action update' href='update_article.php?id={$article->id}'>update</a>
            <a class='action delete' href='delete_article.php?id={$article->id}'>delete</a>";
        } else {
            $footer = "";
        }

        // //on coupe notre contenu en mots avec explode, on récupère les n premiers mots, et on colle le tout avec des espaces
        // $truncated = implode(" ", array_slice(explode(" ", $article->content), 0, 15));
        // //on passe ensuite le résultat dans nl2br et on y concatène une ellipse
        // $article_content = nl2br($truncated) . "…";
        $article_content = nl2br(htmlspecialchars($article->content, ENT_QUOTES));

        $article_author = htmlspecialchars($article->author);


        echo "
        <article class='truncated'>
            <div class='main'>
            
            <header> 
            <h2> <a href='view.php?id={$article->id}'>{$article->title}</a> </h2> 
            <h3>{$article_author}</h3> 
            <h4> {$article->created_at->format('Y-m-d H:i:s')} </h4> 
            </header>
            <section>
            <p> {$article_content} </p>
            </section> 
            <footer>
                {$footer}
            </footer>
            </div>
            <a href='view.php?id={$article->id}'>Read More</a>
            </article>
        ";
    }
}

function displayComments(array $comments, ?BlogUser $user)
{



    foreach ($comments as $comment) {

        $footer = "";

        //soit on est l'auteur du commentaire soit l'auteur de l'article 
        if ($user && ($user->id == $comment->author->id || $user->id == $comment->article->author->id)) {
            //alors la suppression est possible
            $footer .= "<a class='action delete' href='delete_comment.php?id={$comment->id}'>delete</a>";
        }

        //si on est l'auteur du commentaire on peut le modifier
        if ($user && $user->id == $comment->author->id) {
            $footer .= "<a class='action update' href='update_comment.php?id={$comment->id}'>update</a>";
        }

        $comment_content = nl2br(htmlspecialchars($comment->content, ENT_QUOTES));

        $comment_author = htmlspecialchars($comment->author);
        echo
            "<div>
        <h4>{$comment_author}</h4>
        <p>{$comment_content}</p>
        {$footer}
        </div>
        ";
    }
}

//exemple d'une gestion d'affichage de messages stockés dans la session
require_once('messageHandler.php');

function displayMessages()
{

    if ($errors = MessageHandler::getMessages(MessageHandler::M_ERROR)) {
        foreach ($errors as $error) {
            echo "<div class='alert error'>${error}</div>";
        }
    }
    if ($messages = MessageHandler::getMessages(MessageHandler::M_MESSAGE)) {
        foreach ($messages as $message) {
            echo "<div class='alert message'>${message}</div>";
        }
    }
}
