//AJAX (Asynchronous Javascript and XML)
//C'est un principe de programmation qui préconise l'utilisation de requête asynchrones de façon à pouvoir faire transiter et manipuler des données dans une application; sans paralyser le fil d'exécution ou obliger un rafraichissement de la page à chaque nouvelle action ou donnée.

//il existe de nombreuses technologies permettant d'appliquer ce genre de principes
//l'une d'entre elle est la suivante :
//pour envoyer une requête HTTP Asynchrone on peut utiliser XMLHttpRequest (XHR)
//pour créer une XHR on peut :
const request = new XMLHttpRequest();
//pour définir la méthode et l'adresse de destination, on ouvre la requête en utilisant open
request.open("GET", "https://randomuser.me/api");
//pour envoyer la requête on utilise ensuite send
request.send();
//étant donné que la requête est envoyée sur le réseau, il est impossible de récupérer les informations de façon instantanée
//si on tente de recupérer la réponse directement, elle sera vide, car pas encore arrivée au moment de l'exécution de notre code
console.log("récupération synchrone", request.response); // !! ne fonctionne pas !!

//pour réagir à la réponse de façon asynchrone on peut donc utiliser un eventListener avec un callbak
//en écoutant l'event load on indique vouloir exécuter un callback lorsque la réponse est arrivée
//on peut également écouter l'event error pour réagir à une erreur, progress pour écouter le chargement d'une requête, abort pour réagir à une annulation
// https://developer.mozilla.org/fr/docs/Web/API/XMLHttpRequest/Utiliser_XMLHttpRequest pour plus d'informations
request.addEventListener("load", () => {
    //on peut ensuite acéder a la réponse de cette façon par exemple
    console.log("récupération asynchrone", JSON.parse(request.response));
    //une fois le json parsé ici on peut commencer à manipuler nos objets
});

//une façon plus moderne d'envoyer des requêtes HTTP existent via l'api Fetch https://developer.mozilla.org/fr/docs/Web/API/Fetch_API/Using_Fetch
//une requête fetch basique peut s'initier de la façon suivante :
fetch("https://randomuser.me/api")
    .then((response) => {
        return response.json();
    })
    .then((data) => {
        console.log(data);
    });
