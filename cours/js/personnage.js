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
        //si après le retrait de points de vie, la cible est morte
        if (this.mort){
            //on affiche un message
            console.log(`${this.nom} est mort des suites de ses blessures`);
        }
    }

    ajouterHp(n){
        if (this.mort){
            console.log(`${this.nom} est mort, inutile de s'acharner`);
        } else {
            this.hp += n;
            if (this.hp > this.hpMax){
                this.hp = this.hpMax
            }
        }
    }
    
    //la valeur précisée en paramètre ici est une valeur par défaut
    //elle ne sera utilisée que si aucun paramètre n n'est utilisé
    //lors de l'appel de la méthode
    ressuciter(n = (this.hpMax * 0.1)){
        if (this.mort){
            this.ajouterHp(n);
            this.estMort();
            console.log(`${this.nom} a été ressucité par la grâce des anciens`)
        } else {
            console.log(`Pas besoin de ressucite ${this.nom}, il est toujours en vie !`)
        }
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
            } else {
                console.log(`${this.nom} attaque le cadavre de ${cible.nom}, quel lâche !`);
            }
        } else {
            console.log(`${this.nom} ne peut pas attaquer en étant mort`);
        }
    }
}

class Mage extends Personnage{
    constructor(nom, intelligence){
        super(nom, 100, 100, 10, 250);
        this.intelligence = intelligence;
    }

    soigner(cible, n){
        if (this.mana >= n){
            this.mana -= n;
            cible.ajouterHp(n*0.3*this.intelligence);
        } else {
            console.log(`${this.nom} n'a pas assez de mana pour soigner ${cible.nom} de ${n*2} hp`);
        }
    }

    bruler(cible, n){
        if (this.mana >= n){
            this.mana -= n;
            cible.retirerHp(n*0.3*this.intelligence);
        } else {
            console.log(`${this.nom} n'a pas assez de mana pour bruler ${cible.nom} de ${n*2} hp`);
        }
    }
}