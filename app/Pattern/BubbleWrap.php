<?php

namespace App\Pattern;

use App\Contracts\ShippingAdditionalWeightInterface;
use Exception;

class BubbleWrap implements ShippingAdditionalWeightInterface
{

    const ADDITIONAL_WEIGHT_IN_GRAM = 300;

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

}
