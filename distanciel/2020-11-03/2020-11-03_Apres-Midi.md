# # Résumé du 3 novembre 2020 après midi

## 1 - Correction Volume D'un Cone

### Rappel de l'énoncé

Produire un formulaire permettant de récupérer le rayon d'une base ainsi que la hauteur d'un cone afin d'en calculer le volume

Ajouter la possibilité d'arrondir la valeur ou pas à l'aide d'une checkbox

Le volume d'un cone se calcule avec la formule suivante :
`(pi x rayon² x hauteur)/3`
en PHP, pi se récupère à l'aide de la fonction `pi()`
une puissance se fait avec la fonction `pow()`
pour une puissance de 2, cela ferait `pow($rayon, 2)`

Un arrondi se fait à l'aide de la fonction `round()`.

### Correction

Le formulaire HTML fourni permettait de récolter les données en vue du traitement en PHP.

```html
<form method="POST" action="traitement.php">
    <label for="rayon">Rayon de la base</label>
    <input id="rayon" name="rayon" type="number" />

    <label for="hauteur">Hauteur du cone</label>
    <input id="hauteur" name="hauteur" type="number" />

    <label for="arrondi">Arrondir ?</label>
    <input id="arrondi" name="arrondi" type="checkbox" />

    <input type="submit" value="Calculer Volume" />
</form>
```

Chaque champ `<input>` possède un attribut `name` permettant d'identifier la valeur manipulée une fois en traitement.

L'`action` du formulaire est définie vers `traitement.php` il faut donc le créer et le coder :

```php
<?php
//calcul du volume du cone ici

//on peut commencer par inspecter notre variable $_POST
var_dump($_POST);
```

Notre variable tableau `$_POST` initialisée lors de l'envoi de notre formulaire contient les données remplies. Pour accéder à chacune des valeurs de champ `<input>` il suffit d'y accéder comme n'importe quel tableau :

```php
<?php
//nos valeurs se trouvent dans $_POST, on peut choisir de les stocker dans des variables plus lisibles
$rayon = $_POST['rayon'];
$hauteur = $_POST['hauteur'];
```

Pour effectuer notre calcul il suffit d'appliquer notre formule :

```php
<?php
$rayon = $_POST['rayon'];
$hauteur = $_POST['hauteur'];

//notre calcul est (pi * rayon² * hauteur) / 3
$resultat = (pi() * pow($rayon, 2) * $hauteur)/3;

//on peut afficher le résultat
echo $resultat;
```

### Gestion de l'arrondi

L'arrondi est une option qui est selectionnable dans notre formulaire.
Pour vérifier si une `checkbox` a bien été cochée il suffit de vérifier la présence de la clé correspondant à notre champ input dans le tableau `$_POST`.
Ainsi, un simple `if` avec l'utilisation de la fonction `isset()` suffit à valider l'utilisation d'une checkbox.

Pour arrondir une valeur numérique, on utilise en PHP la fonction `round()`.

```php
<?php
$rayon = $_POST['rayon'];
$hauteur = $_POST['hauteur'];

//notre calcul est (pi * rayon² * hauteur) / 3
$resultat = (pi() * pow($rayon, 2) * $hauteur)/3;

//Si la checkbox 'arrondi' a été cochée
if (isset($_POST['arrondi'])){
    echo round($resultat); //on renvoie le résultat arrondi
} else {
    //sinon on peut afficher le résultat
    echo $resultat;
}
```

## 2 - Correction Nombres Aléatoires

### Rappel de l'énoncé

A partir d'un formulaire demandant un nombre de valeurs à générer `n`, une borne minimum de nombre aléatoire ainsi qu'une borne maxmium, il faut générer les `n` nombres aléatoires contenus entre le minimum et le maximum.

Pour générer une valeur aléatoire en php on utilise la fonction `rand` :

```php
rand(1, 100); //renvoie une valeur entre 1 et 100
```

### Correction

Notre formulaire HTML contenait les champs `input` permettant de récupérer le nombre de valeurs à générer, ainsi qu'un intervalle min-max pour la génération de chaque nombre :

