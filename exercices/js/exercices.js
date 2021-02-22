//EXERCICE 1
//Créez un tableau Mousquetaires
//Ce tableau contiendra le nom des trois mousquetaires
//Athos, Porthos, Aramis
// 1 - Afficher le nom de chaque mousquetaire
// 2 - Ajouter D'Artagnan au tableau
// 3 - Afficher le nom de chaque mousquetaire à l'aide d'un for
// 4 - Supprimer Porthos du tableau en conservant les autres
function exercice1() {
    let mousquetaires = ["Athos", "Porthos", "Aramis"];
    console.log(mousquetaires[0]); //Affiche Athos dans la console
    console.log(mousquetaires[1]); //Affiche Porthos dans la console
    console.log(mousquetaires[2]); //Affiche Aramis dans la console

    mousquetaires.push("D'Artagnan"); //Ajoute D'Artagnan à la fin de mousquetaires
    // possible d'utiliser mousquetaires.unshift pour mettre d'Artagnan au début
    console.log(mousquetaires[3]); //Affiche D'Artagnan dans la console

    for (let i = 0; i < mousquetaires.length; i++) {
        console.log("boucle for: " + mousquetaires[i]); //affiche un element pour chaque tour de boucle
        //+ est l'opérateur de concaténation en javascript
        //concaténer est l'action de lier deux chaines de caractères ensemble
    }

    mousquetaires.splice(1, 1); //suppression de Porthos
}


//EXERCICE 2
//Faire la somme des valeurs d'un tableau
//à l'aide d'une seule boucle
//             0  1  2  3   4   5   6
function exercice2() {
    let valeurs = [4, 1, 8, 49, 10, 3, -3];

    let somme = 0;
    for (let i = 0; i < valeurs.length; i++) {
        somme = somme + valeurs[i];
    }
    console.log(somme);
}

//EXERCICE 3 
//Ecrire une fonction renvoyant les n derniers éléments
//d'un tableau (que l'on envoie en paramètre)
//Avec un deuxième paramètre on pourra spécifier
//le nombre d'éléments n à renvoyer

//Solution de Quentin
//compte le nombre d'éléments à renvoyer 
//et les sors un par un pour les mettre dans un nouveau tableau
function exercice3a() {
    let elements = [1, 5, 8, 1, 198, 12, -1, 8, -7, 14];
    let n = window.prompt("Définir les n derniers éléments à récupérerr");

    function renvoieDerniers(tableau, n) {
        let newTableau = [];
        for (let i = 0; i < n; i++) {
            newTableau.push(tableau.pop());
        }
        return newTableau;
    }

    console.log(renvoieDerniers(elements, n));
}

//solution avec for, on part du n element en partant de la fin
//et on récupère les éléments l'un après l'autre
function exercice3b() {
    let elements = [1, 5, 8, 1, 198, 12, -1, 8, -7, 14];
    let n = window.prompt("Définir les n derniers éléments à récupérer");

    function renvoieDerniers(tableau, n) {
        let newTableau = [];
        for (let i = tableau.length - n; i < tableau.length; i++) {
            newTableau.push(tableau[i]);
        }
        return newTableau;
    }
    console.log(renvoieDerniers(elements, n));
}

//solution avec for en partant de la fin, puis, en reculant
//on récupère les derniers elements un a un 
function exercice3c() {
    let elements = [1, 5, 8, 1, 198, 12, -1, 8, -7, 14];
    let n = window.prompt("Définir les n derniers éléments à récupérer");

    function renvoieDerniers(tableau, n) {
        let newTableau = [];
        for (let i = tableau.length - 1; i >= tableau.length - n; i--) {
            newTableau.push(tableau[i]);
        }
        return newTableau;
    }
    console.log(renvoieDerniers(elements, n));
}

//on récupère une tranche du tableau comportant les n derniers elements
function exercice3d() {
    let elements = [1, 5, 8, 1, 198, 12, -1, 8, -7, 14];
    let n = window.prompt("Définir les n derniers éléments à récupérer");

    function renvoieDerniers(tableau, n) {
        return tableau.slice(tableau.length - n, tableau.length);
    }

    console.log(renvoieDerniers(elements, n));
}

