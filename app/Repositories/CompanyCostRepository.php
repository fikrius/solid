<?php

namespace App\Repositories;

use Exception;

class CompanyCostRepository extends RajaongkirCostRepository 
{

    public function getCost($postfields){

        return [
            [
                "code" => "J&T",
                "name" => "Jet Express",
                "costs" => [
                    [
                        "service" => "reguler",
                        "description" => "-",
                        "cost" => [
                            [
                                "value" => 2000,
                                "etd" => "3"
                            ]
                        ]
                    ]
                ]
            ]
        ];

    }


}
