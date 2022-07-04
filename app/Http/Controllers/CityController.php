<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CityController extends Controller
{

    public function getCities(Request $request){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: bd313ec5f275bec8cb673f3273a51413"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }

        $data = [];
        $response = json_decode($response, true);
        if(isset($response['rajaongkir']['results'])){
            foreach ($response['rajaongkir']['results'] as $value) {
                if(isset($value['city_id'], $value['city_name'])){
                    $data['results'][] = [
                        'id' => $value['city_id'],
                        'text' => $value['city_name']
                    ];
                }
            }

            $data['pagination']['more'] = true;
        }

        return $data;
    }


}