//solution avec slice en verifiant que n ne soit pas trop grand
function exercice3e() {
    let elements = [1, 5, 8, 1, 198, 12, -1, 8, -7, 14];
    let n = window.prompt("Définir les n derniers éléments à récupérer");
    function renvoieDerniers(tableau, n) {
        if (n <= tableau.length) {
            return tableau.slice(tableau.length - n);
        } else {
            console.error("n trop grand");
        }
    }
    console.log(renvoieDerniers(elements, n));
}


//EXERCICE 4
//Ecrire une fonction renvoyant la moyenne d'un tableau de valeurs
function exercice4() {
    let valeurs = [32, 4, 31, 12, 4, 27, 15, 17, 8, 1];
    function moyenne(tableau) {
        let somme = 0;
        for (let i = 0; i < tableau.length; i++) {
            somme = somme + tableau[i];
        }
        let moyenne = somme / tableau.length;
        return moyenne;
    }
    console.log(moyenne(valeurs));
}

//EXERCICE 5
//Ecrire une fonction renvoyant
//le nombre le plus grand d'un tableau
function exercice5() {
    let valeurs = [32, 4, 31, 12, 8, 44, 64, 27, 15, 17, 8];

    function maximum(tableau) {
        let nombreMax = -Infinity;
        for (let i = 0; i < tableau.length; i++) {
            if (tableau[i] > nombreMax) {
                nombreMax = tableau[i];
            }
        }
        return nombreMax;
    }
    console.log(maximum(valeurs));
}

//EXERCICE 6
//A partir d'un tableau de mots ex : ["Salut", "les", "amis", "!"]
//il faut recréer à l'aide d'une boucle la phrase complète, en séparant les mots d'un espace
//pour lier un mot à un autre, on utilise +
function exercice6() {
    // 0       1      2      3
    let mots = ["Salut", "les", "amis", "!"];

    let phrase = "";
    function reconstituerPhrase(tableau) {
        for (let i = 0; i < tableau.length; i++) {
            if (i !== 0) {
                phrase += " ";
            }
            phrase += tableau[i];
        }
        return phrase;
    }

    console.log(reconstituerPhrase(mots));
}

//EXERCICE 7
//Même chose mais en partant d'un tableau de mots
//organisé à l'envers
// ["!", "amis", "les", "Salut"]
function exercice7() {
    let mots = ["!", "amis", "les", "Salut"];

    let phrase = "";
    function reconstituerPhraseALenvers(tableau) {
        for (let i = tableau.length - 1; i >= 0; i--) {
            if (i !== tableau.length - 1) {
                phrase += " ";
            }
            phrase += tableau[i];
        }

        return phrase;
    }

    console.log(reconstituerPhraseALenvers(mots));
}

//EXERCICE 8
//Convertir un tableau de températures de Fahrenheit à Celsius
//renvoyer un tableau de températures 
// ( °F - 32) x 5/9 = °C
//[8,47,35,29,10,21,40,35,8,56]
function exercice8() {
    let temps = [8, 47, 35, 29, 10, 21, 40, 35, 8, 56];

    function convertirFaC(temperatures) {
        let resultats = [];
        for (let i = 0; i < temperatures.length; i++) {
            resultats.push((temperatures[i] - 32) * 5 / 9);
        }
        return resultats;
    }
    console.log(convertirFaC(temps));
}


//EXERCICE 9 
//Compter le nombre de pairs dans un tableau
//ainsi que le nombre d'impairs 
//ex de tableau [1, 4, 8, 19, 5, 20, 3, 9, 0, -1, -6, 30, 11, 50, 4, 9]
// Renvoyer un tableau de deux valeurs, la première étant le nombre de pairs
//et la deuxième le nombre d'impairs
function exercice9() {
    let valeurs = [1, 4, 8, 19, 5, 20, 3, 9, 0, -1, -6, 30, 11, 50, 4, 9];

    function compterPairsImpairs(tableau) {
        let pairs = 0;
        let impairs = 0;
        for (let i = 0; i < tableau.length; i++) {
            if (tableau[i] % 2 === 0) {
                pairs++;
            } else {
                impairs++;
            }
        }
        return [pairs, impairs];
    }

    console.log(compterPairsImpairs(valeurs));
}

