//une chaine de caractères est un tableau de caractères
//on définit généralement une chaîne comme du texte 
//contenu entre guillemets/apostrophes
let exemple = "Coucou"; // guillemets ou double quote
let exemple2 = 'Salut'; // quote
let exemple3 = `Bonjour`; // backquote 

//exemple de chaîne
let chaine = "ceci est une chaîne"; 

//concaténation
let chaine2 = "ceci est " + "une chaîne";

//inclusion de variables
let mot = "cool";
let chaine3 = "les chaines c'est " + mot + " !"; 
let chaine4 = `les chaines c'est ${mot} !`;
//chaine3 et chaine4 donnent "les chaines c'est cool !"

//echappage 
//echapper un caractère permet de le traiter comme faisant partie
// de la chaine et non de la syntaxe javascript
let chaine5 = "ça s'appelle une \"chaine\" "; 

//retour à la ligne
//le retour a la ligne se fait avec le caractère \n
let chaine6 = "je saute une ligne\n";

//PROPRIETES ET METHODES

//pour obtenir la longueur d'une chaine 
let longueur = "coucou".length; //longueur = 6
let longueur2 = chaine6.length;

//pour changer la casse
//toUpperCase() et toLowerCase() renvoient des COPIES des chaines
//avec la casse modifiée, sans modifier la variable initiale
const mot_a_capitaliser = "bonjour";
mot_a_capitaliser.toUpperCase(); //renvoie BONJOUR 
const mot_a_minimiser = "SALUT";
mot_a_minimiser.toLowerCase(); //renvoie salut

//comparaison de chaines
const chaine7 = "toto";
chaine7 === "toto"; //renvoie true
chaine7 === "tata"; //renvoie false
chaine7 === "Toto"; //renvoie false

chaine7.toLowerCase() === "Toto".toLowerCase(); //renvoie true
//on s'assure d'être sur la même casse pour comparer les caractères
//et non pas la casse, c'est une comparaison qui est
//insensible à la casse

//Les chaines sont des tableaux de caractères
//ce qui veut dire qu'on peut accéder a un caractère via son indice
//              0    1    2    3    4
//            ["O", "m", "a", "r", " "....]  
let chaine8 = "Omar n'a jamais vu un téléphone à cadran";
chaine8[0] //premier caractère O
chaine8[4] //4ème caractère espace
chaine8[chaine8.length - 1 ] //dernier caractère n 

//parcourir une chaine
let chaine9 = "phrase";
for (let i = 0; i < chaine9.length; i++){
    chaine9[i]; //le caractère a l'index i
}
//comparer début et fin d'une chaine
let phrase = "Béluga entrainé par les russes";
phrase.startsWith("Béluga"); //true
phrase.startsWith("béluga"); //false
phrase.endsWith("russes"); //true

//décomposer une chaine de caractères en sous parties
//split sépare une chaine de caractère en sous chaines
//a l'aide d'un séparateur 
//exemple, pour récuperer les mots d'une phrase
//on précise a split d'utiliser espace comme séparateur
let mots = phrase.split(" ");
//            0          1         2      3       4
//renvoie ["Béluga", "entrainé", "par", "les", "russes"];
mots[1][0] // renvoie la première lettre du second mot

const jours = "lundi-mardi-mercredi-jeudi-vendredi-samedi-dimanche";
const tabJours = jours.split("-"); //renvoie le tableau 
// ["lundi","mardi","mercredi","jeudi","vendredi","samedi","dimanche"]

//pour retirer les espaces avant et après une chaine on utilise trim
let username = " jojo  ";
username.trim() === "jojo"; //renvoie true