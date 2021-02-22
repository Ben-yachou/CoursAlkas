let urls = [
    "https://www.google.fr",
    "https://developer.mozilla.org/fr",
    "https://fr.wikipedia.org/wiki",
    "https://www.amazon.fr"
]

//Ajouter au body des liens dont l'attribut href 
//est pour chacun une url contenue dans le tableau
//donc une balise <a> pour chaque lien contenu dans le tableau

for (let i = 0; i < urls.length ; i++){
    //créer un élément a
    let lien = document.createElement('a');
    //on définit href
    lien.href = urls[i]; 
    //on peut aussi faire lien.setAttribute('href', urls[i]);
    //on définit le texte de notre lien 
    lien.textContent = urls[i];
    //on ajoute notre lien au body
    document.body.appendChild(lien);
    //on crée un élément saut de ligne
    let br = document.createElement('br');
    //et on l'ajoute également à la suite
    document.body.appendChild(br);
}