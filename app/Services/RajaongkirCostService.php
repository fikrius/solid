<?php

namespace App\Services;

use App\Contracts\ShippingAdditionalWeightInterface;
use App\Pattern\BubbleWrap;
use App\Pattern\PackingKayu;
use App\Pattern\PlasticBox;
use App\Repositories\CompanyCostRepository;
use Exception;
use App\Repositories\RajaongkirCostRepository;

class RajaongkirCostService 
{

    protected $rajaongkirCostRepository;

    public function __construct(RajaongkirCostRepository $rajaongkirCostRepository){
        $this->rajaongkirCostRepository = $rajaongkirCostRepository;
    }

    public function execute($postfields){
        
        $postfields = $this->rajaongkirCostRepository->validate($postfields);

        $postfields['weight'] = $this->rajaongkirCostRepository->setAdditionalWeight(new PlasticBox($postfields['weight']));

        $response = $this->rajaongkirCostRepository->getCost($postfields);

        return $response;
    }
    
    
}


