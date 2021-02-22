<?php

//en Php également, une classe se définit avec le mot clé class
class Personnage {
    //une classe d'objets possède des propriétés qui permettent de définir certaines données
    //ces propriétés ont une niveau de visibilité qui définit la possibilité d'accès aux données 
    //private signifie que l'attribut ne peut être lu que par l'objet lui même, dans le corps de la classe
    private $_hp; //en php, on préfixe les propriétés privées par un _
    private $_str; 
    private $_name; 
    //si on veut définir une valeur par défaut pour une propriété, on peut le faire au moment de la déclaration 
    private $_xp = 0;

    //une constante est une valeur qui est liée à la classe et ne change pas au cours de l'éxécution du code
    const MIN_HP = 0; //$ étant la marque d'une variable, une constante n'en a pas 
    const MIN_STR = 1; //une constante s'écrit toujours en majuscules

    //le constructeur est une fonction spécifique permettant l'instantiation des objets 
    //il est toujours public (le contraire de private) et s'écrit :
    public function __construct($name, $hp, $str){ //le __ devant construct indique que cette fonction est réservée à php
        //$this représente l'objet par rapport à lui même, la -> est l'accesseur de l'objet (équivalent du . en js)

        $this->_name = $name;
        $this->setHp($hp); //on peut utiliser nos setters dans un constructeur de façon à profiter de ses fonctionnalités
        $this->setStr($str);
    }

    //En POO, on utilise des accesseurs et mutateurs (getters & setters)
    //pour pouvoir lire et modifier les attributs privés d'un objet 
    //ces accesseurs et mutateurs permettent, en tant que méthodes, de filtrer et altérer certaines valeurs pour préciser le comportement d'un objet (empêcher de descendre une valeur sous un minimum, calculer une valeur avant de la renvoyer, etc)

    //les getters (accesseurs) sont comme une vitrine permettant de lire nos valeurs mais pas les modifier
    //si on définissait le getter uniquement, la valeur passerait essentiellement en lecture seule
    public function getName(){
        return $this->_name;
    }
    
    public function getHp(){ 
        return $this->_hp;
    }

    public function getStr() {
        return $this->_str;
    }

    public function getXp(){
        return $this->_xp;
    }

    //les setters (mutateurs) servent de "pare-feu" lors de la modification d'une valeur d'un attribut(propriété)
    //ils permettent de placer des conditions sur ces modifications, on peut par exemple empêcher une statistique d'être modifiée en dehors d'un certain intervalle
    public function setHp($hp){
        //si les points de vie cible sont en dessous de 0
        if ($hp < static::MIN_HP){ //pour accéder à une constante, on doit cibler la classe et non l'objet, on utilise donc self:: au lieu de $this->
            //cependant, self ne prend pas en compte l'héritage, et récupère toujours la constante par rapport à la classe qui définit le code (ici, Personnage)
            //pour prendre en compte celui qui appelle la méthode au lieu de prendre en compte celui qui la définit, on utilise static::
            //on les ramène à 0
            $this->_hp = static::MIN_HP;
        } else {
            $this->_hp = $hp;
        }
    }

    public function setStr($str) {
        if ($str < static::MIN_STR){
            $this->_str = static::MIN_STR;
        } else {
            $this->_str = $str;
        }
    }

    public function setXp($xp){
        $this->_xp = $xp;
    }
}