<?php

namespace App\Services;

use App\Contracts\ShippableInterface;
use App\Contracts\ShippingAdditionalWeightInterface;
use App\Pattern\BubbleWrap;
use App\Pattern\PackingKayu;
use App\Repositories\CompanyCostRepository;
use Exception;
use App\Repositories\RajaongkirCostRepository;

class RajaongkirCostService 
{

    protected $shippable;

    public function __construct(ShippableInterface $shippable){
        $this->shippable = $shippable;
    }

    public function execute($postfields){
        
        $postfields = $this->shippable->validate($postfields);

        $postfields['weight'] = $this->shippable->setAdditionalWeight(new PackingKayu($postfields['weight']));

        $response = $this->shippable->getCost($postfields);

        return $response;
    }
    
    
}


