# Après midi du 5 Janvier 2021

Quelle journée ! Quel régal. On a perdu approximativement 16 personnes sur 18, et les deux derniers s'accrochent juste parce qu'ils ne veulent pas se dire que leur journée a été complètement jetée à la poubelle, ce qui est tout à leur honneur. Bravo à eux.

Dans cette journée de souffrance on a quand même su retirer quelques informations utiles, au delà du fait que votre serviteur ait visiblement complètement perdu l'esprit.

## 1 - L'architecture MVC

Lors de notre réusinage (_refactorisation_) de projet blog, nous avons tendu notre architecture d'application vers un paradigme légèrement différent du départ.

En effet, notre postulat de départ était plutôt naïf, et la qualité et lisibilité de notre code s'en ressentait beaucoup.
Chaque fichier représentait une page, et contenait les logiques de connexion à la base, envoi des requêtes, gestion des formulaires, etc... pour chaque page.

Notre nouvelle organisation est légèrement différente, et se rapproche de ce qu'on appelle l'architecture `MVC` (pour **M**odel, **V**iew, **C**ontroller).

### En quoi ça consiste ?

`MVC` signifie que notre application se découpe en -- plus ou moins -- `3` types de composants.

-   Le _Modèle_

    Le modèle est la représentation applicative de notre base de données relationnelle. Il agit comme un calque de notre schéma de base de données sous la forme d'objets.

    Ces objets nous permettent, entre autres, de mieux structurer les résultats de nos requêtes, mais également nos requêtes elles-même.

    Le modèle est utilisé avec un `ORM` (**O**bject **R**elational **M**apper), qui est une partie de notre application se chargeant de faire le lien entre les données de la base et nos objets (instancie les objets en quelque sorte)

-   La _Vue_

    La vue, ou les vues, c'est ce qui s'affiche à l'écran. Il s'agit la plupart du temps de la mise en forme de notre réponse à l'écran sous forme de HTML, le tout généré à l'aide de ce qu'on appelle un _moteur de templates_, et de _templates_.

    Généralement les vues sont prévues pour être réutilisables, et permettent d'afficher les pages de façon _dynamique_. C'est à dire que les données à l'intérieur changent en fonction de l'utilisation de l'application.

-   Le _Contrôleur_

    Il contient la _logique_ de notre application. C'est celui qui se charge de coordonnée le _modèle_ et la _vue_ pour que les bonnes données et les bonnes pages soient affichées.

    Mais il peut faire bien plus : routage, authentification... Le/les contrôleurs sont véritablement au centre de notre application.

### On a fait ça nous ?

En quelques sorte. Si on regarde notre application blog, on a découpé notre code en 3 parties :

-   le dossier `db` contenant nos `model` et notre `DatabaseHandler` représentent le _modèle_ (nos classes BlogArticle, BlogUser et BlogComment) et l'`ORM` (le mappeur objet-relationnel)

