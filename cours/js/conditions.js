/* 
Opérateurs de comparaisons
== égalité
!= difference
> strictement supérieur
>= supérieur ou égal
< strictement inférieur
<= inférieur ou égal
=== égalité stricte
!== différence stricte 
*/

const age = window.prompt("Entrez votre âge");
if ( age < 0 || age > 127 ) {
    alert("Arrête de raconter des salades");
} else {
    if ( age < 18 ) {
        alert("Rentre chez toi");
    } else {
        alert("Tu peux acheter de l'alcool");
    }
}

/*
Booléens
&& et
true && true === true
true && false === false
false && true === false
false && false === false
true && true && true && true && false === false

|| ou
true || true === true 
true || false === true
false || true === true
false || false === false 

! non
!true = false
!false = true
*/

//le switch/case permet de tester la valeur d'une variable
//en fonction de plusieurs cas prédéfinis 
let fruit = window.prompt("votre fruit préféré ?");
switch (fruit) {
    case "Orange":
        window.alert("Achetez des oranges");
        break;
    case "Banane":
        window.alert("Achetez des bananes");
        break;
    case "Pomme":
        window.alert("Achetez des pommes");
        break;
    default:
        window.alert("Aucun fruit ne vous correspond");
}