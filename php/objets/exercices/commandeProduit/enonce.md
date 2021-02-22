# Exercice commande d'un produit par un utilisateur

Implémenter les classes d'objet permettant de reproduire le comportement suivant :

Un `utilisateur` peut commander un `produit`, ce qui génère un `bon de commande`.

L'utilisateur possède des coordonnées (`nom`, `prenom`, `adresse`), il possède également un `montant de réduction` en %age.

Le produit possède un `nom`, un `numéro de produit` ainsi qu'un `prix` à l'unité.

Le bon de commande contiendra un `numéro de commande`, un `utilisateur`, un `produit` acheté, une `quantité` ainsi qu'un `total` du prix. Egalement, le `total avec réduction utilisateur appliquée`.

A partir du bon de commande on pourra donc afficher le récapitulatif de la commande au format suivant :

```
Commande n°x :

Produit : prix produit
xQuantité: total
reduction appliquée: total réduit

Acheteur:
nom - prénom
adresse
```
