<?php
//un cookie est une forme de stockage côté client (dans le navigateur)
//permettant de gérer une persistance de données via un couple clé/Valeur (en texte uniquement)
//pour stocker une donnée de cette manière  on utilise la fonction setcookie
setcookie('last_connected', date('Y-m-d H:i:s')); //date() permet de formater la date récupérée au moment de l'exécution, Y-m-d H:i:s donne 2020-11-05 10:44:31
//le cookie créé ici aura comme clé last_connected et comme valeur la date du jour

//il existe entre autres un troisième paramètre permettant de définir une date d'éxpiration du cookie
//ce troisième paramètre accepte une timestamp (nb de secondes depuis le 1er janvier 70 minuit GMT)
//time() permet de récupérer la date en seconde au moment de l'exécution, en y ajoutant le nombre de seconde correspondant à une semaine on définit une expiration dans une semaine
setcookie('expire_dans_une_semaine', 'coucou', time() + (60*60*24*7));


//pour accéder à la valeur d'un cookie on utilise la superglobale $_COOKIE
echo $_COOKIE['last_connected'];

//pour modifier un cookie déjà mis en place on utilise juste setcookie avec la même clé 

//pour supprimer un cookie déjà existant, on peut utiliser deux méthodes : 
setcookie('last_connected', null, -1);
//ou alors on peut désinitialiser le cookie dans $_COOKIE 
unset($_COOKIE['last_connected']);