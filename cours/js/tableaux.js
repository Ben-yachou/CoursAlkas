//                      0          1        2
//                 | Ravioli |  Eponges |  Maïs | 
let listeCourses = ["Ravioli", "Eponges", "Maïs"];

console.log("Appeler les cases une à une"); 
console.log(listeCourses[0]); //affiche Ravioli dans la console
console.log(listeCourses[1]); //affiche Eponges dans la console
console.log(listeCourses[2]); //affiche Maïs dans la console
console.log(listeCourses[3]); //affiche undefined dans la console

//pour parcourir un tableau, la meilleure méthode est d'utiliser une boucle for
//en effet, la boucle for permettant de spécifier un début et une fin
//ainsi qu'un pas d'avancement, on peut définir le début (i) à 0 (le début du tableau)
//et la fin à tableau.length (qui est la longueur du tableau)
//en spécifiant i < tableau.length on évite ainsi de dépasser du tableau 
for (let i = 0; i < listeCourses.length; i++){
    console.log(listeCourses[i]);
}

//pour ajouter un élément à la fin du tableau on utilise
//tableau.push
listeCourses.push("Sauce Tomate");
console.log(listeCourses[3]); //affiche Sauce Tomate
console.log(listeCourses[2]); //affiche Maïs

//pour ajouter un élément au début de notre tableau
//on utilise tableau.unshift
listeCourses.unshift("Whisky");
console.log(listeCourses[0]); //affiche Whisky
console.log(listeCourses[1]); //affiche Ravioli
console.log(listeCourses[4]); //affiche Sauce Tomate

//tableau.pop() permet de retirer et renvoyer le dernier element d'un tableau
//le resultat de tableau.pop() est l'élément retiré
let sauce = listeCourses.pop();
console.log(listeCourses[4]);
console.log(sauce); //affiche Sauce Tomate

//tableau.shift permet de retirer le premier element d'un tableau
listeCourses.shift();
console.log(listeCourses[0]);//affiche Ravioli

//tableau.splice (raccord) permet de supprimer et remplacer des éléments
//le résultat de tableau.splice() est l'élément retiré
console.log(listeCourses); // Affiche ["Ravioli", "Eponges", "Maïs"]
listeCourses.splice(0, 1, "Linguine", "Ail", "Huile d'Olive");    
console.log(listeCourses); // Affiche [ "Linguine", "Ail", "Huile d'Olive", "Eponges", "Maïs" ]

//tableau.slice (tranche) récupère une partie du tableau
//en faisant une copie partant d'une borne inférieure (incluse)
//et en allant jusqu'a une borne supérieure (exclue)
const ingredientsRecette = listeCourses.slice(0,3);
console.log(ingredientsRecette); //affiche ["Linguine", "Ail", "Huile d'Olive"]