```html
<form action="traitement.php" method="post">
    <label for="nbValeurs">
        Nombre de valeurs a generer
        <input type="number" name="nbValeurs" id="nbValeurs" />
    </label>

    <label for="min">
        Valeur min
        <input type="number" name="min" id="min" />
    </label>
    <label for="max">
        Valeur max
        <input type="number" name="max" id="max" />
    </label>

    <input type="submit" value="Generer" />
</form>
```

Pour le traitement en php dans le fichier `traitement.php` on devait donc effectuer les actions nécessaires a la génération des valeurs :

```php
//vérification de l'intégrité du formulaire
if (isset($_POST['nbValeurs']) && isset($_POST['min']) && isset($_POST['max'])){
    //on récupère nos valeurs dans des variables
    $nbValeurs = $_POST['nbValeurs'];
    $min = $_POST['min'];
    $max = $_POST['max'];
} else {
    echo "erreur formulaire";
}
```

En utilisant `isset()` on peut vérifier que notre formulaire n'ait pas été modifié de façon malicieuse et qu'on ait bien reçu les informations nécessaires (même si elles peuvent toujours être fausses).

Le gros de la fonction est de générer une valeur aléatoire autant de fois que demandé.
Il faut donc utiliser une boucle pour pouvoir répéter un traitement.

```php
//après avoir récupéré nos valeurs...

//on répète autant de fois que nécessaire
for ($i = 1; $i <= $nbValeurs; $i++){
    //génération de notre nombre aléatoire
    $randomNum = rand($min, $max);

    echo $randomNum;
}
```

### Vérifications supplémentaires

Dans le cadre de notre correction on s'est également posé comme question : Comment vérifier l'intégrité de nos données ? (bon type, valeurs sensées...)

On a donc implémenté plusieurs tests pour vérifier que les valeurs récupérées soient bien des nombres (à l'aide de `is_numeric()`), que les champs aient bien été remplis (à l'aide de `empty()`)

### Gestion des adjectifs numéraux en français

J.F. a proposé lors de la correction d'utiliser sa gestion des abbreviations des adjectifs numéraux (er et ème) pour ajouter du dynamisme et du français à notre résultat :

```php
//affichage du nombre aléatoire avec gestion du français
if ($i == 1){
    echo "Voici le {$i}er nombre aléatoire  : {$randomNum}";
} else {
    echo "<br/> Voici le {$i}ème nombre aléatoire : {$randomNum}";
}
```

### Résultat final :

voir le fichier `traitement.php`.

## 3 - Principes à retenir :

### Récupération des données

La gestion de la récupération des données de formulaire se fait toujours à l'aide d'une variable initialisée par PHP. Ici c'est toujours `$_POST` vu que nous envoyons notre formulaire avec l'attribut `method="POST"`.

### Vérification des données

Les données de formulaires ne passent par aucune vérification stricte lorsqu'elle sont envoyées depuis le navigateur (ne **jamais** faire confiance aux données client).

Il faut donc entreprendre plusieurs tests, souvent rébarbatifs, pour s'assurer de l'intégrité des données.

Cela part du fait de vérifier que nos données sont bien arrivées (utilisation de `isset()`), jusqu'à vérifier le type et le sens des données (attends-t-on des nombres ? => `is_numeric()`, les nombres doivent-ils être dans un certain intervalle ? etc...)

Plus tard les vérifications seront d'autant plus strictes qu'elles devront, pour des raisons de sécurité, s'assurer de l'origine des données (pour empêcher une possible falsification) ainsi que participer au "nettoyage" de celles-ci. Cela pourra se faire en retirant certains caractères indésirables, ou en les rendant innoffensifs ( nous verrons l'utilisation de fonctions comme la fonction `htmlspecialchars()`, etc...).

Le grand enjeu de la gestion des données est souvent **la sécurité des utilisateurs** et de notre plate-forme, étant donné que le destin des valeurs récupérées dans un formulaire sont souvent de finir dans une _base de données_, et celle-ci ne doit jamais être corrompue ou compromise.
