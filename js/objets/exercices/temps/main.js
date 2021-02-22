//Implémenter une classe Temps permettant de stocker et gérer des heures, minutes et secondes
//Cette classe permettra d'instancier des objets pour stocker une heure précise et possédera des méthodes pour incrémenter ou décrementer le temps selon un ordre de grandeur
//par exemple : monTemps.secondePrecedente() fera reculer le temps stocké d'une seconde
//monTemps.minuteSuivante() fera avancer le temps stocké d'une minute
//Il faut aussi pouvoir régler n'importe quelle unité avec reglerSeconde, reglerMinute ou reglerHeure
//ajouter de façon arbitraire avec ajouterSeconde, ajouterMinute et ajouterHeure
//soustraire avec soustraireSeconde, soustraireMinute, soustraireHeure
//On aura également une méthode affichage() qui affichera l'heure complète au format hh:mm:ss

//Bonus : écrire une méthode "lire()" qui "lira" l'heure au format "Il est 11 heures moins le quart" au lieu de "Il est 10:45". 

//exemple d'utilisation : 
//const monTemps = new Temps(10, 30, 12);
//temps.affichage(); -> renvoie 10:30:12
//temps.minuteSuivante();
//temps.affichage(); -> renvoie 10:31:12
//temps.reglerMinute(59);
//temps.affichage(); -> renvoie 10:59:12
//temps.ajouterMinute(3);
//temps.affichage(); -> renvoie 11:02:12