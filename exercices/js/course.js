//EXERCICE
//Coder une course de Voitures
//Pour ce faire il faut suivre les conditions suivantes

// Créer une classe Voiture qui condiendra :
//une écurie (une chaine de caractères)
//une place dans la course (un nombre)

//On instanciera cette classe en appellant new Voiture(ecurie) 
//(ex : const voiture1 = new Voiture("Mazda"))

//Créer ue classe Course qui contiendra
//Une liste de voitures (un tableau d'objets Voiture)
//et cette classe sera instanciée en appelant
//new Course(voitures)
//const voitures = [voiture1, voiture2...etc]; const course = new Course(voitures);

//Il faudra faire en sorte que les voitures puissent se dépasser entre elles
//se faire éliminer (accident)
//et que le classement de la course puisse être affiché

class Voiture{
    constructor(ecurie, place = 0){
        this.ecurie = ecurie;
        this.place = place;
    }
}

class Course{
    constructor(voitures){
        this.voitures = voitures;
        this.organiser();
    }

    classement(){
        for (let i = 0; i < this.voitures.length; i++){
            console.log(this.voitures[i].place, this.voitures[i].ecurie);
        }
    }

    organiser(){
        for (let i = 0; i < this.voitures.length; i++){
            this.voitures[i].place = i+1;
        }
    }

    changerPlace(place1, place2){
        let tmp = this.voitures[place1-1]; //on met la v1 de côté
        this.voitures[place1-1] = this.voitures[place2-1]; //on met la v2 a la place de la v1
        this.voitures[place2-1] = tmp; //on met la v1 a la place de la v2

        this.organiser();
    }

    depassement(place){
        if (place !==1){
            this.changerPlace(place, place-1);
        }
    }

    eliminer(place){
        //on supprime la voiture dans le tableau
        this.voitures.splice(place-1, 1);
        this.organiser();
    }
}

const aston = new Voiture("Aston Martin - Red Bull");
const bmw = new Voiture("BMW Sauber");
const ferrari = new Voiture("Scuderia Ferrari");
const haas = new Voiture("Haas F1");
const mclaren = new Voiture("McLaren Racing");
const mercedes = new Voiture("Mercedes GP");
const renault = new Voiture("Renault Sport");

const voitures = [ferrari, bmw, aston, haas, mclaren, mercedes, renault];
const course = new Course(voitures);

