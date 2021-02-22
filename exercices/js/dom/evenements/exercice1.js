//DOMContentLoaded apparait lorsque la page est entièrement chargée
//éléments du DOM compris 
document.addEventListener('DOMContentLoaded', function(){
    let numCompteur = 0;

    let spanCompteur = document.getElementById('compteur');
    let buttonClic = document.getElementById('clic');
    let buttonReset = document.getElementById('reset');

    buttonClic.addEventListener('click', function(){
        numCompteur++;
        spanCompteur.textContent = numCompteur;
    });

    buttonReset.addEventListener('click', function(){
        numCompteur = 0;
        spanCompteur.textContent = numCompteur;
    });
});