# Introduction aux algorithmes 

Un algorithme est `un ensemble d'instructions visant à résoudre un problème`.

En programmation, ces algorithmes sont définis à l'aide de `symboles` qui constituent un `langage de programmation`. 

Parmis ces symboles, certains concepts se retrouvent quelque soit le langage utilisé: 

## 1- Les Variables 
Une *variable* est un registre permettant de stocker et référencer une valeur. 

Par exemple, si je définis une variable

```
code_postal = 34000 
```

Alors toute réference à `code_postal` renverra la valeur `34000`

Si je désire redéfinir une variable je peux faire 
```
code_postal = 34090 
```
Toute référence subséquente à `code_postal` renverra `34090`

## 2- Les fonctions
Une *fonction* est un ensemble d'instructions visant à effectuer une action précise. 
Ce bloc d'instructions peut être utilisé autant de fois que nécessaire en invoquant son nom. 

En programmation, on *déclare* une fonction et son comportement d'abord, pour ensuite l'*invoquer*, ou l'*exécuter*, plus tard. 

Exemple : 
```
  fonction Multiplier : 
    pour deux nombres a et b 
    renvoyer a * b
```

## 3- Les Boucles 
Une *boucle* est une structure permettant de répéter le même jeu d'instructions **plusieurs fois**. 
Une boucle possède une *condition d'arrêt* qui indique quand stopper l'exécution des instructions qu'elle contient. 
Une boucle sans condition d'arrêt ou avec une condition d'arrêt mal définie est une boucle infinie. 

Parmi les boucles existantes il en existe deux très communes en progrmamation : 

Tant que (`while`) : exécuter les actions jusqu'à ce qu'un condition soit validée 
Pour chaque (`for`/`foreach`) : exécuter les actions pour chaque élément d'une suite 

## 4- Les structures conditionnelles 
Une *structure conditionnelle* permet d'effectuer un branchement (ou choix) entre deux jeux d'instruction selon une condition. 
Ces structures se définissent à l'aide des termes Si et Sinon : 

```
Si age_utilisateur >= 18 Alors 
    Donner accès au site 
Sinon 
    Renvoyer chez maman 
```

En anglais, on traduit ça par `if` et `else`. 


## 5- Les types de données 
Un ordinateur ne connaissant que des valeurs représentées en *binaire* (0 ou 1), il faut associer des valeurs binaires à d'autres concepts pour obtenir des données complexes, comme les lettres ou les sons. 

### Les entiers 

La première structure de données utilisée est tout simplement le nombre entier (Integer en anglais, `int` en programmation). 
Viennent ensuite les nombres à virgule (à virgule flottante en informatique, `float` en programmation). 

Ex: 0, 12, 7553

### Les caractères

Les caractères quant à eux sont représentés également en binaire à l'aide de jeux de caractères qui font correspondre un nombre (en binaire) à un symbole. 

Exemple : `a` en ascii correspond à `97` en base 10, ou `1100001` en binaire. 

Une chaîne de caractères (appelée `string` en anglais) est un ensemble de caractères. 

### Les booléens
Les booléens sont un type de données indiquant uniquement "vrai" ou "faux" (0 ou 1, `true` ou `false`). 
Une condition par exemple s'évalue toujours en booléen. 
```
age > 18

renvoie true si age == 21
renvoie false si age == 13
```

## 6 - Les structures de données 

Une structure de donnée sert à organiser les données d'une certaine manière pour améliorer l'efficacité d'un programme, ou même son écriture. 

Dans les structures de données courantes on retrouve :

- les tableaux 
- les listes
- les dictionnaires
- les graphes 

Un tableau en programmation est une structure permettant de mémoriser plusieurs données de type semblable. 
Par exemple, un tableau contenant les températures prévues à montpellier contiendrait : 
```
Témpératures de la journée à Montpellier : 
   0    1    2    3    4    5    6    7
[ 19 | 21 | 19 | 17 | 15 | 14 | 13 | 13 ]
```
Un tableau identifie chaque case à l'aide d'un indice, partant de 0. 
En demandant une valeur se trouvant à une certaine case, le programme pourra ainsi récupérer une valeur précise. 

Ex: 
```
dans notre tableau de températures, 
la valeur à l'indice 0 du tableau est 19
la valeur à l'indice 4 du tableau est 15 