-   le fichier `display.php` qui contient nos _vues_ (nos fonctions renvoyant de l'HTML)

-   tous les autres fichiers représentant nos _controlleurs_, ils font appel au `DatabaseHandler` et à nos _vues_ au moment opportun pour assembler nos pages.

### A quoi ça sert concrètement ?

Organiser notre application en `MVC` permet de faciliter son développement. En ayant les composants ainsi définis apporte une meilleure _séparation des responsabilités_, et permet ainsi une meilleure évolution et maintanabilité.

Chaque composant fait une chose et la fait bien.

Mais c'est aussi plus de principes à respecter qui sont plus facilement respectés grâce à un architecture solide comme MVC.

### `S.O.L.I.D`

`MVC` permet de se rapprocher des principes dit `S.O.L.I.D` qui sont les suivants (on peut les retrouver sur [wikipedia](<https://fr.wikipedia.org/wiki/SOLID_(informatique)>)):

-   **S**ingle responsibility - Responsabilité unique :

    Une classe fonction ou méthode doit avoir une et une seule résponsabilité

-   **O**pen/closed principle - Principe d'Ouverture/Fermeture :

    Une entité d'application (classe, fonction...) doit être **ouverte** à une _extension_, mais **fermée** à une _modification_.

-   **L**iskov Subtitution Principle - Principe de substitution de Liskov :

    Une instance d'application de type `T` doit pouvoir être remplacée par une instance de type `G`, tant que `G` est un sous type de `T`, et ce sans modifier la cohérence d'application.

    [Barbara Liskov](https://fr.wikipedia.org/wiki/Barbara_Liskov) est une informaticienne américaine ayant définit cette définition de sous-typage.

-   **I**nterface segregation principle - Principe de séparation des interfaces :

    On préfère plusieurs interfaces spécifiques pour chaque tâche plutôt qu'une interface générale faisant "tout".

-   **D**ependency Inversion Principle - Principe d'inversion de dépendances :

    Il faut dépendre des abstractions, pas des implémentations.
    C'est à dire que les modules de notre application préfereront dépendre d'une même abstraction plutôt que dépendre les uns des autres.

Ces principes peuvent paraitre un peu abstraits pour l'instant, je vous encourage à lire sur le sujet si vous avez l'occasion (ce ne sont pas les articles qui manquent sur internet).

Ils ne sont pas forcément le standard à suivre à tous les coups, mais une application tendant vers ces principes à de grandes chances d'être robuste.

### Ca m'a l'air d'être de la bonne branlette intellectuelle tout ça, on peut pas juste balancer des images dans wordpress ?

Si, on peut.

Gardons à l'esprit tout de même que Wordpress a été développé également en respectant (tout du moins en partie) ces principes.

Si on veut aspirer à mettre en place des applications propres, il faut aspirer à suivre ce genre de principes (`SOLID`) et ce genre de _design patterns_ (`MVC`, même s'il en existe toute une tripotée).

### Comment faire pour réellement y coller ?

Notre organisation de projet ici, je l'ai précisé plus haut, ne fait que _se rapprocher_ de `MVC` et des principes de `SOLID`. Notre approche naïve de départ nous ralentit encore un peu, et il faudra peut être mieux structurer notre projet en amont pour pouvoir respecter ces principes.

C'est là que les frameworks interviennent !

On verra ça plus tard.

## 2 - L'en-tête `Location`

On a parlé de l'en-tête HTTP `Location`, qu'on définit dans notre application à l'aide de la fonction `header` de php.

Cette fonction permet de définir cet en-tête de façon à ce que, à la **fin** de notre script php, la réponse envoyée au serveur contienne cet en-tête.

Lorsque le navigateur reçoit la réponse, il lit l'en-tête `Location` et effectue la _redirection_ vers la page précisée, avec le code de statut HTTP `302 - Found`.

Comme la redirection ne se fait qu'au moment de la récéption de la réponse par le Navigateur, notre script PHP s'exécute donc dans son intégralité à tous les coups. Pour éviter que du code inutile (vu qu'on sera redirigés de toutes man ières) soit executé, on peut faire quelque chose de ce genre :

```php

if( condition ){

    header('Location: index.php');
    exit; //sans ce exit, le reste du code potentiellement inutile serait executé
}

//reste du code qui ne sera pas executé si la condition est validée
```

## 3 - La modification des codes de statut HTTP

Lorsque PHP termine l'exécution d'un script, il fait passer l'info au serveur qui transfère la réponse au client. Par défaut, PHP donne à ces réponses le code de statut `200 - OK`.

Le plus souvent, `200 - OK` nous va très bien. Mais dans certains cas, il faut pouvoir changer le code pour mieux décrire ce qu'il se passe.

Par exemple, si une donnée n'est pas trouvée, le code de statut `404 - Not Found` doit être renvoyé.

Dans le cas d'une redirection temporaire, c'est le code `307 - Temporary Redirect` qui doit être utilisé, alors que pour une permanente c'est `308 - Permanent Redirect` qui doit être renvoyé.

Ce ne sont que des exemples, jetez un coup d'oeil à la liste des codes HTTP pour plus d'information.

Mais du coup comment définir ces codes en PHP ? Eh bien de la même façon qu'on peut définir un en-tête spécifique avec `header`, on peut définir le code de retour de la page avec `http_response_code` :

```php
http_response_code(404);
exit('Page Not Found');
```

```php
//redirection permannente
http_response_code(308);
header('Location: index.php');
```
