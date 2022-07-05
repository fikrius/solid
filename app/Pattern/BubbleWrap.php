<?php

namespace App\Pattern;

use App\Contracts\MeasurableInterface;
use App\Contracts\ShippingAdditionalWeightInterface;
use Exception;

class BubbleWrap implements ShippingAdditionalWeightInterface, MeasurableInterface
{

    const ADDITIONAL_WEIGHT_IN_GRAM = 300;

    protected $weight, $length;

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

}
