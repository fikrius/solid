<?php

namespace App\Pattern;

use App\Contracts\MeasurableInterface;
use App\Contracts\ShippingAdditionalWeightInterface;
use App\Contracts\VolumableInterface;
use Exception;

class PackingKayu implements ShippingAdditionalWeightInterface, VolumableInterface
{

    const ADDITIONAL_WEIGHT_IN_GRAM = 3000;

    protected $weight;

    public function __construct($weight){
        $this->weight = $weight;
    }

    public function getWeight(){
        return $this->weight;
    }

    public function calculateWeight(){
        return $this->weight + self::ADDITIONAL_WEIGHT_IN_GRAM;
    }

    public function setLength($length){
        return $this->length = $length;
    }

    public function getLength(){
        return $this->length;
    }

    public function setWidth($width){
        return $this->width = $width;
    }

    public function getWidth(){
        return $this->width;
    }

    public function setHeight($height){
        return $this->height;
    }

    public function getHeight(){
        return $this->height;
    }

}
