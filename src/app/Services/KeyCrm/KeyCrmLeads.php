<?php


namespace App\Services\KeyCrm;


class KeyCrmLeads
{

    use KeyCrmService;

    /**
     * @var string
     */
    private string $actionName = 'Leads';

    /**
     * @param $data_string
     */
    public function sendData($data_string)
    {
        $action     = config('services.keycrm.action_lead');
        KeyCrmService::sendData($data_string, $action, $this->actionName);
    }

    /**
     * @param $data
     * @return array|false
     */
    public function prepareData($data)
    {
        if (isset($data['payment'])){
            return $this->dataWithProduct($data);
        } elseif (isset($data['Name'])) {
            return $this->dataCallback($data);
        }

        return false;
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
    private function dataCallback($data)
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
