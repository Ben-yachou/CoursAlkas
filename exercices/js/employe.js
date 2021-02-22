//EXERCICE
//Définir une classe Employé caracterisée par les propriétés suivantes
//Identifiant
//Nom
//Prénom
//Année de naissance
//Année d'embauche
//Salaire
//Ajouter à la classe la méthode age() qui renvoie l'âge de l'employé
//Ajouter à la classe la méthode anciennete qui renvoie le nombre d'années
//d'ancienneté de l'employé
//Ajouter à la classe la méthode augmentation()
//qui augmente le salaire de l'employé en prenant l'ancienneté en considération
// Si 3 ans d'anncienneté ou moins, 2% d'augmentation
// Entre 3 et 5 ans, 5% 
// Entre 5 et 10 ans, 10%

//Ajouter une dernière méthode afficher() qui affiche les informations de l'employé
//Son identifiant, son nom complet (nom prénom), son age
//son ancienneté et son salaire

class Employe {
    constructor(id, nom, prenom, anneeNaissance, anneeEmbauche, salaire) {
        this.id = id;
        this.nom = nom;
        this.prenom = prenom;
        this.anneeNaissance = anneeNaissance;
        this.anneeEmbauche = anneeEmbauche;
        this.salaire = salaire;
    }

    age() {
        return 2019 - this.anneeNaissance;
    }

    anciennete() {
        return 2019 - this.anneeEmbauche;
    }

    augmentation() {
        if (this.anciennete() <= 3){
            this.salaire += (this.salaire*2)/100;
        } else if (this.anciennete() > 3 && this.anciennete <= 5){
            this.salaire += (this.salaire*5)/100;
        } else {
            this.salaire += (this.salaire*10)/100;
        }
        return `Salaire augmenté à ${this.salaire}`;
    }

    afficher() {
        console.log(`
        ${this.id} : ${this.nom} ${this.prenom}
        ${this.age()} ans 
        ${this.anciennete()} ans d'ancienneté
        Salaire : ${this.salaire}
        `)
    }
}