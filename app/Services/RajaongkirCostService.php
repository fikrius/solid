<?php

namespace App\Services;
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
        $response = $this->rajaongkirCostRepository->getCost($postfields);

        return $response;
    }

}
