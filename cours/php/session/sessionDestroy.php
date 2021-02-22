<?php
//pour se déconnecter d'une session
//il faut d'abord aller chercher la session existante 
//à l'aide de session_start
session_start();

//puis la supprimer à l'aide de session_destroy()
session_destroy();

//appeler session_destroy() supprime $_SESSION et son contenu
?>