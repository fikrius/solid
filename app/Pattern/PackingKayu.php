<?php

namespace App\Pattern;

use App\Contracts\ShippingAdditionalWeightInterface;
use Exception;

class PackingKayu implements ShippingAdditionalWeightInterface
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

}