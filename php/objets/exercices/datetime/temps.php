<?php

class MonTemps
{
    private int $_heure;
    private int $_minute;
    private int $_seconde;

    public function __construct(int $heure, int $minute, int $seconde)
    {
        $this->_heure = $heure;
        $this->_minute = $minute;
        $this->_seconde = $seconde;
    }

    public function getHeure(): int
    {
        return $this->_heure;
    }
    public function getMinute(): int
    {
        return $this->_minute;
    }
    public function getSeconde(): int
    {
        return $this->_seconde;
    }

    public function setHeure(int $heure): void
    {
        if ($heure >= 0 && $heure <= 23) {
            $this->_heure = $heure;
        } else {
            echo "Erreur: heure invalide";
        }
    }

    public function setMinute(int $minute): void
    {
        if ($minute >= 0 && $minute <= 59) {
            $this->_minute = $minute;
        } else {
            echo "Erreur: minute invalide";
        }
    }

    public function setSeconde(int $seconde): void
    {
        if ($seconde >= 0 && $seconde <= 59) {
            $this->_seconde = $seconde;
        } else {
            echo "Erreur: seconde invalide";
        }
    }

    public function heureSuivante(): void
    {
        if ($this->getHeure() === 23) {
            $this->setHeure(0);
        } else {
            $this->setHeure($this->getHeure() + 1);
        }
    }

    public function heurePrecedente(): void
    {
        if ($this->getHeure() === 0) {
            $this->setHeure(23);
        } else {
            $this->setHeure($this->getHeure() - 1);
        }
    }
}
