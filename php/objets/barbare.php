<?php
//require_once est un include obligatoire mais qui ne doit être importé que s'il n'a pas déjà été importé auparavant
require_once("personnage.php");
//l'héritage se fait à l'aide du mot clé extends
class Barbare extends Personnage {
    //on peut rajouter de nouvelles propriétés par rapport à personnage 
    private $_rage = 100;
    private $_resistance;

    //on peut surcharger (override) une constante déjà existante en la redéfinissant
    const MIN_STR = 3;

    //si on a besoin de préciser de nouveaux attributs dans un construteur, ou définir de nouvelles valeurs a l'instanciation
    //on peut décider d'appeler __construct
    public function __construct($name, $hp, $str, $resistance){
        //pour construire un Barbare, il faut construire un Personnage 
        //on doit donc appeler le constructeur de Personnage, qui est classe parent 
        //parent:: est l'équivalent de super en js
        parent::__construct($name, $hp, $str);
        //maintenant que le constructeur parent a été appelé, on peut attribuer les valeurs à notre Barbare
        $this->_resistance = $resistance;
    }

    //on peut ensuite déterminer les getters/setters de notre classe héritante sans avoir besoin de redéfinir ce qui appartient à Personnage
    public function getRage(){
         return $this->_rage;
    }

    public function getResistance(){
         return $this->_resistance;
    }

    public function setRage($rage){
        $this->_rage = $rage;
    }

    public function setResistance($resistance){
        $this->_resistance = $resistance;
    }
}