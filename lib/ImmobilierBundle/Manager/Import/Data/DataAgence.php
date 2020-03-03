<?php

namespace Shanbo\ImmobilierBundle\Manager\Import\Data;


use Shanbo\ImmobilierBundle\Manager\Import\DataSanitize;

class DataAgence extends DataSanitize
{
    protected $agenceName;
    protected $dirname;

    public function __construct($type, $data, $folder)
    {
        if($type == 0){
            $this->setAgenceName($this->capitalize($data[0]));
        }else{
            if($data->RS_AGENCE == ""){
                $this->setAgenceName($folder);
            }else{
                $this->setAgenceName($this->capitalize($data->RS_AGENCE));
            }

        }

        $this->setDirname($folder);

    }

    /**
     * @return mixed
     */
    public function getAgenceName()
    {
        return $this->agenceName;
    }

    /**
     * @return mixed
     */
    public function getDirname()
    {
        return $this->dirname;
    }

    /**
     * @param mixed $agenceName
     */
    public function setAgenceName($agenceName): void
    {
        $this->agenceName = $agenceName;
    }

    /**
     * @param mixed $dirname
     */
    public function setDirname($dirname): void
    {
        $this->dirname = $dirname;
    }


}
