//Dans les langages orientés objets on peut utiliser une structure de données appelée Objet
//celle ci permet l'organisation de données de façon efficace et systématique aidant ainsi à représenter l'existant dans notre code

// //Si l'on désirait représenter un stylo on pourrait le faire de la façon suivante : 
// const stylo = {
//     type: "bille", //ici on définit une propriété nommée type de valeur "bille"
//     couleur: "bleu",
//     marque: "bic",
//     niveauEncre: 80,
// };

// //Pour afficher une propriété d'un objet (comme le niveau d'encre de notre stylo) on utilise nomObjet.nomPropriete
// console.log(stylo.niveauEncre);

//En programmation orientée objet, le véritable avantage découle du principe de classes 
//Une classe est un schéma selon lequel on peut construire des objets
//On définit une classe en spécifiant class NomDeLaClasse {}
class Personnage {
    //pour définir la façon d'instancier (construire) notre personnage
    //on va décrire son constructeur
    //chaque paramètre de la fonction constructor pourra être utilisé 
    //pour instancier notre objet
    constructor(nom, pv, pm, force){
        //dans cette fonction, on pourra modifier les propriétés de la classe, qui seront également les propriétés de l'objet intancié

        //this permet de cibler l'objet lui même 
        //this.nom signifie "le nom de l'objet instancié"
        //pour affecter les paramètres du constructor à notre objet, on doit utiliser this
        this.nom = nom;
        this.pv = pv;
        this.pm = pm;
        this.force = force;
        //on peut définir des paramètres par défaut pour tous les objets
        this.xp = 0;
        this.vivant = true; 
    }

    //une classe peut posséder des fonctions, appelées méthodes, qui seront partagées par tous les objets qui en sont instance
    //ces méthodes peuvent intéragir avec les propriétés de chaque objet respectivement
    description(){
        if (this.vivant){
            return `Je suis ${this.nom}, il me reste ${this.pv} points de vie, et ${this.pm} points de mana. J'ai ${this.force} de Force. Mon compte de points d'expérience s'élève à ${this.xp}.`;
        } else {
            return '...';
        }
    }

    //Attaquer un personnage permet d'infliger des dégâts à ses points de vie en fonction de la force l'attaquant
    //ici, l'attaquant est l'objet lançant la méthode attaquer()
    //et le personnage ciblé par l'attaque est le paramètre cible
    attaquer(cible){
        //si l'attaquant est en ive
        if (this.vivant){
            //si la cible est en vie
            if (cible.vivant){
                //on fait le traitement habituel
                console.log(`${this.nom} attaque ${cible.nom} !`);
                cible.retirerPv(this.force);
                console.log(`${cible.nom} perd ${this.force} pv.`);
                return cible.pv
            } else {
                // sinon on s'épargne le retrait de pv 
                console.log(`${this.nom} s'acharne sur le cadavre de ${cible.nom}.`)
            }
        } else {
            //sinon on affiche une erreur disant que l'attaquant est mort
            console.error(`L'âme de ${this.nom} est combattive, mais rien ne se passe...`)
        }
    }

    //cette méthode retire des pv au personnage
    //et ajuste le compte si jamais celui ci passe sous le minimum
    retirerPv(nombre){
        this.pv -= nombre;
        if (this.pv < 0){
            this.pv = 0;
        }
        this.estMort();
    }
    
    //vérifie si le compte de pv est à zéro ou moins, et passe le statut du personnage à mort si c'est le cas
    estMort(){
        if (this.pv <= 0){
            this.mourir()
        }
    }

    //passe le statut du personnage à mort
    mourir(){
        this.vivant = false;
    }
}

//pour instancier un objet à partir d'une classe 
//on range dans une variable une instance de cette classe en appellant son constructeur
//pour appeler le constructeur on utilise new NomDeClasse(params)

//un objet peut être une constante et avoir des propriétés variables
const personnage1 = new Personnage("Jones", 100, 50, 20, 5);
console.log(personnage1.description());
const personnage2 = new Personnage("Jane", 100, 80, 5, 20);
console.log(personnage2.description());

//on se crée un ennemi
const mechant = new Personnage("Georges Frêche", 200, 0, 30, 30);
//on affiche sa description
console.log(mechant.description());
//et on l'attaque
personnage1.attaquer(mechant);
//on affiche le compte pv diminué du méchant
console.log(mechant.pv);

//HERITAGE
//Le principe d'héritage en programmation orientée objet est le fait
//de créer une classe (enfant) dérviée d'une autre classe (mère)
//La classe enfant hérite ainsi des propriétés et méthodes de la classe mère
//Pour utiliser l'héritage, on utilise le mot clé extends
class Mage extends Personnage {
    //le constructor du Mage s'écrit comme n'importe quel constructor
    constructor(nom, pv, pm, intelligence){
        //à la différence qu'il faut appeler le constructeur de la classe mère à l'aide du mot clé super
        //Ici par exemple, on définit que tous les Mage seraient des Personnage avec une force de 5
        super(nom, pv, pm, 5);
        //l'intelligence quant à elle est une propriété de Mage, et non de Personnage
        this.intelligence = intelligence;
    }

    //on hérite également des méthodes de la classe mère
    //mais on peut y ajouter des modifications, ou les réécrire entièrement, en utilisant le même nom de méthode
    description(){
        return super.description() + ` Je suis également très intelligent, j'ai au moins ${this.intelligence} d'intelligence !`;
    }

    //comme notre Personnage n'a pas de méthode assez générique pour infliger des dégâts quelque soit leur origine, on se retrouve obligés à réécrire une bonne partie de la logique 
    //Si on voulait réutiliser du code de notre classe mère, il aurait peut être fallu le préparer avec une méthode permettant de préciser la source des dégats, la caractéristique utilisée... etc, 
    //ce qui nous aurait permi de construire lancerSort et attaquer sur la même base de code
    lancerSort(nomDuSort, cible){
         //si l'attaquant est en ive
         if (this.vivant){
            //si l'attaquent a assez de point de mana
            if (this.pm >= 10){
                //on retire les points de mana nécessaires
                this.pm -= 10;
                //si la cible est en vie
                if (cible.vivant){
                    //on fait le traitement habituel
                    console.log(`${this.nom} lance ${nomDuSort} sur ${cible.nom} !`);
                    cible.retirerPv(this.intelligence);
                    console.log(`${cible.nom} perd ${this.intelligence} pv.`);
                    return cible.pv
                } else {
                    // sinon on s'épargne le retrait de pv 
                    console.log(`${this.nom} lance ${nomDuSort} sur le bout de viande inanimé qu'est devenu ${cible.nom}. Quel gâchis !`)
                }
            }
        } else {
            //sinon on affiche une erreur disant que l'attaquant est mort
            console.error(`L'âme de ${this.nom} est combattive, mais les morts ne lancent pas de sorts...`)
        }
    }
}

const mage1 = new Mage("Gérard Majax", 80, 150, 30);
console.log(mage1.description()); 
mage1.lancerSort('Boule De Feu', mechant);