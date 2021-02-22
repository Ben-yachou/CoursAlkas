//DOM = Document Object Model
//un ensemble de données représentant la page et ses éléments 
//Le document définit l'entiereté de la page 
//l'objet document est l'objet qui représente la balise <html> dans le DOM
let page = document;

//comme document est un object, on peut accéder a ses propriétés pour récupérer des données
let head = document.head;
let body = document.body;

//chaque noeud de notre document est un objet
//ces objets contiennent des propriétés ainsi que des méthodes
//la propriété childNodes d'un noeud contient par exemple un tableau d'objet
//ces objets sont les noeuds enfants de l'objet qui appelle childNodes
console.log(document.body.childNodes);

//les noeuds enfants peuvent avoir deux types, soit noeud textuel soit noeud element
//les noeuds textuels sont juste du texte et les noeuds element sont des objets
//on peut les différencier à l'aide de la propriété nodeType
for (let i = 0; i < body.childNodes.length; i++){
    if (body.childNodes[i].nodeType == document.ELEMENT_NODE){
        console.log(`enfant ${i} de body est un element`);
    } else {
        console.log(`enfant ${i} de body est textuel`);    
    }
}

//il est possible de cibler et récupérer directement des éléments dans
// le DOM à l'aide de méthodes propres au document
//pour récupérer les div d'un document on peut par exemple faire
let divs = document.getElementsByTagName("div");
console.log(divs); //affiche les différentes div trouvées
console.log(divs.length); //on peut recuperer le nombre de divs 
console.log(divs[0]); //ou même afficher la première div trouvée

//pour récuperer UN élement via son identifiant 
let maDiv2 = document.getElementById('div2');
console.log(maDiv2);

//pour récuperer tous les noeuds avec une même classe
let classBlue = document.getElementsByClassName('blue');
console.log(classBlue);

//pour récuperer tous les noeuds correspondants a un selecteur CSS
//permet de selectionner un element en javascript en utilisant 
//la même notation que pour selectionner un element en CSS
let maDiv2Bis = document.querySelector('#div2'); //selectionne l'element a l'id div2
let classBlueBis = document.querySelector('.blue') //selectionne les elements de class blue
//querySelector est très peu performant, donc l'utiliser le moins souvent possible
//et sur un nombre limité d'éléments 
//let experience = document.querySelector('.red > div::firstChild > div::nthChild(2) > li::nthChild(4)')
//querySelector permet d'utiliser des selecteurs css complexes 


//pour manipuler le contenu d'une balise on peut accéder aux propriétés de cette balise
//comme par exemple innerHTML et textContent
maDiv2.textContent = "Coucou"; //ici on remplace le contenu textuel de l'element maDiv2
//on peut également concaténer au lieu de remplacer
maDiv2.textContent += " les amis"; 

//innerHTML permet de modifier le code HTML directement contenu à l'intérieur de l'element
maDiv2.innerHTML = "<strong>Salut</strong>"; //ici on remplace le texte et le code html

//innerHTML et textContent diffèrent au moment de la lecture
//textContent ne renverra que le contenu purement textuel
//alors que innerHTML renverra également les balises HTML
console.log(maDiv2.innerHTML); //affichera <strong>Salut</strong>
console.log(maDiv2.textContent); //affichera Salut 

//une fois un élément récupérer on peut également lire et modifier ses attributs
let monLien1 = document.getElementById('lien1'); //on récupère notre element <a>
console.log(monLien1.getAttribute('href')); //affiche le contenu de href
console.log(monLien1.href); //idem
console.log(monLien1.getAttribute('id')); //récupère l'id 
console.log(monLien1.id); //idem

//pour modifier un attribut
monLien1.setAttribute('href', 'http://www.google.fr');
monLien1.textContent = "Google"; //change le texte du lien

//vérifier si un élément possède un attribut particulier
console.log(monLien1.hasAttribute('target')); //renvoie false

//Changer le style d'un élément 
//on peut manipuler directement les propriétés CSS d'un élément
//ou on peut manipuler les classes d'un élément pour appliquer du CSS 

//pour manipuler directement le style d'un element on utilise
//la propriété style
//style est un objet contenant d'autres propriétés représentant les propriétés css
monLien1.style.color = 'red';
monLien1.style.backgroundColor = 'yellow';
monLien1.style.padding = '15px';

//pour manipuler les classes d'un élément on utilise classList
maDiv2.classList.add('omar'); //pour ajouter ue classe on utilise add
//maDiv2.classList.remove('omar'); pour retirer une classe on utilise remove

//pour vérifier si une classe est présente 
//on utilise contains
console.log(maDiv2.classList.contains('omar'));

//pour créer des éléments et les ajouter à notre document
//on peut utiliser des méthodes propres au document
//par exemple pour créer un élément a avec un href 
let nouveauLien = document.createElement('a'); //on crée un nouvel element de type ancre
//et on le stocke dans une variable
//pour modifier le texte a l'intérieur du lien on utilise textContent
nouveauLien.textContent = 'wikipedia';
//pour modifier un attribut
nouveauLien.setAttribute('href', 'https://fr.wikipedia.org/wiki');

//après avoir défini toutes les propriétés de notre élément
//il faut ajouter cet élément au document  
maDiv2.appendChild(nouveauLien); //appendChild rajoute un élément a la suite
//ici on l'ajoute dans maDiv2

//pour retirer un element du document on utilise remove()
monLien1.remove(); //ici je supprime l'element contenu dans monLien1