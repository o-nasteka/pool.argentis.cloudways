<?php


namespace App\Services\KeyCrm\Leads;

/**
 * Class KeyCrmCustomFields
 * @package App\Services\KeyCrm\Leads
 */
class KeyCrmCustomFields
{
    /**
     * @var string[]
     */
    private $customParams = [
        'delivery_address'  =>   'LD_1009',
        'promocode'         =>   'LD_1010',
        'payment'           =>   'LD_1011',
    ];

    /**
     * @param $dataCustomFields
     * @return array
     */
    public function prepareCustomFields($dataCustomFields)
    {
        $paymentSystem = KeyCrmPaymentType::setPaymentType($dataCustomFields['paymentsystem']);

        return $dataCustomFields = [
            [   'uuid'  => $this->customParams['delivery_address'],
                'value' => $dataCustomFields['payment']['delivery_address'] ?? '-'
            ],
            [   'uuid'  => $this->customParams['promocode'],
                'value' => $dataCustomFields['payment']['promocode'] ?? '-'
            ],
            [   'uuid'  => $this->customParams['payment'],
                'value' => $paymentSystem ?? '-'
            ]
        ];
    }
}
