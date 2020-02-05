<?php

namespace App\Manager\ImportData\Data;


interface Data
{
    public function __construct($type, $data);
}
