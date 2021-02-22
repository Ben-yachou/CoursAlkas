# Calcul volume d'un cone

Produir eun formulaire permettant de récupérer le rayon d'une base ainsi que la hauteur d'un cone afin d'en calculer le volume
Ajouter la possibilité d'arrondir la valeur ou pas à l'aide d'une checkbox

Le volume d'un cone se calcule avec la formule suivante :
`(pi x rayon² x hauteur)/3`
en PHP, pi se récupère à l'aide de la fonction `pi()`
une puissance se fait avec la fonction `pow()`
pour une puissance de 2, cela ferait `pow($rayon, 2)`

Un arrondi se fait à l'aide de la fonction `round()`.
