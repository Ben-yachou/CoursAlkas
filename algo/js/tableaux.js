//Un tableau est une structure de données de taille définie 
//permettant de stocker un jeu de données de même type. 
//En javascript (et en programmation en général) un tableau se déclare
//à l'aide de crochets []
let tableauVide = [] //déclaration d'un tableau vide

//un tableau contient des "cases", chaque case contient une donnée
//chaque case est séparée par une virgule
//                      0        1          2
let listeCourses = ['eponges', 'pates', 'sauce tomate']
//pour accéder aux données stockées dans le tableau on utilise un indice 
listeCourses[0] //contient "eponges"
listeCourses[1] //contient "pates"
listeCourses[2] //contient "sauce tomate"
listeCourses[3] //renvoie undefined

//pour récupérer la taille d'un tableau on peut utiliser array.length
listeCourses.length //renvoie 3
//le dernier élément d'un tableau se trouve à array[array.length - 1]

//pour parcourir un tableau, une bonne méthode est d'utiliser une boucle
//la boucle for semble toute indiquée 
//un tableau commence à 0, donc on initialise i à 0 
//on s'arrête juste avant la fin du tableau 
//et on avance de case en case
for (let i = 0; i < listeCourses.length; i++){
    //pour chaque tour de boucle, on affichera une case du tableau
    console.log(listeCourses[i])
}

//pour ajouter un élément à la fin d'un tableau 
//on utilise array.push(element)
listeCourses.push('sel') // ['eponges', 'pates', 'sauce tomate', 'sel']
listeCourses[3] //renvoie "sel"

//pour retirer le dernier élément d'un tableau 
//on utilise array.pop() 
listeCourses.pop() //renvoie et supprime le dernier element du tableau
// ['eponges', 'pates', 'sauce tomate']

//ajouter un élément au début du tableau demande l'utilisation de 
//array.unshift(element)
listeCourses.unshift('whisky')
//['whisky', 'eponges', 'pates', 'sauce tomate']

//supprimer le premier élément du tableau se fait à l'aide de 
//array.shift()
listeCourses.shift() //renvoie et supprime 'whisky' de la liste
//['eponges', 'pates', 'sauce tomate']

//array.splice() permet de raccorder, supprimer et remplacer des éléments dans un tableau 
//pour remplacer un élément par un autre par exemple 
//à la case 1, je supprime 1 élément, et insère l'élément "pates completes"
listeCourses.splice(1, 1, 'pates completes')
//listeCourses contient ['eponges', 'pates completes', 'sauce tomate']
//on peut séparer les éléments à insérer par des virgules pour en insérer plusieurs 
//à la case 1, on supprime 0 élément, et on insère "parmesan" et "pesto"
listeCourses.splice(1, 0, 'parmesan', 'pesto')
//listeCourses contient ['eponges', 'parmesan', 'pesto', 'pates completes', 'sauce tomate']
//splice renvoie également tous les éléments supprimés 

//array.slice() renvoie une partie d'un tableau 
//en faisant une copie des éléments à partir d'une borne inferieure (incluse) jusqu'à une borne superieure (exclue)
listeCourses.slice(1, 4) // renvoie ['parmesan', 'pesto', 'pates completes']