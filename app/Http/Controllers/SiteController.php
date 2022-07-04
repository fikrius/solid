<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Components\CityHelper;
use App\Components\CourierHelper;

class SiteController extends Controller
{
    
    public function getShippingPrice(Request $request){

        $errors = [];
        $results = ['success' => 0, 'message' => ''];

        $originCitySamples = CityHelper::getSampleOriginCity();
        $destinationCitySamples = CityHelper::getSampleDestinationCity();
        $courierSamples = CourierHelper::getSampleCourier();

        // Cek inputan user
        $inputData = $request->input('ShippingPrice');
        if(isset($inputData) && !empty($inputData)){

            try {          
                
                // Validasi Field
                $originCityId = $inputData['origin_city'];
                if(!isset($originCityId) || empty($originCityId))
                    throw new Exception("Kota Asal Kosong");

                $destinationCityId = $inputData['destination_city'];
                if(!isset($destinationCityId) || empty($destinationCityId))
                    throw new Exception("Kota Tujuan Kosong");
                    
                $weightInGram = $inputData['weight'];
                if(!isset($weightInGram) || empty($weightInGram))
                    throw new Exception("Berat Produk Kosong");

                $courier = $inputData['courier'];
                if(!isset($courier) || empty($courier))
                    throw new Exception("Kurir Kosong");

                $postfields = [
                    'origin' => $originCityId,
                    'destination' => $destinationCityId,
                    'weight' => $weightInGram,
                    'courier' => $courier,
                ];

                $postfields = http_build_query($postfields);

                // Get data shipping method & other data from rajaongkir
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

                $err = true;
                if ($err) {
                    throw new Exception("cURL Error #:" . $err);
                }

                $response = json_decode($response, true); 

                // Validasi JSON
                switch (json_last_error()) {
                    case JSON_ERROR_NONE:
                        $error = '';
                        break;
                    case JSON_ERROR_DEPTH:
                        $error = 'The maximum stack depth has been exceeded.';
                        break;
                    case JSON_ERROR_STATE_MISMATCH:
                        $error = 'Invalid or malformed JSON.';
                        break;
                    case JSON_ERROR_CTRL_CHAR:
                        $error = 'Control character error, possibly incorrectly encoded.';
                        break;
                    case JSON_ERROR_SYNTAX:
                        $error = 'Syntax error, malformed JSON.';
                        break;
                    case JSON_ERROR_UTF8: /* PHP >= 5.3.3 */
                        $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                        break;
                    case JSON_ERROR_RECURSION: /* PHP >= 5.5.0 */
                        $error = 'One or more recursive references in the value to be encoded.';
                        break;
                    case JSON_ERROR_INF_OR_NAN: /* PHP >= 5.5.0 */
                        $error = 'One or more NAN or INF values in the value to be encoded.';
                        break;
                    case JSON_ERROR_UNSUPPORTED_TYPE:
                        $error = 'A value of a type that cannot be encoded was given.';
                        break;
                    default:
                        $error = 'Unknown JSON error occured.';
                        break;
                }

                if (!empty($error))
                    throw new Exception($error);

                // Append Data
                if(isset($response['rajaongkir']['results'])){
                    $results = [
                        'success' => 1, 
                        'message' => 'Sukses get shipping price raja ongkir',
                        'data' => $response['rajaongkir']['results']
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
