//EXERCICE
//Implémenter la gestion d'un compte en banque
//Un compte comprends les informations suivantes
//Un nom de client
//Un solde
//Un compte comprends les méthodes suivantes
//Crediter qui prend un nombre en paramètre 
//Débiter qui prend un nombre en paramètre
//Afficher qui affiche le nom du client et le solde restant

class Compte{
    constructor(nom, solde){
        this.nom = nom;
        this.solde = solde;
    }

    crediter(n){
        this.solde += n;
    }

    debiter(n){
        if (this.solde >= n){
            this.solde -= n;
        } else {
            console.log("Pas assez de thunes");
        }
    }

    afficher(){
        console.log(this.nom, this.solde)
    }
}

const compte = new Compte("Dubois", 1000);
compte.afficher()
compte.crediter(100);
compte.debiter(50);
compte.debiter(1500);
compte.afficher()
//SUITE EXERCICE
//Créer une classe Client
//la classe Client contient nom, prenom, date de naissance
//et l'intégrer dans le compte à la place de nom
//remplacer la propriété nom par une propriété client
//qui contient un objet Client

class CompteClient{
    constructor(client, solde){
        this.client = client;
        this.solde = solde;
    }

    crediter(n){
        this.solde += n;
    }

    debiter(n){
        if (this.solde >= n){
            this.solde -= n;
        } else {
            console.log("Pas assez de thunes");
        }
    }

    afficher(){
        console.log(this.client.nom, this.solde)
    }
}

class Client{
    constructor(nom, prenom, date){
        this.nom = nom;
        this.prenom = prenom;
        this.date = date;
    }
}

const nouveauClient = new Client("José", "Jose", 99);
const compteClient = new CompteClient(nouveauClient, 1000);