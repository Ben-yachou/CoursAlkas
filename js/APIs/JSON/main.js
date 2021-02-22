//Javascript Object Notation (JSON) est un format standard utilisé pour représenter des données structurées de façon semblable aux objets Javacript
//Il est souvent utilisé pour structurer et transmettre des données dans le cadre d'applications Web
//Il est ainsi possible de transférer facilement des données entre applications utilisant des technologies différentes, en passant par HTTP et en envoyant du JSON (qui est du texte)

//Le JSON ressemblant à un object javascript, on va en générer à partir d'un objet
let user = {
    name: "Jack",
    dob: "1965-06-25",
    address: {
        city: "Montpellier",
        street: "Rue de je m'en fous",
        country: "FR",
    },
    books: [
        {
            title: "Les androïdes rêvent ils de moutons électriques ?",
            author: "Philip K Dick",
        },
        {
            title: "Ubik",
            author: "Philip K Dick",
        },
    ],
};

//l'interprétation de cet objet en texte formaté en JSON peut s'appeller sérialisation
//pour sérialiser un objet en JSON on peut utiliser JSON.stringify en javascript
let userJson = JSON.stringify(user); //renvoie une chaine de caractère représentant mon objet

//pour deserialiser (texte vers objet) un texte formaté en JSON, on peut utiliser JSON.parse
let newUser = JSON.parse(userJson); //renvoie l'objet représenté par ma chaine de caractères
