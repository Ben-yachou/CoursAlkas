# Résumé de l'après-midi du 20 octobre 2020

## 1 - Différentes questions sur la To Do List

#### Début - 10m00

Différentes questions ont été posées par rapport aux exercices.

## 2 - Appréhender la suppression d'une tâche sur la To Do List

#### 12m12

Pour supprimer un élément dans notre To Do List, il faut pouvoir créer un bouton de suppression.
Pour cela, il faut utiliser `document.createElement('button')`.
On doit le faire en même temps que la création de notre `<li>` pour pouvoir insérer notre `<button>` dans notre élément de liste.

```js
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

            //on l'ajoute ensuite à notre <ul> taskList
            taskList.appendChild(newTask);
        }
    });
});
```

Une fois notre bouton ajouté, il faut pouvoir réagir à un clic sur ce bouton supprimer.
L'action à effectuer sera de supprimer notre élément `newTask` à l'aide de `newTask.remove()`.

```js
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
        }
    });
});
```

### Comment se fait-il qu'on puisse utiliser `newTask` pour référencer notre élément ?

#### 17m30 - 30m00, dessin débile à la souris à 19m30

Lorsqu'on a créé nos éléments, l'exécution du code se fait toujours relative à un contexte.

Le contexte dans lequel on a créé le bouton est celui d'un nouvel élément `newTask`, qui est unique.

L'élément `deleteBtn` est attaché à _son propre_ `newTask`.
Lorsque le code est exécuté, il l'est dans un contexte particulier, celui du bouton sur lequel on a cliqué. Le `newTask` associé est donc forcément celui associé au bouton cliqué.
