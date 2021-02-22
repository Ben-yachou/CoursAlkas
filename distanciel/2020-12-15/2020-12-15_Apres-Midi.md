# Après midi du 15 Décembre 2020

## Inscription et connexion d'utilisateurs

Dans les fonctionnalités d'un site web il est courant de retrouver les fonctionnalités d'inscription et connexion à un compte utilisateur, de façon à pouvoir bénéficier par exemple d'un espace membre ou d'une expérience personnalisée en général.

Pour implémenter ces fonctionnalités il faut donc que la structure de notre application le prévoit, et en particulier notre base de données .

### Mise en place de notre base de données

Pour qu'une base de données soit prête à accueillir des utilisateurs, il faut un moyen de les stocker. Cela se traduit généralement pas la création d'une table utilisateur qui contient souvent les mêmes informations.

Ces informations servent bien sûr à implémenter certaines fonctionnalités, dont l'inscription et connexion font partie, et la structure de nos données doit être définie en ce sens.

Pour le bien de l'implémentation de l'inscription et la connexion on ne va donc utiliser que le strict nécessaire :

-   un _nom d'utilisateur_
-   un _mot de passe_

La table `user` pourrait donc être créée de la façon suivante :

```sql
CREATE TABLE `user`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `nickname` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255),
    PRIMARY KEY (`id`),
    CONSTRAINT `unq_nickname` UNIQUE (`nickname`)
);
```

Rien de particulier ici, si ce n'est peut être le mot clé `CONSTRAINT`.

#### La contrainte d'unicité sur `nickname`

`CONSTRAINT` en SQL permet de décrire une _contrainte_ portant sur une ou plusieurs colonnes de notre table. Dans le cas présent, la contrainte est une d'_unicité_, qui empêche deux lignes de posséder la même valeur dans la colonne `nickname`, rendant les valeurs de `nickname` uniques.

Pour appliquer cette contrainte, et augmenter les performances, SQL se charge de passer `nickname` en `UNIQUE INDEX`.

Si on désirait appliquer cette contrainte après avoir déjà effectué `CREATE TABLE`, on pourrait utiliser `ALTER TABLE` :

```sql
ALTER TABLE `user` ADD CONSTRAINT `unq_nickname` UNIQUE (`nickname`);
```

Pour supprimer une contrainte on doit utiliser `DROP CONSTRAINT` :

```sql
ALTER TABLE `user` DROP INDEX `unq_nickname`;
```

En appliquant notre contrainte, on interdit essentiellement deux utilisateurs de posséder le même pseudonyme.

### Inscription d'un utilisateur

Une inscription d'un utilisateur se traduirait donc par une insertion d'une ligne dans notre table `user`.

Une requête de ce genre devrait donc être executée :

```sql
INSERT INTO `user` (`nickname`, `password`) VALUES (?, ?);
```

Grâce à PHP et `PDO` il nous suffit de préparer une requête, l'exécuter en passant des informations de notre formulaire en paramètres de `execute`, et le tour est joué.

Cependant, deux choses sont encore à gérer :

-   le _hachage_ des mots de passe
-   la gestion de la contrainte d'unicité

### Mots de passes _hachés_

Un mot de passe ne doit bien évidemment pas, pour des raisons de sécurité, être enregistré _en "clair"_ dans notre base de données. Si celle-ci venait à être compromise d'une manière ou d'une autre, on doit faire en sorte que les données récupérées soient les moins utiles possibles.

##### Ne suffit-il pas de chiffrer la base de données et adios ?

Chiffrer une base de données représente un problème plus qu'une solution dans la plupart des applications.

Si toute la base de données, et donc ses tables et champs, est chiffrée constamment, cela nécessite un déchiffrage à chaque fois que l'on désire la consulter. Ce déchiffrage est couteux en temps et en puissance de calcul, et freine donc toute opération simple comme une recherche ou autre.

Le tout est de savoir peser le pour et le contre.

Le chiffrement n'est **pas** une _solution_. Ce n'est qu'un outil supplémentaire pour tenter d'éviter le pire.

