document.addEventListener("DOMContentLoaded", function() {
  //gestionnaire d'évènement pour toute la page
  document.addEventListener("keypress", function(event) {
    //récupération de la touche pressée
    //conversion du code de caractère en une chaine
    let touche = String.fromCharCode(event.which);
    touche = touche.toUpperCase();

    let couleur = "";
    switch (touche) {
      case "V":
        //changer la couleur en vert
        couleur = "green";
        break;
      case "J":
        //changer la couleur en jaune
        couleur = "yellow";
        break;
      case "R":
        //changer la couleur en rouge
        couleur = "red";
        break;
      case "B":
        //changer la couleur en bleu
        couleur = "blue";
        break;
      case "N":
        //changer la couleur en noir
        couleur = "black";
        break;
      default:
        console.error(`La touche ${touche} n'est pas prise en compte.`);
    }
    //applique le changement de couleur de texte sur chaque div
    let divs = document.getElementsByTagName("div");
    for (let i = 0; i < divs.length; i++) {
      divs[i].style.color = couleur;
    }
  });
});
