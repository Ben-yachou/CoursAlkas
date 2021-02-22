//EXERCICE
//Créer une classe mère Animal
//cette classe prendra en compte les caractéristiques
//prores aux animaux en tout genre
//Puis créer des classes filles (héritage) d'animaux spécifiques
//en leur attribuant des spécificités dues a leur nature
//Une classe Oiseau aurait une propriété envergure, un type de bec mais un chat non, etc...


class Animal {
    constructor(classe, nom, age, genre, poids, deplacement) {
        this.classe = classe;
        this.nom = nom;
        this.age = age;
        this.genre = genre;
        this.poids = poids;
        this.deplacement = deplacement;
    }

    //cet objet appelé énumération permet d'accéder a des valeurs fixes
    //de façon pratique et lisible, utile lorsqu'une variable ne peut avoir
    //qu'un certain nombre de valeurs possibles
    //ici get signifie que la propriété ne peut pas être modifiée
    //et n'est accessible qu'en lecture
    //static signifie que tout le monde lire cette valeur
    static get CLASSE() {
        return {
            AVES: "Oiseau",
            MAMMALIA: "Mammifère",
            REPTILIA: "Reptile"
        }
    }

    static get GENRE() {
        return {
            M: "Mâle",
            F: "Femelle",
            N: undefined
        }
    }

    static get DEPLACEMENT(){
        return {
            VOL: "Vol",
            MARCHE: "Marche",
            NAGE: "Nage",
            RAMPE: "Rampe"
        }
    }

    description(){
        return `${this.nom}, ${this.classe} 
        ${this.genre} âgé${this.genre === Animal.GENRE.F ? "e" : ""} de ${this.age} mois. ${this.genre === Animal.GENRE.F ? "Elle" : "Il"} pèse ${this.poids} grammes`;
        //condition ternaire
        //permet de tester une condition sur une ligne et donc de l'utiliser dans nos chaines
        //syntaxe : condition ? positif : negatif
        //exemple : i!= 0 ? i : 0 veut dire si i différent de 0 afficher i sinon afficher 0 
    }
}

//notre classe Oiseau hérite d'Animal
class Oiseau extends Animal {
    constructor(nom, age, genre, poids, espece, envergure, bec, chant) {
        //on appelle le constructeur d'Animal pour affecter les propriétés
        //propres à tous les animaux
        super(Animal.CLASSE.AVES, nom, age, genre, poids, [Animal.DEPLACEMENT.VOL, Animal.DEPLACEMENT.MARCHE]);
        //on affecte les propriétés propre à Oiseau
        this.espece = espece;
        this.envergure = envergure;
        this.bec = bec;
        this.chant = chant;
    }

    //un oiseau peut chanter
    chanter(){
        return `${this.nom} chante: ${this.chant}`;
    }

    description(){
        return super.description() + `\nC'est un${this.genre === Animal.GENRE.F ? "e" : ""} ${this.espece} d'une envergure de ${this.envergure}cm`;   
    }
}

class Chien extends Animal {
    constructor(nom, age, genre, poids, race, taille, robe) {
        super(Animal.CLASSE.MAMMALIA, nom, age, genre, poids, [Animal.DEPLACEMENT.MARCHE, Animal.DEPLACEMENT.NAGE]);
        this.race = race;
        this.taille = taille;
        this.robe = robe;
    }
}

const specimen1 = new Animal(Animal.CLASSE.AVES, "joe", 8, Animal.GENRE.M, 15);
const oiseau1 = new Oiseau("Roger", 13, Oiseau.GENRE.M, 50, "Sitta whiteheadi", 21, "fin", "pupupupupu");
const chien1 = new Chien("Gally", 18, Chien.GENRE.F, 8, "shiba", 38, "sésame");