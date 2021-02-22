//Dans les langes orientés objet on peut utiliser
//une structure de donées appelée Objet
//qui permet l'organisation de données de façon efficace
//et systématique aidant ainsi à représenter l'existant
//dans nos programmes

// //Un stylo possèderait donc les propriétés suivantes le représentant
// const stylo = {
//     type: "bille", //on définit un type de pointe
//     couleur: "bleu", //la couleur de l'encre
//     marque: "Bic", //sa marque
//     encre: 80
// };

// //pour afficher la couleur de notre stylo il nous suffit de faire
// console.log(stylo.couleur);

// const personnage = {
//     nom: "Jones",
//     hp : 100,
//     mana: 50,
//     force: 20,
//     xp: 0
// }

//en programmation orientée objet le principe le plus important
//est celui des classes
//une classe est un schéma selon lequel on peut construire un objet
//on définit une classe en spécifiant class NomDeLaClasse {}
class Personnage {
    //pour définir la façon de construire notre personnage
    //on va écrire son constructeur
    constructor(nom, hp, mana, force, hpMax = 300){
        //this permet de cibler l'objet actuel
        //this.nom signifie "le nom de l'objet en cours"
        //ici on fait passer les paramètres de création d'objet
        //et on affecte les valeurs aux propriétés de l'objet
        this.nom = nom;
        
        this.hp = hp;
        this.hpMax = hpMax; //le seuil maximum de points de vie, par défaut à 300
        this.hpMin = 0; //un seuil minimum de points de vie 
        if (this.hp > this.hpMax){
            this.hp = this.hpMax;
        }

        this.mana = mana;
        this.force = force;
        //on peut aussi définir des paramètres par défaut pour tous les objets
        this.xp = 0;
        //de base un personnage n'est pas mort
        this.mort = false;
    }

    //un objet peut posséder des fonctions, appelées Méthodes, qui lui sont propres
    //ces méthodes peuvent intéragir avec les propriétés de l'objet
    //par exemple, une méthode permettant de renvoyer une phrase descriptive du personnage
    description(){
        return `${this.nom} a ${this.hp} points de vie,
        ${this.mana} points de mana,
        et ${this.force} de force. 
        Il a ${this.xp} points d'expérience`;
    }

    //passe this.mort à true si le compte de point de vie tombe en dessous du minimum
    estMort(){
        this.mort = this.hp <= this.hpMin;
    }

    //cette méthode retire des hp au personnage 
    //et ajuste le compte de hp si celui ci passe sous le minimum
    retirerHp(n){
        this.hp -= n;
        if (this.hp < this.hpMin) {
            this.hp = this.hpMin
        }
        //une fois les points de vie retirés, on vérifie si le personnage est mort
        this.estMort();
    }

    //attaquer un personnage permet d'infliger des dégâts à ce personnage
    //en fonction de la force de l'attaquant
    attaquer(cible){
        //si l'attaquant est en vie
        if (!this.mort){
            //si la cible est en vie
            if (!cible.mort){
                console.log(`${this.nom} frappe ${cible.nom} pour ${this.force} de dégâts`);
                //alors on attaque la cible avec les points de force de l'attaquant
                cible.retirerHp(this.force);
                //si après le retrait de points de vie, la cible est morte
                if (cible.mort){
                    //on affiche un message
                    console.log(`${cible.nom} a été tué des suites du coup porté par ${this.nom}`);
                }
            } else {
                console.log(`${this.nom} attaque le cadavre de ${cible.nom}, quel lâche !`);
            }
        } else {
            console.log(`${this.nom} ne peut pas attaquer en étant mort`);
        }
    }
}

//pour instancier une classe on range dans une variable 
//une nouvelle instance de cette classe
//monObjet = new MaClasse(param1, param2...);

//un objet peut être une constante et avoir ses propriétés variables
const jones = new Personnage("Jones", 100, 50, 20);
const jane = new Personnage("Jane", 100, 80, 15);

//on peut ensuite appeler ces objets instanciés et leurs propriétés 
//de la même façon pour chaque objet 
console.log(jones.nom, jones.xp); //affiche Jones, 0
console.log(jane.nom, jane.xp); //affiche Jane, 0
//on affiche la description de nos deux personnages
console.log(jones.description());
console.log(jane.description());

//on crée un ennemi
const mechant = new Personnage("Immorthan Joe", 200, 0, 30);
//on affiche sa description
console.log(mechant.description());
//on l'attaque
jones.attaquer(mechant);
//on affiche sa description montrant le compte de points de vie diminué
console.log(mechant.description());


//HERITAGE
//l'héritage en programmation orientée objet est le fait 
//de créer une classe dérivée d'une autre classe, la classe dérivée
//héritant des propriétés et méthodes de la classe mère
//pour hériter d'une classe on utilise le mot clé extends

class SuperPersonnage extends Personnage {
    constructor(nom, hp, mana, force, dexterite){
        //lorsqu'on hérite d'une classe, on peut appeler le constructeur
        //de la classe mère à l'aide de super
        super(nom, hp, mana, force, 600);
        this.dexterite = dexterite;
    }

    //on hérite également des méthodes de la classe mère
    //et on peut y ajouter des modification
    description(){
        return super.description() + `${this.nom} a également ${this.dexterite} points de dextérité`;
    }
}

const superJones = new SuperPersonnage("Super Jones", 600, 50, 20, 20);
console.log(superJones.description());