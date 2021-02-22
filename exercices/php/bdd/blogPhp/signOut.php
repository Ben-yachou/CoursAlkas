<?php
//déconexion de la session
session_start();
session_destroy();
header('Location: articles.php?message=Vous êtes bien déconnecté');