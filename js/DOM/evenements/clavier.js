//on attends le chargement du DOM
document.addEventListener('DOMContentLoaded', () => {
    const usernameInput  = document.getElementById('usernameInput');
    const passwordInput  = document.getElementById('passwordInput');
    const submitButton  = document.getElementById('submit');
    const textToModify = document.getElementById('textToModify');
    
    submitButton.addEventListener("click", (event) => {
        //pour notre champ input, la value est la propriété qui contient le texte inscrit dans le champ
        console.log(usernameInput.value, passwordInput.value);
    })

    //les évènements keydown et keyup permettent de notifier de l'appui sur une touche par l'utilisateur, et donc de réagir à cet appui
    //keydown est lancé avant que la touche sois prise en compte, keyup après que la touche ait été prise en compte
    usernameInput.addEventListener("keyup", (event) => {
        //ici pour pouvoir afficher la value de notre usernameInput en temps réel, on doit utiliser keyup
        textToModify.textContent = event.target.value.toUpperCase();
    })

    //changement de la couleur de la bordure en fonction de la longueur du mot de passe
    passwordInput.addEventListener("keyup", (event) => {
        const value = event.target.value;
        if (value.length < 8){
            event.target.style.borderColor = "red";
        }
        if (value.length >= 8 && value.length < 12){
            event.target.style.borderColor = "orange";
        } 
        if (value.length >= 12){
            event.target.style.borderColor = "green";
        }
    })

    const eyeSvg = document.getElementById("eye");
    eyeSvg.addEventListener('mousedown', () => {
        passwordInput.type = "text";
        eyeSvg.src = 'eye-solid.svg';
    })
    eyeSvg.addEventListener('mouseup', () => {
        passwordInput.type = "password";
        eyeSvg.src = 'eye-slash-solid.svg';
    })
})