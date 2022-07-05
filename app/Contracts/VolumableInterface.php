<?php

namespace App\Contracts;
use Exception;

interface VolumableInterface
{   
    public function setWidth($width);

    public function getWidth();

    public function setHeight($height);

    public function getHeight();

    public function setLength($length);

    public function getLength();

}
