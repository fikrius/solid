<?php

namespace App\Contracts;
use Exception;

interface MeasurableInterface
{   
    public function setWidth($width);

    public function getWidth();
    
    public function setLength($length);

    public function getLength();

}
