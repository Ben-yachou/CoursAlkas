<?php

class MaDate
{
    private int $_annee;
    private int $_mois;
    private int $_jour;

    public function __construct(int $annee, int $mois, int $jour)
    {
        $this->setAnnee($annee);
        $this->setMois($mois);
        $this->setJour($jour);
    }

    /** getters */
    public function getAnnee(): int
    {
        return $this->_annee;
    }
    public function getMois(): int
    {
        return $this->_mois;
    }
    public function getJour(): int
    {
        return $this->_jour;
    }

    /** setters */
    public function setAnnee($annee): void
    {
        if ($annee >= 1 && $annee <= 9999) {
            $this->_annee = $annee;
        } else {
            //façon d'envoyer une erreur via trigger_error
            //https://www.php.net/manual/fr/function.trigger-error.php
            //trigger_error("Annee invalide (doit être entre 1 et 9999)");
            //pour utiliser les Exception (gestion d'erreur façon objet)
            //https://www.php.net/manual/fr/language.exceptions.php
            //throw new Exception("Annee invalide (doit être entre 1 et 9999)");
            echo "Erreur annee invalide : doit être entre 1 et 9999";
        }
    }

    public function setMois($mois): void
    {
        if ($mois >= 1 && $mois <= 12) {
            $this->_mois = $mois;
            //isset($this->_jour) nous permet de savoir si le jour est déjà initialisé, ce qui ne serait pas le cas uniquement dans le constructeur
            if (isset($this->_jour) && $this->getJour() > $this->getJourMax()) {
                echo "Erreur jour invalide : le jour doit être inférieur à " . $this->getJourMax();
            }
        } else {
            echo "Erreur mois invalide : doit être entre 1 et 12";
        }
    }

    public function setJour($jour): void
    {
        if ($jour >= 1 && $jour <= $this->getJourMax()) {
            $this->_jour = $jour;
        } else {
            echo "Erreur jour invalide doit être entre 1 et " . $this->getJourMax();
        }
    }

    /** incrémenteurs */
    //fait passer la date stockée à l'année suivante
    public function anneeSuivante(): void
    {
        $this->setAnnee($this->getAnnee() + 1);
    }

    //fait passer la date stockée au mois suivant
    public function moisSuivant(): void
    {
        //si on est en décembre
        if ($this->getMois() === 12) {
            //on change d'année
            $this->anneeSuivante();
            //et on passe à janvier
            $this->setMois(1);
        } else {
            //sinon on se contente de passer au mois suivant
            $this->setMois($this->getmois() + 1);
        }
    }

    //fait passer la date stockée au jour suivant
    public function jourSuivant(): void
    {
        //si on est à la fin du mois
        if ($this->getJour() === $this->getJourMax()) {
            //et on règle à 1
            $this->setJour(1);
            //on passe au mois suivant
            $this->moisSuivant();
        } else {
            $this->setJour($this->getJour() + 1);
        }
    }

    /** décrémenteurs */

    public function anneePrecedente(): void
    {
        $this->setAnnee($this->getAnnee() - 1);
    }

    public function moisPrecedent(): void
    {
        if ($this->getMois() === 1) {
            $this->anneePrecedente();
            $this->setMois(12);
        } else {
            $this->setMois($this->getMois() - 1);
        }
    }

    public function jourPrecedent(): void
    {
        if ($this->getJour() === 1) {
            $this->moisPrecedent();
            $this->setJour($this->getJourMax());
        } else {
            $this->setJour($this->getJour() - 1);
        }
    }

    //une constante privée n'est accessible que dans la classe
    private const _JOURS_MOIS = [1 => 31, 2 => 28, 3 => 31, 4 => 30, 5 => 31, 6 => 30, 7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31];
    //renvoie le jour max du mois stocké selon le tableau JOURS_MOIS, gère l'année bissextile en février
    public function getJourMax(): int
    {
        //on gère le février bissextile
        if ($this->anneeEstBissextile() && $this->getMois() === 2) {
            return 29;
        } else {
            //sinon on renvoie juste la valeur stockée dans notre tableau
            return self::_JOURS_MOIS[$this->getMois()];
        }
    }

