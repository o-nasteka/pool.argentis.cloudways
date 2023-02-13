<?php

namespace App\Jobs\Webhook;

use App\Models\Lead;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class HandlerForPoolArgentisNano extends ProcessWebhookJob
{

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     *
     */
    public function handle()
    {
        $data = $this->webhookCall['payload'];

        $preparedData = $this->prepareData($data);
        $this->sendData(json_encode($preparedData));

    }

    /**
     * @param $data
     * @return array
     */
    private function prepareData($data)
    {
        $dataPaymentProducts = $data['payment']['products'];

        return $preparedData = [
            "title" => $data['name'] . '_' .$data['phone'], // lead name
            "source_id" => 1, // source id
            "manager_comment" => '',
            "manager_id" => 1, // manager id
            "pipeline_id" => '',
            "contact" => [
                "full_name" => $data['name'],
                "phone" => $data['phone'],
                "email" => $data['email'],
            ],
            "products" => $dataPaymentProducts
        ];
    }

    /**
     * @param $data_string
     */
    private function sendData($data_string)
    {

        // api token
        $token = 'NDk2NjY0ODVlNDhjYjhhODFkOTVhNGQxYmI2MTZiMjFhMjVlMDZkNg';

        // send data to key_crm server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://openapi.keycrm.app/v1/leads");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-type: application/json",
                "Accept: application/json",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                'Authorization:  Bearer ' . $token)
        );
        $result = curl_exec($ch);

        logger($result);

        curl_close($ch);

    }
}
