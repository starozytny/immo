<?php

namespace Shanbo\ImmobilierBundle\Manager\Import\Data;


interface Data
{
    public function __construct($type, $data);
}
