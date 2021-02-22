<?php
require_once('eleve.php');
require_once('prof.php');

class Cours
{
    private string $_sujet;
    private DateTime $_date;
    private string $_prof;
    private string $_eleve;

    public function __construct(string $sujet, DateTime $date, Prof $prof, Eleve $eleve)
    {
        $this->_sujet = $sujet;
        $this->_date = $date;
        $this->_prof = $prof;
        $this->_eleve = $eleve;
    }

    public function __toString(): string
    {
        return "{$this->_sujet} {$this->_date->format('Y-m-d')} {$this->_prof} {$this->_eleve}";
    }
}


$prof = new Prof('John', 'Doe', new Datetime('1991-12-19'), 'Chimie');
$eleve = new Eleve('Jane', 'Doe', new Datetime('2000-12-19'), 'Bac');
$cours = new Cours('Chimie organique', new Datetime('2018-01-15'), $prof, $eleve);

echo $cours;