//EXERCICE 10 
//Implementer un tri sur un tableau 
//pour mettre des valeurs numériques dans l'ordre



//EXERCICE 11
//Récupérer les valeurs d'un tableau 
//dans un intervalle défini par les bornes a et b
function exercice11() {


    function recupIntervalle(tableau, a, b) {
        let resultat = [];
        if ( a >= b ){
            return "a doit être inférieur à b"
        }
        for(let i = 0; i < tableau.length; i++){
            if( tableau[i] >= a && tableau[i] <= b){
                resultat.push(tableau[i]);
            }
        }
        return resultat;
    }

    let prix = [468,447,316,85,260,366,0,75,202,248,451,353,384,88,29,441,444,217,442,105,290,112,300,442,345,78,321,55,339,365]

    console.log(recupIntervalle(prix, 50, 150));
}

//EXERCICE 12
//Vérifier qu'une valeur n existe dans un tableau de valeurs
//Renvoyer true ou false
function exercice12(){
    function valeurIncluse(tableau, n){
        for (let i = 0; i < tableau.length; i++){
            if ( tableau[i] === n ){
                return true;
            }
        }
        return false;
    }
    let valeurs = [100,240,22,454,52,230,455,357,414,223,24,207,70,233,131,342,331,2,396,250];
    console.log(valeurIncluse(valeurs, 22)); //renvoie true
    console.log(valeurIncluse(valeurs, -6)); //renvoie false
}

//EXERCICE 13
//Fizz Buzz
//Ecrire une fonction qui affiche les nombres de 1 à 100
//et affiche fizz à la place du nombre s'il est divisible par 3
//buzz à la place du nombre s'il est divisible par 5
//fizzbuzz a la place du nombre s'il est divisible par 3 et 5
function exercice13(){
    for (let i = 1; i <= 100; i++){
        if (i%3 === 0 && i%5 === 0){
            console.log("FizzBuzz");
        } else if (i % 3 === 0){
            console.log("Fizz");
        } else if (i%5 === 0){
            console.log("Buzz");    
        } else {
            console.log(i);
        }
    }
}

//EXERCICE 14
//Ecrire une fonction qui multiplie les valeurs d'un tableau une à une
//ex : [x,y,z] x [a, b, c] renvoie [a*x, b*y, c*z]
//si les deux tableaux ne sont pas de la même taille, renvoyer une erreur
function exercice14(){
    
    function multiplierTableaux(tab1, tab2){
        if (tab1.length !== tab2.length){
            return "erreur: longueur des tableaux inégales"
        }

        let resultat = [];
        for (let i = 0; i < tab1.length; i++){
            resultat.push(tab1[i] * tab2[i]);
        }
        return resultat;
    }
    console.log(multiplierTableaux([0, 1, 4, 5], [3, 5, 9, 12]));
}

//EXERCICE15
//Récuperer tous les nombres premiers contenus dans un tableau de valeur
//et les renvoyer dans un tableau
//un nombre premier est un nombre qui n'est divisible que par 1 et lui même
function exercice15(){

    function estPremier(n){
        for (let i = 2; i<n; i++){
            //si notre nombre a un autre diviseur que lui même
            if(n % i === 0 && i !== n){
                return false;
            }
        }
        //on se débarrasse des cas particuliers de 1 et 0 
        if (n !== 1 && n !== 0){
            return true;
        } else {
            return false;
        }
    }

    function rangerPremiers(tableau){
        let premiers = [];
        for (let i=0; i<tableau.length; i++){
            if( estPremier(tableau[i]) ){
                premiers.push(tableau[i]);
            }    
        }
        return premiers;
    }

    let nombres = [24,11,7, 1,34,21,13,27,34,42,26,30,34,48,42,22,28,1,12,40,22,5,30,31,29,11];
    console.log(rangerPremiers(nombres));
}