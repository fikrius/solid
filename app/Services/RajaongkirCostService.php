<?php

namespace App\Services;

use App\Contracts\ShippingAdditionalWeightInterface;
use App\Pattern\BubbleWrap;
use App\Pattern\PackingKayu;
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

        $postfields['weight'] = $this->setAdditionalWeight(new PackingKayu($postfields['weight']));

        $response = $this->rajaongkirCostRepository->getCost($postfields);

        return $response;
    }

    public function setAdditionalWeight($item){

        $weight = null;
        if($item instanceof BubbleWrap){
            $weight = $item->getWeight() + 300;
        }else if($item instanceof PackingKayu){
            $weight = $item->getWeight() + 100;
        }

        return $weight;
    }
    
    // public function setAdditionalWeight(ShippingAdditionalWeightInterface $item){
    //     return $item->calculateWeight();
    // }
    
}
