//EXERCICE CHAINES 1
//ecrire une fonction comptant
//le nombre de voyelles dans une chaine de caractères
function exercice1() {
    let phrase = "COmbIen de voyelles ?";

    function compteVoyelles(phrase) {
        let nbVoyelles = 0;
        phrase = phrase.toLowerCase(); //On remplace la phrase par la phrase en minuscule
        for (let i = 0; i < phrase.length; i++) {
            if (phrase[i] === "a" ||
                phrase[i] === "e" ||
                phrase[i] === "i" ||
                phrase[i] === "o" ||
                phrase[i] === "u" ||
                phrase[i] === "y") {
                nbVoyelles++;
            }
        }
        return nbVoyelles;
    }
    console.log(compteVoyelles(phrase));
}

//EXERCICE CHAINES 2
//ecrire une fonction inversant une chaine
//donc renvoie une chaine ecrite à l'envers
function exercice2() {
    function inverserChaine(chaine) {
        let resultat = "";
        for (let i = chaine.length - 1; i >= 0; i--) {
            resultat += chaine[i];
        }
        return resultat;
    }

    console.log(inverserChaine("salut les amis comment ça va"));
}


//EXERCICE CHAINES 3
//ecrire une fonction qui teste si une chaine est un palindrome
//un palindrome est une phrase qui se lit de la meme façon dans les deux sens
//ex : la mariee ira mal
function exercice3() {
    function inverserChaine(chaine) {
        let resultat = "";
        for (let i = chaine.length - 1; i >= 0; i--) {
            resultat += chaine[i];
        }
        return resultat;
    }

    function estPalindromeMot(mot) {
        mot = mot.toLowerCase();
        return mot === inverserChaine(mot);
    }
    //comme la fonction estPalindromeMot ne gère pas les phrases avec espace
    //nous sommes obligés de faire une autre fonction qui retirera
    //les espaces pour n'avoir à gérer qu'un long mot 

    function estPalindrome(phrase) {
        let mot = "";
        for (let i = 0; i < phrase.length; i++) {
            //si notre caractère n'est pas un espace
            if (phrase[i] !== " ") {
                //on rajoute le caractère a la suite du mot
                mot += phrase[i];
            }
        }
        //une fois notre phrase sans espace, on peut appeler
        //estPalindromeMot qui va tester pour nous si c'est un palindrome
        return estPalindromeMot(mot);
    }

    console.log(estPalindrome("Kaijoadyak"));
    console.log(estPalindrome("la mariee ira mal"));
}

//EXERCICE CHAINES 4
//ecrire une fonction qui retire les accents d'une phrase
//donc remplace les accents par la lettre non accentuée

function exercice4() {

    function retirerAccents(chaine) {
        chaine = chaine.toLowerCase();
        let resultat = "";
        for (let i = 0; i < chaine.length; i++) {
            if (chaine[i] === "é" || chaine[i] === "è" || chaine[i] === "ë" || chaine[i] === "ê") {
                resultat += "e";
            } else if (chaine[i] === "à" || chaine[i] === "â" || chaine[i] === "ä") {
                resultat += "a"
            } else if (chaine[i] === "ï" || chaine[i] === "î") {
                resultat += "i"
            } else if (chaine[i] === "ç") {
                resultat += "c"
            } else {
                resultat += chaine[i];
            }
        }

        return resultat;
    }
    //incomplète, manque des caractères, le principe est le même pour tous les caractères accentués
}