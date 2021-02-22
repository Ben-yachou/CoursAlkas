class Vehicule{
    constructor(nbRoues){
        this.nbRoues = nbRoues;
        this.vitesse = 0;
    }
}

class VehiculeMotorise extends Vehicule{
    constructor(nbRoues, moteur){
        super(nbRoues);
        this.moteur = moteur;
    }
}

class Voiture extends VehiculeMotorise{
    constructor(moteur, nbPortes, marque){
        super(4, moteur);
        this.nbPortes = nbPortes;
        this.marque = marque;
    }
}
const vehicule = new Vehicule(11);
const voiture = new Voiture("Essence", 5, "Renault");


class VehiculeAPedales extends Vehicule{
    constructor(nbRoues, nbPedales){
        super(nbRoues);
        this.nbPedales = nbPedales;
    }
}

class Bicyclette extends VehiculeAPedales{
    constructor(nbPedales, type){
        super(2, nbPedales);
        this.type = type;
    }
}

const vtt = new Bicyclette(2, "Tout Terrain");
const tandem = new Bicyclette(4, "Urbain");