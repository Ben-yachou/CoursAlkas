//une fonction possède un nom
//ce nom doit explicitement représenter son rôle
function direBonjour(){
    //le corps de la fonction dicte ce qui sera exécuté au moment
    //de l'appel de la fonction
    console.log("Bonjour");
    //lorsqu'une fonction ne comporte pas de mot clé
    //"return", la fonction est donc une procédure
    //dans le sens où elle ne renvoie pas de résultat
    //mais effectue une action
}

//pour appeler une fonction on précise simplement son nom
direBonjour();

function direSalut(){
    //en utilisant le mot clé "return"
    //la fonction renvoie donc un résultat au lieu d'effectuer une action
    //ce résultat pourra être ensuite récupéré au moment de l'appel
    return "Salut";
}

console.log(direSalut());

//une fonction peut prendre des paramètres en "entrée"
//ces paramètres (ou arguments) seront utilisables en tant que variables
//dans tout le corps de la fonction
function multiplier(x, y){
    //le mot clé return permet de renvoyer une valeur
    //et termine l'exécution de la fonction
    return x*y;
}

//on récupère le résultat de la fonction multiplier
//qui a été appelée avec comme paramètres x=40 et y=503
let resultat = multiplier(40, 503);
//une fois le résultat récupéré, on l'affiche dans la console
console.log(resultat);

// let a = prompt("Entrez le premier opérande");
// let b = prompt("Entrez le second opérande");
// console.log(multiplier(a,b));

//javascript possède ses propres fonctions internes
//par exemple cette fonction Math.random() qui permet de générer un nombre 
//pseudo aléatoire compris dans l'intervalle  [0, 1[ (signifie 0 à 1, 1 non inclus)
console.log(Math.random());

//ces fonctions, comme toute autre fonction, sont utilisables
//dans nos propres fonctions 
//dans ce cas on peut par exemple utiliser math.random 
//pour créer un nouveau résultat
//cette fonction renvoie un nombre aléatoire entre min (inclus) et max (exclu)
function nombreAleatoire(min, max){
    return Math.floor((Math.random() * (max-min) + min));
}

console.log(nombreAleatoire(2, 20));


function auCarre(num){
    return num*num;
}

console.log(auCarre(300));