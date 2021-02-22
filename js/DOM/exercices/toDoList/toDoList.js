document.addEventListener("DOMContentLoaded", () => {
    //on récupère nos différents éléments nécessaires à l'exécution de notre script
    const taskInput = document.getElementById("taskInput");
    const addTask = document.getElementById("addTask");
    const taskList = document.getElementById("tasks");

    //on prépare un gestionaire d'évènement pour écouter les clicks arrivant sur notre bouton add
    addTask.addEventListener("click", () => {
        //si le champ input contient quelque chose
        if (taskInput.value) {
            //on récupère ce qu'il contient
            const taskName = taskInput.value;

            //on crée un nouvel élément li pour insertion
            const newTask = document.createElement("li");
            //on lui donne comme contenu textuel le contenu de notre champ input
            newTask.textContent = taskName;

            //on crée un bouton de suppression
            const deleteBtn = document.createElement("button");
            deleteBtn.textContent = "X"; //on lui donne un contenu
            newTask.appendChild(deleteBtn); //on l'ajoute à notre <li>

            //pour réagir au clic sur le bouton de suppression lui même, on lui ajoute un eventListener
            deleteBtn.addEventListener("click", () => {
                //on cible ensuite le li qu'on a créé pour utiliser remove() dans le cas ou le bouton supprimer aurait été appuyé
                newTask.remove(); //ici, newTask cible le li qui contient le bouton, ce qui a pour résultat de toujours supprimer le bon li automatiquement
                //on aurait pu également utiliser event.target.parentNode.remove() pour obtenir le même résultat
            });

            //on l'ajoute ensuite à notre <ul> taskList
            taskList.appendChild(newTask);

            //enfin, on vide le champ input pour une remise à zéro
            taskInput.value = "";
        }
    });
});
