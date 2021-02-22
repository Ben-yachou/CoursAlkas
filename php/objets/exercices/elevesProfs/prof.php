<?php
require_once('personne.php');

class Prof extends Personne
{
    private string $_matiere;

    public function __construct(string $prenom, string $nom, DateTime $ddn, string $matiere)
    {
        parent::__construct($prenom, $nom, $ddn);
        $this->_matiere = $matiere;
    }

    public function __toString(): string
    {
        return parent::__toString() . " {$this->_matiere}";
    }
}
