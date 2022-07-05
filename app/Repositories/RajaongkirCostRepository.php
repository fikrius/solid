<?php

namespace App\Repositories;

use App\Components\JsonValidator;
use App\Pattern\BubbleWrap;
use App\Pattern\PackingKayu;
use Exception;

class RajaongkirCostRepository
{

    public function validate($postfields){
        
        if(!isset($postfields['origin']) || empty($postfields['origin']))
            throw new Exception("Kota Asal Kosong");

        if(!isset($postfields['destination']) || empty($postfields['destination']))
            throw new Exception("Kota Tujuan Kosong");
            
        if(!isset($postfields['weight']) || empty($postfields['weight']))
            throw new Exception("Berat Produk Kosong");

        if(!isset($postfields['courier']) || empty($postfields['courier']))
            throw new Exception("Kurir Kosong");

        return $postfields;
    }    

    public function getCost($postfields){

        $postfields = http_build_query($postfields);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: bd313ec5f275bec8cb673f3273a51413"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err)
            throw new Exception("cURL Error #:" . $err);

        $response = JsonValidator::validate($response);

        $response = json_decode($response, true); 
        if(!isset($response['rajaongkir']['results']))
            return null;

        return $response['rajaongkir']['results'];
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
