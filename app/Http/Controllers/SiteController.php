<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Components\CityHelper;
use App\Components\CourierHelper;
use App\Repositories\CompanyCostRepository;
use App\Repositories\RajaongkirCostRepository;
use App\Services\RajaongkirCostService;

class SiteController extends Controller
{
    protected $rajaongkirCostService;

    public function __construct(){
        $this->rajaongkirCostService = new RajaongkirCostService(new RajaongkirCostRepository);
    }
    
    public function getShippingPrice(Request $request){

        $errors = [];
        $results = ['success' => 0, 'message' => ''];

        $originCitySamples = CityHelper::getSampleOriginCity();
        $destinationCitySamples = CityHelper::getSampleDestinationCity();
        $courierSamples = CourierHelper::getSampleCourier();

        $inputData = $request->input('ShippingPrice');
        if(isset($inputData) && !empty($inputData)){

            try {          
                    
                $response = $this->rajaongkirCostService->execute($inputData);
                if(isset($response)){
                    $results = [
                        'success' => 1, 
                        'message' => 'Sukses get shipping price raja ongkir',
                        'data' => $response
                    ];
                }
                
            } catch (Exception $e) {
                array_push($errors, $e->getMessage());
            }

        }

        return view('getShippingPrice', [
            'errors' => $errors,
            'results' => $results,
            'inputData' => $inputData,
            'originCitySamples' => $originCitySamples,
            'destinationCitySamples' => $destinationCitySamples,
            'courierSamples' => $courierSamples
        ]);
    }

}
