<?php

namespace Shanbo\ImmobilierBundle\Manager\ImportData\Data;


use Shanbo\ImmobilierBundle\Manager\ImportData\DataSanitize;

class DataCommodite extends DataSanitize implements Data
{

    protected $hasAscenceur;
    protected $hasCave;
    protected $hasInterphone;
    protected $hasGardien;
    protected $hasTerrasse;
    protected $hasClim;
    protected $hasPiscine;
    protected $nbParking;
    protected $nbBox;

    public function __construct($type, $data)
    {
        if($type == 0){
            $this->hasAscenceur         = $data[40];
            $this->hasCave              = $data[41];
            $this->hasInterphone        = $data[45];
            $this->hasGardien           = $data[46];
            $this->hasTerrasse          = $data[47];
            $this->hasClim              = $data[63];
            $this->hasPiscine           = $data[64];
            $this->nbParking            = $data[42];
            $this->nbBox                = $data[43];
        }else{
            $this->hasAscenceur         = $data->ASCENSEUR;
            $this->hasCave              = $data->NB_CAVES;
            $this->hasInterphone        = $data->INTERPHONE;
            $this->hasGardien           = $data->GARDIEN;
            $this->hasTerrasse          = $data->TERRASSE;
            $this->hasClim              = $data->CLIMATISATION;
            $this->hasPiscine           = $data->PISCINE;
            $this->nbParking            = (int) $data->NB_PARK_INT + (int) $data->NB_PARK_EXT;
            $this->nbBox                = (int) $data->GARAGE_BOX;
        }

        $this->setHasAscenceur($this->convertToTrilean($this->hasAscenceur));
        $this->setHasCave($this->convertToTrilean($this->hasCave));
        $this->setHasInterphone($this->convertToTrilean($this->hasInterphone));
        $this->setHasGardien($this->convertToTrilean($this->hasGardien));
        $this->setHasTerrasse($this->convertToTrilean($this->hasTerrasse));
        $this->setHasClim($this->convertToTrilean($this->hasClim));
        $this->setHasPiscine($this->convertToTrilean($this->hasPiscine));
    }

    /**
     * @return mixed
     */
    public function getHasAscenceur()
    {
        return $this->hasAscenceur;
    }

    /**
     * @param mixed $hasAscenceur
     */
    public function setHasAscenceur($hasAscenceur): void
    {
        $this->hasAscenceur = $hasAscenceur;
    }

    /**
     * @return mixed
     */
    public function getHasCave()
    {
        return $this->hasCave;
    }

    /**
     * @param mixed $hasCave
     */
    public function setHasCave($hasCave): void
    {
        $this->hasCave = $hasCave;
    }

    /**
     * @return mixed
     */
    public function getHasInterphone()
    {
        return $this->hasInterphone;
    }

    /**
     * @param mixed $hasInterphone
     */
    public function setHasInterphone($hasInterphone): void
    {
        $this->hasInterphone = $hasInterphone;
    }

    /**
     * @return mixed
     */
    public function getHasGardien()
    {
        return $this->hasGardien;
    }

    /**
     * @param mixed $hasGardien
     */
    public function setHasGardien($hasGardien): void
    {
        $this->hasGardien = $hasGardien;
    }

    /**
     * @return mixed
     */
    public function getHasTerrasse()
    {
        return $this->hasTerrasse;
    }

    /**
     * @param mixed $hasTerrasse
     */
    public function setHasTerrasse($hasTerrasse): void
    {
        $this->hasTerrasse = $hasTerrasse;
    }

    /**
     * @return mixed
     */
    public function getHasClim()
    {
        return $this->hasClim;
    }

    /**
     * @param mixed $hasClim
     */
    public function setHasClim($hasClim): void
    {
        $this->hasClim = $hasClim;
    }

    /**
     * @return mixed
     */
    public function getHasPiscine()
    {
        return $this->hasPiscine;
    }

    /**
     * @param mixed $hasPiscine
     */
    public function setHasPiscine($hasPiscine): void
    {
        $this->hasPiscine = $hasPiscine;
    }

    /**
     * @return int
     */
    public function getNbParking()
    {
        return $this->nbParking;
    }

    /**
     * @param int $nbParking
     */
    public function setNbParking($nbParking): void
    {
        $this->nbParking = $nbParking;
    }

    /**
     * @return int
     */
    public function getNbBox()
    {
        return $this->nbBox;
    }

    /**
     * @param int $nbBox
     */
    public function setNbBox($nbBox): void
    {
        $this->nbBox = $nbBox;
    }

}
