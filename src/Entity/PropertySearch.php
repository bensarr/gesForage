<?php


namespace App\Entity;


class PropertySearch
{
    /*
     * @var string|null
     */
    private $numeroAbonnement;
    /*
     * @var string|null
     */
    private $nomClient;
    /*
     * @var Village|null
     */
    private $village;

    /*
     * @var Compteur|null
     */
    private $compteur;

    public function getNumeroAbonnement()
    {
        return $this->numeroAbonnement;
    }

    /**
     * @param mixed $numeroAbonnement
     */
    public function setNumeroAbonnement($numeroAbonnement): void
    {
        $this->numeroAbonnement = $numeroAbonnement;
    }

    /**
     * @return mixed
     */
    public function getNomClient()
    {
        return $this->nomClient;
    }

    /**
     * @param mixed $nomClient
     */
    public function setNomClient($nomClient): void
    {
        $this->nomClient = $nomClient;
    }

    /**
     * @return mixed
     */
    public function getVillage()
    {
        return $this->village;
    }

    /**
     * @param mixed $village
     */
    public function setVillage($village): void
    {
        $this->village = $village;
    }

    /**
     * @return mixed
     */
    public function getCompteur()
    {
        return $this->compteur;
    }

    /**
     * @param mixed $compteur
     */
    public function setCompteur($compteur): void
    {
        $this->compteur = $compteur;
    }



}