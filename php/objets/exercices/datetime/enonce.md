# Implémentation d'une classe MaDate et MonTemps

Implémenter une classe MaDate permettant de manipuler les dates du calendrier.

Une date contiendra les attributs annee, mois, jour :

-   une année comprise entre 1 et 9999
-   un mois entre 1 et 12
-   un jour entre 1 et 31

La classe MaDate doit également permettre de régler le jour, le mois et l'année (mutateurs) indépendamment, avec des méthodes :

-   `reglerJour($jour)`
-   `reglerMois($mois)`
-   `reglerAneee($aneee)`

Elle doit également renvoyer une erreur si une date est invalide, genre 31 novembre ou 200 à la place du jour.

Des méthodes doivent également permettre d'incrémenter/décrementer de 1 chaque valeur

-   `jourSuivant()`, `jourPrecedent`
-   `moisSuivant()`, `moisPrecedent`
-   `anneeSuivante()`, `anneePrecedente`

Ces méthodes doivent gérer le passage de mois, d'année etc (une fois le 30/31 atteint par exemple, ou le 1er janvier atteint).

Une dernière méthode `estBissextile()` doit renvoyer `true` si l'année stockée est bissextile, `false` sinon.

Si vous vous chauffez, vous pouvez réessayer d'implémenter `jourSemaine()`, en version calculée et non trichée de `DateTime`.

Une méthode `afficher()` permettra d'afficher la date au format "Vendredi, 06 Novembre 2020".

### Pour la classe MonTemps

Même chose que pour MaDate avec l'heure, sans les histoires bissextile et jour semaine bien évidemment.

Ajouter une méthode `lire()` qui permet de lire l'heure stockée genre "il est dix heures moins le quart";
"il est treize heures quinze"
