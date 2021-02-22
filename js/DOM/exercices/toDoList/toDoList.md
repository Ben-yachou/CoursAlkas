# Exercice ToDoList 
## Énoncé : 
Implémenter une simple *Liste de Tâches* (To Do List) en javascript et HTML/CSS. 

Une To Do List se compose d'un champ d'input pour indiquer l'intitulé de la tâche à effectuer, et une liste (ordonnée ou non) auxquelles se rajoute la tâche indiquée dans le champ input au moment d'un appui sur un bouton. 

Suite de l'éxercice : 

On pourra également supprimer une tâche avec un bouton "supprimer" devant chaque tâche, et un bouton "valider" pour afficher la tâche comme "faite", au lieu de "à faire".


## Informations : 

### Récupérer un élément : 
Pour récupérer un élément particulier dans une page à l'aide du javascript on peut utiliser : 

```js
document.getElementById('idDeLelement');
```
### Les gestionnaires d'évènements : 

Pour ajouter un gestionnaire d'évènemement on peut utiliser `addEventListener` : 
```js
element.addEventListener('nomEvenement', () => {
    //traitement à effectuer
})
```

Dans un `eventListener` pour pouvoir récupérer la cible de l'évènement géré, on peut utiliser un paramètre `event` dans la fonction de callback : 

```js
element.addEventListener('nomEvenement', (event) => {
    const cible = event.target; //la cible de l'évenement est stockée dans event.target
})
```

### Création d'un élément : 

Pour créer un élément on utilise : 
```js
const element = document.createElement('nombalise');
```

Pour insérer cet élément dans un autre, on utilise `appendChild` : 

```js
elementParent.appendChild(elementEnfant);
```

Donc, si on voulait créer une nouvelle div, lui donner un id, et la ranger dans body on pourrait faire : 

```js
const monElement = document.createElement('div');
monElement.id = "nouvelElement"; //on donne l'id "nouvelElement" à notre div
document.body.appendChild(monElement); //ajoutera notre div à la fin de body 
```