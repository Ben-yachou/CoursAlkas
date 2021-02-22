//une chaine de caractères est similaire à un tableau de caractères
//on définit généralement une chaine comme du texte contenu entre guillemets ou apostrophes 
let exemple = "aujourd'hui" 
let exemple2 = 'aujourd\'hui' //si on utilise des ' pour délimiter notre string, on doit échapper les caractères ' dans notre string pour ne pas la fermer par inadvertance 

//pour concaténer des chaines ensemble on utilise +
//on peut également concaténer des nombres avec des chaînes  
let concatenation = "ceci est " + 1 + " chaîne" 
// équivaut à "ceci est 1 chaîne"

//on peut également concaténer des variables contenant des chaines ou autres
let politesse = "Comment ça va " + exemple + " ?"
// équivaut à Comment ça va aujourd'hui ? 

//à la place d'une concaténation on peut également utiliser les `` pour insérer des variables dans une chaîne 
//${variable} dans une chaîne définie avec des back quotes permet d'insérer ladite variable 
//${} permet également d'éxécuter du code, des conditions ou des fonctions
let politesse2 = `Comment ça va ${exemple} ?`

//fonctions liées aux string : 
//manipuler la casse (minuscule/majuscule)
//toUpperCase() permet de passer une chaîne en majuscule
//toLowerCase() permet de passer une chaîne en minuscule 
let petitbonjour = "bonjour"
petitbonjour.toUpperCase() //renvoie "BONJOUR"

let groscoucou = "COUCOu"
groscoucou.toLowerCase() //renvoie "coucou"

//la comparaison de chaines prend en compte la casse 
"toto" === "Toto" //false 
"toto" === "Toto".toLowerCase() //true


//Etant donné que les chaînes de caractères sont représentées comme des tableaux de caractères, on peut accéder à un caractère en particulier à l'aide d'un indice numérique

let phrase = "Balkany est en liberté"
phrase[0] // renvoie "B"
phrase[6] // renvoie "y"
phrase[11] // renvoie " "
phrase[phrase.length - 1] //renvoie le dernier caractère "é"

//on peut également parcourir une chaîne à l'aide d'un for
for (let i = 0; i < phrase.length; i++){
    console.log(phrase[i]) //affiche chaque caractère 
}

//on peut séparer une chaine en sous parties à l'aide de split()
//split permet de séparer une chaine en sous parties délimitées par un caractère précis
//par exemple, pour récupérer tous les mots de notre phrase, on split la chaine au niveau des espaces
let mots = phrase.split(" "); 
// mots contient ["Balkany", "est", "en", "liberté"]
let numero = "06.28.45.19.44"
numero.split(".") // renvoie ["06", "28", "45", "19", "44"]