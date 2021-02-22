//Exercice Compte En Banque
//Implémenter la gestion simple d'un compte en banque
//Un compte comprends les informations suivantes :
//Un nom de client et Un solde
//Un compte doit pouvoir effectuer les opérations suivantes : 
//Créditer un montant, 
//débiter un montant,
//afficher le nom du client et le solde du compte

//on crée notre classe Compte
class Compte{
    //notre constructeur demande un nom et un solde pour la création d'un compte
    constructor(nom, solde){
        this.nom = nom;
        this.solde = solde;
    }

    afficher(){
        console.log(`Compte de ${this.nom}. Solde à disposition : ${this.solde}€`);
    }

    //pour créditer le compte d'un certain montant
    crediter(montant){
        //on ajoute le montant au solde du compte
        this.solde += montant;
    }

    //pour débiter un montant à un compte
    debiter(montant){
        //on vérifie que le solde soit suffisant
        if (this.solde >= montant){
            //si c'est le cas, on réduit le solde
            this.solde -= montant;
        } else {
            console.error("Pas assez de flouz")
        }
    }
}
const compteBernard = new Compte("Bernard", 100);
compteBernard.afficher();
const compteJacques = new Compte("Jacques", 200);
compteJacques.afficher();

compteBernard.crediter(100); // le compteBernard a désormais un solde de 200
compteBernard.debiter(50); //le solde est de 150;
compteBernard.debiter(1000); //erreur renvoyée, pas assez de flouz

//Suite Exercice:
//Créer une classe Client à part, contenant un nom, prenom, date de naissance
//Créer une classe CompteClient, possédant comme propriété un Client, et les mêmes propriétés et opérations que le Compte au dessus

class Client{
    constructor(nom, prenom, ddn){
        this.nom = nom;
        this.prenom = prenom;
        this.ddn = ddn;
    }
}
//on hérite de Compte pour profiter de ses fonctionnalités
class Compteclient extends Compte{
    constructor(client, solde){
        //on appelle le constructeur de compte en lui envoyant en guise de nom 
        //le prénom du client + le nom du client
        super(`${client.prenom} ${client.nom}`, solde);
        this.client = client;
    }
}

const nouveauClient = new Client("B", "Patrick", "16/08/1948");
const comptePB = new Compteclient(nouveauClient, 9);
comptePB.debiter(3); //reste 6
comptePB.afficher(); 
comptePB.debiter(33); //pas assez de flouz
