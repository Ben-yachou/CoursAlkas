<?php
require_once('personne.php');

class Eleve extends Personne
{
    private string $_niveau;

    public function __construct(string $prenom, string $nom, DateTime $ddn, string $niveau)
    {
        parent::__construct($prenom, $nom, $ddn);
        $this->_niveau = $niveau;
    }

    //ici avec : int on précise que notre méthode age() renvoie un élément de type int 
    public function age(): int
    {
        //pour gérer le calcul de l'âge, on utilise l'objet DateTime de PHP
        $maintenant = new Datetime(); //on crée la date du jour
        $intervalle = $this->_ddn->diff($maintenant); //on crée la différence entre la date de naissance et la date du jour
        return $intervalle->y; //et on renvoie le nombre d'années de différence
    }

    public function __toString(): string
    {
        return parent::__toString() . " {$this->_niveau}";
    }
}
