<?php
class Personne
{
    protected string $_prenom;
    protected string $_nom;
    protected DateTime $_ddn;

    //dans les paramètres d'une fonction, on peut préciser le type des données attendues en guise d'indication pour le développeur
    //Le typage n'est pas forcé par php ce qui fait qu'on peut mettre un nombre à la place d'une string (vu que l'un peut être converti en l'autre de façon triviale)
    //cependant il nous empêchera de mettre une string à la place d'un objet DateTime par exemple, et renverra une erreur
    public function __construct(string $prenom, string $nom, DateTime $ddn)
    {
        $this->_prenom = $prenom;
        $this->_nom = $nom;
        $this->_ddn = $ddn;
    }

    //en mettant : string après la déclaration d'une fonction, on peut en préciser le type de retour
    //c'est à dire qu'on indique que notre méthode __toString() renverra une donnée de type string 
    public function __toString(): string
    {
        return "{$this->_prenom} {$this->_nom} {$this->_ddn->format('Y-m-d')}";
    }
}
