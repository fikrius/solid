<?php

namespace App\Contracts;
use Exception;

interface ShippingAdditionalWeightInterface
{   
    public function getWeight();

    public function calculateWeight();

}
