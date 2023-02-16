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
    public $timeout = 3600;

    /**
     *
     */
    public function handle()
    {
        if(config('services.keycrm.service_enabled')){
            $data = $this->webhookCall['payload'];

            $preparedData = $this->prepareData($data);
            if(config('services.keycrm.log')) {
                logger(json_encode($preparedData));
            }
            $this->sendData(json_encode($preparedData));
        }

    }

    /**
     * @param $data
     * @return array
     */
    private function prepareData($data)
    {
        if (isset($data['payment'])){
            return $this->dataWithProduct($data);
        } else {
           $this->dataCallback();
        }


    }

    /**
     * @param $data
     * @return array
     */
    private function dataWithProduct($data)
    {
        $dataPaymentProducts = $data['payment']['products'];
        $dataPaymentProducts = $this->prepareDataProductsName($dataPaymentProducts);

        $dataCustomFields = $data;
        $dataCustomFields = $this->prepareCustomFields($dataCustomFields);

        return $preparedData = [
            "title"             => '',
            "source_id"         => 1,
            "manager_comment"   => '',
            "manager_id"        => 1,
            "pipeline_id"       => '',
            "contact" => [
                "full_name"     => $data['name']            ?? '',
                "phone"         => $data['phone']           ?? '',
                "email"         => $data['email']           ?? '',
            ],
            "utm_source"        => $data['utm_source']      ?? '-',
            "utm_medium"        => $data['utm_medium']      ?? '-',
            "utm_campaign"      => $data['utm_campaign']    ?? '-',
            "utm_term"          => $data['utm_term']        ?? '-',
            "utm_content"       => $data['utm_content']     ?? '-',
            "products"          => $dataPaymentProducts     ?? '',
            "custom_fields"     => $dataCustomFields        ?? '',
        ];

    }

    /**
     * @return array
     */
    private function dataCallback()
    {
        return $preparedData = [
            "title"             => '',
            "source_id"         => 1,
            "manager_comment"   => '',
            "manager_id"        => 1,
            "pipeline_id"       => '',
            "contact" => [
                "full_name"     => $data['Name']            ?? '',
                "phone"         => $data['Phone']           ?? '',
            ],
            "utm_source"        => $data['utm_source']      ?? '-',
            "utm_medium"        => $data['utm_medium']      ?? '-',
            "utm_campaign"      => $data['utm_campaign']    ?? '-',
            "utm_term"          => $data['utm_term']        ?? '-',
            "utm_content"       => $data['utm_content']     ?? '-',
        ];
    }

    /**
     * @param $data_string
     */
    private function sendData($data_string)
    {

        // api token
        $apiToken   = config('services.keycrm.api_token');
        $url        = config('services.keycrm.url');
        $action     = config('services.keycrm.action_lead');

        // send data to key_crm server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . $action);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
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
            logger($result);
        }

        curl_close($ch);

    }

    /**
     * @param $dataPaymentProducts
     * @return mixed
     */
    private function prepareDataProductsName($dataPaymentProducts)
    {
        $dataPaymentProducts = $this->productNameSpecialCharsDecode($dataPaymentProducts);

        return $dataPaymentProducts;
    }

    /**
     * @param $dataPaymentProducts
     * @return mixed
     */
    private function productNameSpecialCharsDecode($dataPaymentProducts)
    {
        foreach ($dataPaymentProducts as &$dataPaymentProduct)
        {
            $dataPaymentProduct['name'] = htmlspecialchars_decode($dataPaymentProduct['name']);
        }

        return $dataPaymentProducts;
    }

    /**
     * @param $dataCustomFields
     * @return array
     */
    private function prepareCustomFields($dataCustomFields)
    {
        $paymentsystem = $this->setPaymentType($dataCustomFields['paymentsystem']);

        return $dataCustomFields = [
                [   'uuid'  => 'LD_1009',
                    'value' => $dataCustomFields['payment']['delivery_address'] ?? '-'
                ],
                [   'uuid'  => 'LD_1010',
                    'value' => $dataCustomFields['payment']['promocode'] ?? '-'
                ],
                [   'uuid'  => 'LD_1011',
                    'value' => $paymentsystem ?? '-'
                ]
        ];
    }

    /**
     * @param $paymentSystem
     * @return string
     */
    private function setPaymentType($paymentSystem)
    {
        switch ($paymentSystem){
            case 'cash':
                $paymentSystem = 'Післяплата';
                break;
            case 'custom.monobank':
                $paymentSystem = 'Monobank';
                break;
        }

        return $paymentSystem;
    }
}
