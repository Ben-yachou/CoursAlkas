let langages = [
    {
        nom: "Python",
        paradigmes: "Orienté objet, impératif et interprété"
    },
    {
        nom: "C",
        paradigmes: "Impératif, procédural, structuré"
    },
    {
        nom: "C++",
        paradigmes: "Générique, orienté objet, procédural"
    },
    {
        nom: "C#",
        paradigmes: "Structuré, impératif, orienté objet"
    },
    {
        nom: "Java",
        paradigmes: "Orienté objet, structuré, impératif, fonctionnel"
    },
    {
        nom: "Javascript",
        paradigmes: "Script, orienté prototype, impératif, fonctionnel"
    },
    {
        nom: "GianniScript",
        paradigmes: "Rital, Orienté Fifa"
    }
]

//pour chaque objet du tableau
//afficher le nom dans un titre (h1, h2 ou h3 etc)
//et afficher les paradigmes dans un paragraphe (p)
//ajouter les deux elements (h et p) dans une div
//ajouter la div au body
//donc pour chaque langage dans le tableau, 
//une div contenant un titre et un paragraphe  

for (let i = 0; i < langages.length ; i++){
    //on crée une div vouée à contenir nos informations
    let conteneur = document.createElement('div');
    //on ajoute la div a notre body
    document.body.appendChild(conteneur);

    //on crée un paragraphe qui contiendra les paradigmes
    let paragraphe = document.createElement('p');
    //on inscrit l'information contenue dans le tableau dans la balise
    paragraphe.textContent = langages[i].paradigmes;
    
    //on crée notre balise titre
    let titre = document.createElement('h1');
    //on inscrit le nom du langage dans notre balise
    titre.textContent = langages[i].nom;
    
    //on ajoute notre balise titre au conteneur, notre div
    conteneur.appendChild(titre);
    //on ajoute également notre paragraphe a la suite
    conteneur.appendChild(paragraphe);

    conteneur.style.display = "flex";
    conteneur.style.justifyContent = "center";
}