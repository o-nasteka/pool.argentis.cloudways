<?php

namespace App\Services\KeyCrm;

use Illuminate\Support\Facades\Log;

trait KeyCrmService
{
    /**
     * @param $data
     * @param $action
     * @param string $actionName
     */
    public static function sendData($data, $action, $actionName = ''){
        $apiToken   = config('services.keycrm.api_token');
        $url        = config('services.keycrm.url');

        // send data to key_crm server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . $action);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-type: application/json",
                "Accept: application/json",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                'Authorization:  Bearer ' . $apiToken)
        );
        $result = curl_exec($ch);

        if(config('services.keycrm.log')) {
            Log::channel('keycrm')->info("*** Send data $actionName result ***");
            Log::channel('keycrm')->info($result);
            Log::channel('keycrm')->info("*** Send data $actionName result END ***");
        }

        curl_close($ch);
    }
}
