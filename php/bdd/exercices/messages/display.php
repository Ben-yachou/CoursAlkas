<?php

//exemple d'utilisation d'une fonction pour renvoyer du html
function displayMessages($messages, $userid)
{
    foreach ($messages as $message) {
        $author_nickname = $message->nickname;
        $css_class = "";
        if ($userid === $message->author) {
            $author_nickname = "Moi";
            $css_class = "mine";
        }


        echo sprintf(
            "
                <div class='message %s'>
                    <span class='author-name'>
                        %s :
                    </span>
                    <span class='message-time'>
                        %s
                    </span>
                    <span class='message-content'>
                        %s
                    </span>
                </div>
                ",
            $css_class,
            $author_nickname,
            $message->sent_at,
            $message->content,
        );
    }
}
