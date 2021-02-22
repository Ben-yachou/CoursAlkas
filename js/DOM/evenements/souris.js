//Les évènements du DOM sont des notifications du navigateur lorsque quelque chose d'utile intervient lors de la navigation
//Chaque évènement est représenté par un objet de type Event contenant des propriétés permettant d'obtenir des informations sur l'évènement lui même (origine, propriétés, etc...)
//Un évènement peut être un clic, un scroll, un chargement de contenu particulier, etc... et permet ainsi de gérer l'interaction entre l'utilisateur et le contenu, et vice versa 

//Par exemple, pour détecter le chargement complet du DOM, on peut utiliser un évènement DOMContentLoaded qui notifie lorsque le navigateur a terminé de construire le DOM 
//Cet évènement sera indiqué à ce qu'on appelle un Gestionnaire d'Évènements 
//Ce gestionnaire d'évènements aura pour rôle d'écouteur l'arrivée d'un évènement précis et d'exécuter un code lors de ladite arrivée 

//le gestionnaire suivant executera notre code lorsque le DOM sera chargé, nous permettant ainsi de ne pas avoir à placer notre script a la fin de body
//document est l'élément que le gestionnaire d'évènement va considérer comme son contexte (sa cible)
//ici, en plaçant un eventListener sur document, on surveille toute la page pour guetter l'arrivée d'un évènement
//DOMContentLoaded est le type d'évènement sur lequel notre gestionnaire va réagir (ici le chargement du DOM)
//le second paramètre de addEventListener est une fonction qui s'exécutera lors de la réalisation de l'évènement guetté 
//cette fonction pouvant être anonyme est appelée "callback"
document.addEventListener('DOMContentLoaded', () => {
    //ici on définit le code à exécuter lorsque l'évènement DOMContentLoaded sera lancé 
    console.log("Après DOMContentLoaded", document.body);//body sera initialisé 

    //pour pouvoir cibler un élément particulier et lui ajouter un gestionnaire d'évènements (eventListener), on doit déjà le récupérer dans le DOM
    const boutonACliquer = document.getElementById('aCliquer');
    let compteur = 0; //pour compter le nombre de clics on peut initialiser un compteur avant l'évènement
    //si dans le callback de notre eventListener on passe un paramètre 
    //celui-ci contiendra l'objet Event qui renseigne les propriétés de l'évènement survenu
    boutonACliquer.addEventListener('click', (event) => {
        console.log(event);
        compteur++; //en réagissant à l'évènement on incrémente le compteur
        //event.target contient la cible du clic, qui est dans ce cas là toujours notre boutonACliquer
        event.target.textContent = "Cliquez moi ! " + compteur;
        //ici on change le label de notre bouton pour y ajouter le nb de clics
    });

    //gestionnaire d'évènement ciblant les mouvements de souris dans le document
    document.addEventListener('mousemove', (event) => {
        //event contenant des informations sur l'evenement, on peut récupérer la position de la souris lorsque l'évènement se produit
        //ici, c'est à chaque mouvement de souris qu'ona ffichera sa position en x et en y 
        console.log(event.x, event.y); 
    })
});

console.log("Avant DOMContentLoaded", document.body); //body sera null