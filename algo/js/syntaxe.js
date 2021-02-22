//Ceci est un commentaire
/* 
Ceci est un commentaire multiligne 
Un commentaire n'est pas interprété lors de l'exécution du code
et sert donc souvent à documenter le code
*/ 

//VARIABLES
//En javascript, une variable se déclare à l'aide du mot clé "let"
let nombre = 10 //ci on définit une variable nommée nombre contenant comme valeur 10 
//en javascript, les données sont typées dynamiquement
//c'est à dire que javascript définit le type de la donnée automatiquement selon la donnée stockée 
//dans un langage typé statiquement, comme le c, on devrait déterminer le type de la variable au moment de la déclaration :
//ex: int nombre = 10; 
let message = "coucou" //ici on définit une variable nommée message contenant une chaine de caractères "coucou"
//une chaine de caractères peut se définir à l'aide de simple quote (')
//de double quotes (")
//ou back quotes (`) qui diffèrent légèrement des deux premiers 

//pour utiliser une valeur stockée dans une variable on appelle tout simplement son nom
let a = 5
let b = 3
let c = a + b //c contient la valeur 8 

//pour définir une constante (une variable ne pouvant pas changer) on utilise le mot clé const 
const neChangeraPas = 12
neChangeraPas = 13 //Impossible : javascript empêche de changer une const

//LES CONDITIONS
//un branchement conditionnel en javascript se fait à l'aide d'un if (la plupart du temps)
//une condition se fait sur ue comparaison ou sur n'importe quelle opération renvoyant un booléen (true ou false)
//pour effectuer des comparaisons, js possède différents opérateurs 
/*
== égalité
!= différence
> superiorité stricte
< inferiorité stricte
>= supériorité ou égalité
<= inferiorité ou égalité 
=== égalité stricte
!== différence stricte
*/ 
let age = 12 
//pour écrire une condition avec un Si 
//on écrit if (condition ) {  }
//et on écrit les instructions entre les accolades
if (age < 18) {
    //ici on indique que faire si la condition est validée
    //revenez plus tard
} else {
    //ici on indique quoi faire dans le cas contraire
    //go
    if ( age > 21 ) {
        //on peut imbriquer des conditions dans d'autres conditions
        //vous avez le droit de boire aux usa
    }
}

//booléens :
//pour pouvoir gérer des conditions complexes, on peut associer des conditions entre elles avec des opérateurs de logique tirés de l'algèbre de Boole
//l'opérateur "et" s'inscrit &&
// true && true === true
// true && false === false
// false && true === false
// false && false === false

//l'opérateur "ou" s'inscrit || 
// true || true === true 
// true || false === true 
// false || false === false 

//le "non" s'exprime avec ! 
// !true === false
// !false === true
// !(true && false) === true
// !(true || false) === false

// LES BOUCLES 
//pour écrire une boucle on peut utiliser while ou for 
let i = 1 
while (i <= 100){
    //on affiche i par exemple  
    i=i+1 // on ajoute 1 à i (incrémentation)
}

//la boucle for quant à elle permet d'effectuer des opérations répétées comme le while
//mais sa syntaxe permet de définir un départ, un arrêt, et une opération à effectuer à chaque fois, le tout sur une même ligne
// for (départ; arrêt; changement) {}
for (let i = 1; i <= 100; i=i+1){
    //instructions de la boucle ici 
}

//FONCTIONS 
//une fonction se déclare à l'aide du mot clé function
//les paramètres d'entrée d'une fonction se définissent entre parenthèses à la suite du nom de la fonction
function additionner(a, b){
    //le mot clé return met fin à l'exécution de la fonction
    //et renvoie la valeur précisée
    return a+b
}
//en invoquant une fonction avec une valeur de retour (return), cette fonction renvoie la valeur de retour comme le ferait une variable  
additionner(1, 2) //renverra 3 
additionner(3, -6) //renverra -3
additionner(additionner(1, 2), additionner(3, 3)) //renverra 9