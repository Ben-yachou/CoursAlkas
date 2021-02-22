<?php

class Compte {
    private $_nom;
    private $_solde;
    private $_devise; 

    public function __construct($nom, $solde, $devise){
        $this->_nom = $nom;
        $this->_solde = $solde;
        $this->_devise = $devise;
    }

    public function crediter($montant){
        $this->_solde += $montant;
    }

    public function debiter($montant){
        if ($this->_solde < $montant){
            echo "Solde insuffisant";
        } else {
            $this->_solde -= $montant;
        }
    }

    //la méthode __toString() est une des 'méthodes magiques' d'un objet en PHP 
    //cette méthode sera appelée à chaque fois que l'objet devra t être représenté en tant que string 
    //cela permet par exemple de faire echo $notreObjet sans qu'une erreur apparaisse
    public function __toString(){
        //pour implémenter la méthode, il suffit de renvoyer une chaine de caractères 
        //de préférence représentant l'objet en question
        if ($this->_devise === "USD"){
            return $this->_nom. ' $'. $this->_solde;

        }
        if ($this->_devise === "EUR"){
            return $this->_nom. ' '. $this->_solde.'€';
        }
    }
}

$compte = new Compte("Jacques", 150, 'EUR');

//étant donné que __toString() est implémentée, on peut utiliser echo avec notre objet 
echo $compte;

$compte->crediter(100);
echo $compte;

$compte->debiter(2000); //solde insuffisant