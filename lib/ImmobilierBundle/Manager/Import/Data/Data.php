<?php

namespace Shanbo\ImmobilierBundle\Manager\ImportData\Data;


interface Data
{
    public function __construct($type, $data);
}
