<?php

namespace App\Components;

class CityHelper
{
    
    public static function getSampleOriginCity(){
        return [
            '0' => '-- Pilih --',
            '196' => 'Klaten',
            '305' => 'Nganjuk',
            '306' => 'Ngawi',
            '501' => 'Yogyakarta', 
            '151' => 'Jakarta Barat', 
            '152' => 'Jakarta Pusat'        
        ];
    } 

    public static function getSampleDestinationCity(){
        return [   
            '0' => '-- Pilih --',
            '178' => 'Kediri',
            '181' => 'Kendal',
            '182' => 'Kendari',
            '156' => 'Jambi', 
            '158' => 'Jayapura', 
            '152' => 'Jakarta Pusat',    
        ];
    } 

}
