//DOM = Document Object Model
//le DOM est un ensemble de données représentant la page web et ses éléments
//Il est assemblé par le navigateur au moment de l'interprétation du HTML
//Un objet javascript est donc utilisé pour représenter chaque élément de notre page 
//Un objet HTMLDocument définit l'entiereté de la page
//Il contient la représentation en javascript de chacune des balises textuelles 

//dans la variable document se trouve le DOM 
//document est initialisée lors de la création de la page et contient toutes les informations sur la page elle même
console.log(document); 

//avec ce document de type HTMLDocument on peut effectuer certaines manipulation sur le document lui même ou même ses enfants 
//On peut effectuer ces manipulations au travers des nombreuses propriétés et méthodes de l'objet document
console.log(document.body); //document.body contiendra null si body n'a pas été interprété par le navigateur au moment de l'exécution de notre script 
//on peut par exemple, pour gérer ce problème, déplacer le script en bas de notre body pour s'assurer qu'il soit bien lu après l'interprétation de toute notre page
//plus tard, on utilisera des méthodes plus "sophistiquées" comme les évènements 

//chaque élément du DOM étant représenté plus ou moins de la même façon sous la forme d'un HTMLElement, ils possèdent donc tous des propriétés en cmomun, parmi celles ci se trouve les propriétés children et childNodes
//dans children se trouvent tous les HTMLElement contenus dans l'élément ciblé 
console.log(document.body.children);
//dans childNodes se trouvent tous les noeuds (Elements + Texte) contenus dans l'élément ciblé 
console.log(document.body.childNodes);

//il est possible de cibler plus précisement certains éléments du DOM et ainsi intéragir avec 
//pour récupérer tous les éléments d'un même nom de balise, on peut utiliser getElementsByTagName
const liElements = document.getElementsByTagName('li');
//getElementsByTagName('element') renvoie donc une HTMLCollection contenant tous les éléments <element> de notre document 
console.log(liElements); //liElements.length pourrait donc nous renvoyer le nombre de <li> présents dans notre page

//dans la même veine que getElementsByTagName se trouve getElementsByClassName qui effectue le même comportement mais avec un nom de classe et pas de balise 
const elementElements = document.getElementsByClassName('element');
console.log(elementElements); //tous les éléments possédant la classe 'element' seront renvoyés dans une HTMLCollection

//il existe une autre méthode permettant de récupérer un ou plusieurs élément via un selecteur css, avec querySelector et querySelectorAll
const liElement = document.querySelectorAll("ul>li");
console.log(liElement);
const li2 = document.querySelector("#li2");
console.log(li2);
//querySelectorAll renvoie tous les candidats selectionnés par le selecteur css
//querySelector renvoie uniquement le premier trouvé correspondant au selecteur css
//querySelector et querySelectorAll sont très peur performants et doivent donc être utilisés le moins possible 
//s'ils doivent absolument être utilisé,ce devra t être de façon sporadique, jamais dans une boucle, pour éviter des problèmes de performances 

//comment selectionner un élément en particulier du coup si queryselector on y pas le droit parceque l'archidiocèse a dit non ?

//il existe getElementById qui renvoie un element affublé d'un certain id
//ou alors on peut utiliser getElementsByClassName et récupérer le premier de la collection pour répéter bien souvent le comportement de querySelector 

//ici on récupère l'element d'id image1
const image1 = document.getElementById("image1");
//pour lire un attribut d'un élément on peut utiliser getAttribute
console.log(image1.getAttribute("src")); //renvoie la src de l'image
//ou, si cet attribut est natif à l'élément, on peut faire 
console.log(image1.src); //renvoie également la src de l'image

//pour modifier un attribut ou définir un nouvel attribut on peut utiliser setAttribute 
image1.setAttribute('src', 'https://via.placeholder.com/150/FF0000');
//ici, on a modifié l'attribut src de notre image, changeant ainsi l'image affichée 

//pour changer le style d'un élément, on peut utiliser sa propriété style
li2.style.color = "red"; //change la couleur du texte
li2.style.backgroundColor = "blue"; //change la couleur de fond

//on peut également manipuler les classes d'un élément 
li2.classList.add('big'); //ajoute la class big a l'élément
//pour retirer une classe on utilise classList.remove(nomDeLaClasse)
//pour vérifier qu'une classe existe on peut utiliser classList.contains(nomDeLaCLasse) qui renverra true si l'element possède bien la classe demandée

//Créer des éléments du DOM 
//pour pouvoir créer dynamiquement des éléments et les insérer dans notre DOM, on peut utiliser document.createElement('nomDeLElement)
const nouveauLien = document.createElement('a');
nouveauLien.setAttribute('href', 'https://www.google.fr');
nouveauLien.textContent = 'Google'; //change le contenu textuel de la balise

//appendChild permet de prodiguer un nouvel Element enfant a n'importe quel element du DOM capable d'en recueillir un
li2.appendChild(nouveauLien); //ici on insère notre lien dans notre element <li> 

//pour retirer un element on peut utiliser element.remove() 
//pour retirer nouveauLien il faudrait faire nouveauLien.remove()