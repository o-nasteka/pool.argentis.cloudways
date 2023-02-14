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
        logger(json_encode($preparedData));
        $this->sendData(json_encode($preparedData));

    }

    /**
     * @param $data
     * @return array
     */
    private function prepareData($data)
    {
        $dataPaymentProducts = $data['payment']['products'];
        $dataPaymentProducts = $this->prepareDataProductsName($dataPaymentProducts);

        $dataCustomFields = $data;
        $dataCustomFields = $this->prepareCustomFields($dataCustomFields);


        return $preparedData = [
            "title" => $data['name'] . '_' .$data['phone'], // lead name
            "source_id" => 1,
            "manager_comment" => '',
            "manager_id" => 1,
            "pipeline_id" => '',
            "contact" => [
                "full_name" => $data['name'],
                "phone" => $data['phone'],
                "email" => $data['email'],
            ],
            "products" => $dataPaymentProducts,
            "custom_fields" => $dataCustomFields
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
                    'value' => $dataCustomFields['payment']['delivery_address']
                ],
                [   'uuid'  => 'LD_1010',
                    'value' => $dataCustomFields['payment']['promocode']
                ],
                [   'uuid'  => 'LD_1011',
                    'value' => $paymentsystem
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
