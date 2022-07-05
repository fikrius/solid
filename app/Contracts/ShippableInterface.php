<?php

namespace App\Contracts;
use Exception;

interface ShippableInterface
{   

    public function validate($postfields);

    public function getCost($postfields);

    public function setAdditionalWeight($weight);

}
