<?php

//exemple d'une classe se chargeant de manipuler des messages (erreur ou non) dans le stockage de session
class MessageHandler
{

    const M_MESSAGE = 0;
    const M_ERROR = 1;

    public static function addMessage(string $message, int $type)
    {
        //on peut ajouter un message selon son type (erreur ou simple alerte)
        if ($type == self::M_MESSAGE) {
            if (!isset($_SESSION['messages'])) {
                $_SESSION['messages'] = [];
            }
            array_push($_SESSION['messages'], $message);
        }
        if ($type == self::M_ERROR) {
            //si le stockage de message n'existe pas on l'initialise (tableau vide)

            if (!isset($_SESSION['errors'])) {
                $_SESSION['errors'] = [];
            }
            array_push($_SESSION['errors'], $message);
        }
    }

    //a chaque fois qu'on récupère des messages on les supprime pour ne pas accumuler les messages
    public static function getMessages(int $type)
    {
        if ($type == self::M_MESSAGE && isset($_SESSION['messages'])) {
            $messages =  $_SESSION['messages'];
            self::clearMessages(self::M_MESSAGE);
            return $messages;
        }
        if ($type == self::M_ERROR && isset($_SESSION['errors'])) {
            $errors =  $_SESSION['errors'];
            self::clearMessages(self::M_ERROR);
            return $errors;
        }
    }

    //la suppression se contente de virer les messages de la session
    public static function clearMessages(int $type)
    {
        if ($type == self::M_MESSAGE && isset($_SESSION['messages'])) {
            unset($_SESSION['messages']);
        }
        if ($type == self::M_ERROR && isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
    }
}
