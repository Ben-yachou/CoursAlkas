<?php 
//pour stocker une valeur dans un cookie
//on utilise la fonction setcookie()
//le premier paramètre est la clé du cookie
//le second paramètre est la valeur stockée
//un troisième paramètre peut être précisé
//pour donner un temps d'expiration au cookie
setcookie('lang', 'fr');
//ici le cookie est voué a expirer dans 1 an
//time() renvoie le temps actuel en secondes
//pour rajouter un an on doit donc passer ça en heure (*3600)
//puis en jours (*24)
//puis en année (*365)
setcookie('pseudo', 'jojo2', time() + 365 * 3600 * 24);

//pour récuperer un cookie on utilise la superglobale
//$_COOKIE 
echo $_COOKIE['pseudo'];
?>