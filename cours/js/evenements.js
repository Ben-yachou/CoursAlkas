let bouton1 = document.getElementById('bouton1');

//ajout d'un gestionnaire d'évènements sur le click
let compteur = 0;
bouton1.addEventListener('click', function () {
    compteur++;
    bouton1.textContent = compteur;
});

//ajout d'un gestionnaire d'evenement qui identifie quel element est concerné
//pour ce faire on fait passer en paramètre l'event sous la forme d'une variable
//event est un objet contenant des informations concernant l'evenement 
document.addEventListener('click', function(event){
    console.log(event);
    console.log(event.target); //renvoie la cible de l'evenement
    console.log(event.clientX, event.clientY); //renvoie la position et x et y de la souris
});


//ajout d'un gestionnaire d'evenement permettant de gérer l'appui sur touches
document.addEventListener('keypress', function(event){
    console.log(event.which, String.fromCharCode(event.which)); 
    //which renvoie le code de la touche
    //sur laquelle on a appuyé pour déclencher l'evenement
    //String.fromCharCode(event.which) permet de convertir ce code en une lettre

    //pour animer un element on peu tutiliser la fonction animate
    if (event.which == 112 || event.which == 80){ //si la touche appuyée est p
        document.getElementById('animation').style.backgroundColor = "red";
        document.getElementById('animation').animate([
            {transform: 'translateX(0px)'},
            {transform: 'translateX(-300px)'}
        ], {
            duration: 1000,
            iterations: Infinity,
        });
    }

    //si on appuie sur a on change la couleur de la div
    if (event.which == 97){
        document.getElementById('animation').style.backgroundColor = "blue";
    }
});