    //renvoie true si l'année stockée est bissextile
    public function anneeEstBissextile(): bool
    {
        //soit divisible par 4 et pas par 100, soit divisible par 400
        return $this->getAnnee() % 4 === 0 && ($this->getAnnee() % 100 !== 0 || $this->getAnnee() % 400 === 0);
    }

    public function __toString(): string
    {
        //sprintf permet de formater une string "proprement", en précisant d'abord le format auquel nos données vont être affichées, puis en précisant quelles données vont être placées dans la string, selon le format précisé
        //%d permet de réserver un espace pour un nombre, %s permet de réserver un espace pour une string, etc
        // https://www.php.net/manual/fr/function.sprintf.php
        //pour la gestion des nombres, on peut ajouter 0n devant le d, faisant %0nd pour préfixer de 0 jusqu'à atteindre n chiffres, par exemple %02d avec une valeur de 1 donnera 01 
        return sprintf('%d-%02d-%02d', $this->getAnnee(), $this->getMois(), $this->getJour());
    }

    private const _NOMS_JOURS = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi',];
    public function nomJour(): string
    {
        return self::_NOMS_JOURS[$this->ordinal()];
    }

    /*
    ANCIENNE TECHNIQUE - pas bien
    //Pour trouver le jour de la semaine, il nous faut récupérer le nombre de jours écoulés entre une référence et notre date puis appliquer un modulo 
    //pour ça il faut compter tous les jours avant la date stockée

    //ici on compte les jours jusqu'à l'année stockée
    private function joursAvantAnnee(): int
    {
        $annee = $this->getAnnee() - 1;
        //nombre de jours en comptant les années bissextiles
        return $annee * 365 + intdiv($annee, 4) - intdiv($annee, 100) + intdiv($annee, 400);
    }

    //ici on compte les mois jusqu'au mois stocké
    private function joursAvantMois(): int
    {
        $compte_jours = 0;
        //pour chaque nombre de jours dans le mois 
        foreach (self::_JOURS_MOIS as $mois => $nb_jours) {
            //on s'arrête si on est arrivé au mois cible
            if ($mois === $this->getMois()) {
                break;
            }
            //sinon on ajoute le nb de jours dans le mois
            $compte_jours += $nb_jours;
        }
        //on ajoute 1 jour supplémentaire si on a dépassé février et qu'on est en année bissextile
        if ($this->getMois() > 2 && $this->anneeEstBissextile()) {
            $nb_jours++;
        }

        //on renvoie ensuite le total de jours
        return $nb_jours;
    }
    */

    //renvoie le numéro du jour de la semaine
    public function ordinal(): int
    {
        //formule de Xiang-Sheng Wang, université Southeast Missouri State, https://ia801006.us.archive.org/10/items/arxiv-1404.2510/1404.2510.pdf
        $a0 = $this->getAnnee() % 10; //dernier chiffre de l'année
        $a1 = ($this->getAnnee() % 100 - $a0) / 10; //Avant dernier chiffre de l'année
        $c = intdiv($this->getAnnee(), pow(10, intval(log10($this->getAnnee())) - 2 + 1)); //premier et deuxième chiffres de l'année
        $aSoustraire = intval($this->anneeEstBissextile() && $this->getMois() <= 2);
        $wd = (7 + (($this->getJour() - $this->joursNuls() + $a0  - $a1  + floor($a0 / 4 - $a1 / 2) - (2 * ($c % 4)) - $aSoustraire) % 7)) % 7;
        return $wd;
    }

    //renvoie le nombre de jours à soustraire selon le mois
    private function joursNuls(): int
    {
        $jours_nuls = [1 => 1, 3 => 5, 5 => 7, 7 => 9, 9 => 3, 2 => 12, 4 => 2, 6 => 4, 8 => 6, 10 => 8, 12 => 10, 11 => 12];
        return $jours_nuls[$this->getMois()];
    }

    private const _NOM_MOIS = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    //renvoie le mois en toute lettre
    public function nomMois(): string
    {
        return self::_NOM_MOIS[$this->getMois() - 1];
    }

    //fait un echo de la date au  format Jour le numJour Mois annee
    public function afficher(): void
    {
        echo sprintf("%s, le %d %s %d", $this->nomJour(), $this->getJour(), $this->nomMois(), $this->getAnnee());
    }
}

$dateDuJour = new MaDate(1113, 5, 10);
$dateDuJour->afficher();