La sécurité des données doit passer par bien plus (empêcher les injections SQL, utiliser des comptes d'accès aux bases de données avec des droits corrects, etc...)

##### Alors qu'est ce qu'on fait ?

On peut toujours chiffrer une partie des données qu'on trouve sensible, mais pour les mots de passes une meilleure solution existe, le _hachage_.

#### Hacher un mot de passe avec PHP

Le hachage d'abord qu'est ce que c'est ?

Le hachage est le processus de génération d'une _signature_ (ou _empreinte_) à partir d'un contenu, de façon à pouvoir identifier ce contenu de façon unique.

Contrairement au chiffrage, le but n'est pas de _coder une information_, mais de générer une valeur unique représentant une donnée.

En cela, le hachage est appelé _processus destructif_ car ne conservant l'information de la valeur hachée.

Plus d'exemple sur cet [article wikipédia](https://fr.wikipedia.org/wiki/Fonction_de_hachage).

##### Pourquoi est-ce si approprié pour nos mots de passe ?

Parce qu'une même valeur sera toujours représentée par le même _hash_ (en utilisant le même algorithme avec les mêmes paramètres bien sûr). Cela nous autorise à stocker une _représentation unique_ des mots de passes sans pour autant stocker le mot de passe lui même. Ce qui fait que même dans le cas extrême ou notre base de données serait compromise, le mot de passe haché serait inutile.

##### `password_hash` en PHP

En PHP donc on utilise la fonction `password_hash` qui prend en paramètres le mot de passe à _hacher_, et l'algorithme à utiliser.

Plusieurs algorithmes sont disponibles, mais pour être sûrs d'utiliser le meilleur à disposition on utilise la constante `PASSWORD_DEFAULT`.

```php
$password_hash = password_hash($password, PASSWORD_DEFAULT);
```

Il ne nous reste plus qu'à enregistrer le `hash` généré dans la base de données à la place du mot de passe lui même.

#### Gérer la contrainte d'unicité

On a ajouté une contrainte d'unicité à notre table `user` qui empêche d'insérer deux `user` avec un `nickname` identique. Cependant, cette contrainte est définie du côté de SQL et PHP (avec `PDO`) n'est pas au courant.

SQL se retrouverait donc à envoyer un message d'erreur si jamais on essayait d'insérer un utilisateur déjà existant. Comment détecter cette erreur ?

##### `errorInfo()` et le code `SQLSTATE`

`PDOStatement::errorInfo()` permet de récupérer les informations d'erreur renvoyées après un `execute`. Ces informations sont rangées dans un tableau selon la structure suivante :

| index | info                                                              |
| ----- | ----------------------------------------------------------------- |
| 0     | Code d'état SQLSTATE (5 caractères alphanumériques)               |
| 1     | Code erreur du driver (un entier à 4 chiffres pour mysql/mariadb) |
| 2     | Message d'erreur du driver                                        |

Pour notre contrainte d'unicité le résultat d'`PDOStatement::errorInfo()` en cas de doublon sera le suivant sur `mysql`/`mariadb`:

```php
Array
(
    [0] => "23000"
    [1] => 1062
    [2] => "Duplicate entry 'entry' for key 'key'"
)
```

S'il n'y a aucune erreur, `PDOStatement::errorInfo()` nous renvoie :

```php
Array
(
    [0] => "00000"
    [1] => 0
    [2] => ""
)
```

Il nous suffit donc de vérifier si le résultat d'`errorInfo` contient `"23000"` à l'index `0` et `1062` à la case `1`. Si c'est le cas, l'information est un duplicata :

```php
if ($stmt->errorInfo()[0] === "23000" && $stmt->errorInfo()[1] === 1062) {
//on peut donc envoyer un petit message ou rediriger ou faire ce qu'on veut
    echo $nickname . " existe déjà !";
}
```

### Connexion d'un utilisateur

Pour connecter un utilisateur il nous suffit donc de lire dans notre table `user` pour trouver l'utilisateur tentant de se connecter, et comparer le mot de passe entré avec le `hash` stocké dans notre base.

#### Récupérer l'utilisateur

Pour récupérer l'utilisateur on se contente d'utiliser `SELECT` :

```SQL
SELECT * FROM `user` WHERE `nickname` = ?;
```

Si un utilisateur a bien été récupéré on peut donc comparer le `hash` stocké avec le mot de passe qui a été donné via le formulaire.

Pour ça on utilise

#### `password_verify` :

`password_verify` est la soeur de `password_hash` et permet de vérifier si un mot de passe en clair correspond bien à un _hash_ généré par `password_hash`.

```php
if (password_verify($password, $user["password"])) {
//si le mot de passe est bien le bon, on peut commencer une session, ou rediriger ou faire ce qu'on veut
    echo "utilisateur connecté";
}
```

Et le tour est joué.

## Petit mot sur les triggers

Pendant le cours nous avons également énoncé l'existence des `triggers` (ou _déclencheurs_) en SQL. Les `triggers` à la manière des _procédures stockées_ représentent un moyen d'enregistrer un traitement en avance pour qu'il soit déclenché à posteriori.

Contrairement aux procédures stockées cependant on ne peut pas déclencher les `triggers` à loisir, on doit les attacher à un évènement particulier pour qu'ils y _réagissent_ (se déclenchent).

Un `trigger` permet donc par exemple de modifier une colonne d'une certaine table lors d'une insertion dans une autre table, ce qui permet de mettre en place des colonnes à _valeurs calculées_ par exemple (comme des totaux, des résultats de calculs en général, des combinaisons de nom et prénom, que sais-je encore...).

Voir ce [cours openclassrooms](https://openclassrooms.com/fr/courses/1959476-administrez-vos-bases-de-donnees-avec-mysql/1973090-triggers) ou encore la syntaxe sur [sql.sh](https://sql.sh/cours/create-trigger) pour en apprendre plus sur les déclencheurs.
