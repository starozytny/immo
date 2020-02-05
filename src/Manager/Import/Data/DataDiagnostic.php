<?php

namespace App\Manager\ImportData\Data;


use App\Manager\ImportData\DataSanitize;
use function Complex\theta;

class DataDiagnostic extends DataSanitize implements Data
{

    protected $dpeval;
    protected $dpelettre;
    protected $gesval;
    protected $geslettre;

    public function __construct($type, $data)
    {
        if($type == 0){
            $this->dpeval               = $data[175];
            $this->dpelettre            = $data[176];
            $this->gesval               = $data[177];
            $this->geslettre            = $data[178];
        }else{
            $this->dpeval               = (int) $data->DPE_VAL1;
            $this->dpelettre            = $data->DPE_ETIQ1;
            $this->gesval               = (int) $data->DPE_VAL2;
            $this->geslettre            = $data->DPE_ETIQ2;

            $this->setGeslettre($this->setToNullIfEmpty($this->geslettre));
            $this->setDpelettre($this->setToNullIfEmpty($this->dpelettre));

            if($this->dpelettre == null && $this->getDpelettre() == 0){
                $this->setDpeval(null);
            }

            if($this->geslettre == null && $this->getGesval() == 0){
                $this->setGesval(null);
            }
        }
        if($this->dpelettre == "V"){
            $this->setDpelettre('VI');
        }
        if($this->dpelettre == "Y" or $this->dpelettre == "X" or $this->dpelettre == "Z"){
            $this->setDpelettre('NS');
        }

        if($this->geslettre == "V"){
            $this->setGeslettre('VI');
        }
        if($this->geslettre == "Y" or $this->geslettre == "X" or $this->geslettre == "Z"){
            $this->setGeslettre('NS');
        }
    }

    /**
     * @return int
     */
    public function getDpeval()
    {
        return $this->dpeval;
    }

    /**
     * @param int $dpeval
     */
    public function setDpeval($dpeval): void
    {
        $this->dpeval = $dpeval;
    }

    /**
     * @return mixed
     */
    public function getDpelettre()
    {
        return $this->dpelettre;
    }

    /**
     * @param mixed $dpelettre
     */
    public function setDpelettre($dpelettre): void
    {
        $this->dpelettre = $dpelettre;
    }

    /**
     * @return int
     */
    public function getGesval()
    {
        return $this->gesval;
    }

    /**
     * @param int $gesval
     */
    public function setGesval($gesval): void
    {
        $this->gesval = $gesval;
    }

    /**
     * @return mixed
     */
    public function getGeslettre()
    {
        return $this->geslettre;
    }

    /**
     * @param mixed $geslettre
     */
    public function setGeslettre($geslettre): void
    {
        $this->geslettre = $geslettre;
    }

}
